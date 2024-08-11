<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json'); // Cambiar a JSON para la respuesta
include "conn.php"; // Incluye tu archivo de conexión

$response = array('success' => false, 'error' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si los archivos y datos del formulario están presentes
    if (isset($_FILES['registro_fiscal']) && isset($_FILES['comprobante_domicilio']) &&
        isset($_FILES['rnt']) && isset($_FILES['ine_frente']) && isset($_FILES['ine_reverso']) &&
        isset($_POST['nombre_comercial'])) {

        // Recoger datos del formulario
        $nombre_comercial = $_POST['nombre_comercial'];
        $representante_legal = $_POST['representante_legal'];
        $domicilio = $_POST['domicilio'];
        $cp = $_POST['cp'];
        $municipio = $_POST['municipio'];
        $estado = $_POST['estado'];
        $numero_rnt = $_POST['numero_rnt'];
        $telefono = $_POST['telefono'];

        // Verificar si el nombre comercial ya existe
        $stmt = $conn->prepare("SELECT id FROM representantes WHERE nombre_comercial = ?");
        if (!$stmt) {
            $response['error'] = 'Error al preparar la consulta: ' . $conn->error;
            echo json_encode($response);
            exit;
        }

        $stmt->bind_param("s", $nombre_comercial);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $existingId = $row['id'] ?? null;

        if (!$existingId) {
            // Insertar nuevo registro en la base de datos
            $stmt = $conn->prepare("INSERT INTO representantes (nombre_comercial, representante_legal, domicilio, cp, municipio, estado, numero_rnt, telefono) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            if (!$stmt) {
                $response['error'] = 'Error al preparar la consulta de inserción: ' . $conn->error;
                echo json_encode($response);
                exit;
            }

            $stmt->bind_param("ssssssss", $nombre_comercial, $representante_legal, $domicilio, $cp, $municipio, $estado, $numero_rnt, $telefono);

            if (!$stmt->execute()) {
                $response['error'] = 'Error al insertar el nuevo registro: ' . $stmt->error;
                echo json_encode($response);
                exit;
            }

            $existingId = $conn->insert_id; // Obtener el ID del nuevo registro
        }

        // Función para subir archivo
        function subirArchivo($id_representante, $tipoDocumento, $archivo) {
            global $conn;
            $directorioSubida = 'uploads/';
            if (!is_dir($directorioSubida)) {
                mkdir($directorioSubida, 0777, true);
            }

            $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
            $fecha = date('Ymd-His'); // Fecha y hora actual
            $tipoDocumento = str_replace(' ', '_', $tipoDocumento);
            $nombreArchivo = "{$id_representante}-{$tipoDocumento}-{$fecha}.{$extension}";
            $rutaArchivo = $directorioSubida . $nombreArchivo;

            // Verificar que el archivo se haya subido correctamente
            if ($archivo['error'] !== UPLOAD_ERR_OK) {
                error_log('Error al subir archivo ' . $tipoDocumento . ': ' . $archivo['error']);
                return false;
            }

            // Mover el archivo a la carpeta de destino
            if (move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
                $stmt = $conn->prepare("INSERT INTO documentos (representante_id, tipo_documento, nombre_archivo, ruta_archivo) VALUES (?, ?, ?, ?)");
                if (!$stmt) {
                    error_log('Error al preparar la consulta para subir el archivo: ' . $conn->error);
                    return false;
                }

                $stmt->bind_param("isss", $id_representante, $tipoDocumento, $nombreArchivo, $rutaArchivo);
                if (!$stmt->execute()) {
                    error_log('Error al insertar el documento en la base de datos: ' . $stmt->error);
                    return false;
                }
                return true;
            } else {
                error_log('Error al mover el archivo a la carpeta de destino.');
                return false;
            }
        }

        // Subir archivos
        $success = true;
        $success &= subirArchivo($existingId, 'Registro_Fiscal', $_FILES['registro_fiscal']);
        $success &= subirArchivo($existingId, 'Comprobante_de_Domicilio', $_FILES['comprobante_domicilio']);
        $success &= subirArchivo($existingId, 'RNT_o_Similar', $_FILES['rnt']);
        $success &= subirArchivo($existingId, 'INE_Frente', $_FILES['ine_frente']);
        $success &= subirArchivo($existingId, 'INE_Reverso', $_FILES['ine_reverso']);

        if ($success) {
            $response['success'] = true;
            $response['message'] = 'Documentos subidos con éxito';
        } else {
            $response['error'] = 'Error al subir algunos archivos.';
        }
    } else {
        $response['error'] = 'Faltan archivos o datos en la solicitud.';
    }
} else {
    $response['error'] = 'Método de solicitud no permitido.';
}

echo json_encode($response);
?>
