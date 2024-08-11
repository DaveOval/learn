<?php

include "conn.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'];
    $password = $_POST['password'];

    $checkStmt = $conn->prepare("SELECT * FROM usuario WHERE usuario = ?");
    if ( !$checkStmt ) {
        echo 'Error en la preparación de la consulta: ' . htmlspecialchars($conn->error);
        exit();
    }

    $checkStmt->bind_param("s", $user);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        echo 'El usuario ya existe. Por favor, elige otro nombre de usuario.';
        exit();
    }
    
    $checkStmt->close();
    
    //Encriptar la contraseña
    $hashedPassword = password_hash( $password , PASSWORD_DEFAULT);

    //Preparar la consulta
    $stmt = $conn->prepare("INSERT INTO usuario ( usuario , password) VALUES (?, ?)");

    if (!$stmt) {
        echo 'Error en la preparación de la consulta: ' . htmlspecialchars($conn->error);
        exit();
    }

    //Vincular los parámetros
    $stmt->bind_param("ss", $user, $hashedPassword);

    //Ejecutar la consulta
    if ($stmt->execute()) {
        echo 'Registro exitoso';
    } else {
        echo 'Error en la ejecución de la consulta: ' . htmlspecialchars($stmt->error);
    }

    $stmt->close();
}

$conn->close();

?>