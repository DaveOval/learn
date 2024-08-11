<?php
include "conn.php";

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 10; // Número de documentos por página
$offset = ($page - 1) * $limit;

$totalQuery = "SELECT COUNT(DISTINCT r.nombre_comercial) AS total FROM documentos d
               JOIN representantes r ON d.representante_id = r.id";
$result = $conn->query($totalQuery);
$row = $result->fetch_assoc();
$totalRecords = $row['total'];
$totalPages = ceil($totalRecords / $limit);

$query = "SELECT r.nombre_comercial, r.representante_legal, d.tipo_documento, d.fecha_subida, d.nombre_archivo
          FROM documentos d
          JOIN representantes r ON d.representante_id = r.id
          ORDER BY r.nombre_comercial, d.fecha_subida DESC
          LIMIT $limit OFFSET $offset";
$result = $conn->query($query);

if ($result) {
    $documents = [];
    while ($row = $result->fetch_assoc()) {
        $documents[$row['nombre_comercial']]['representante_legal'] = $row['representante_legal'];
        $documents[$row['nombre_comercial']]['documentos'][] = [
            'tipo_documento' => $row['tipo_documento'],
            'fecha_subida' => $row['fecha_subida'],
            'nombre_archivo' => $row['nombre_archivo']
        ];
    }

    // Imprimir documentos
    foreach ($documents as $nombre_comercial => $data) {
        echo "<tr>
                <td colspan='5'>
                    <strong>$nombre_comercial</strong><br>
                    Representante Legal: {$data['representante_legal']}
                </td>
              </tr>";

        $lastDate = '';
        foreach ($data['documentos'] as $doc) {
            if ($lastDate !== $doc['fecha_subida']) {
                if ($lastDate !== '') {
                    echo "<tr><td colspan='5' class='bg-light'></td></tr>"; // Línea separadora
                }
                echo "<tr>
                        <td></td>
                        <td></td>
                        <td colspan='3'><strong>Fecha: " . date('Y-m-d', strtotime($doc['fecha_subida'])) . "</strong></td>
                      </tr>";
                $lastDate = $doc['fecha_subida'];
            }
            echo "<tr>
                    <td></td>
                    <td></td>
                    <td>{$doc['tipo_documento']}</td>
                    <td>" . date('Y-m-d', strtotime($doc['fecha_subida'])) . "</td>
                    <td>
                        <a href='descargar.php?archivo={$doc['nombre_archivo']}' class='btn btn-primary btn-sm'>Descargar</a>
                    </td>
                  </tr>";
        }
    }

    // Imprimir paginación
    echo "<nav>
            <ul class='pagination'>";
    
    // Enlace de página anterior
    echo "<li class='page-item" . ($page <= 1 ? " disabled" : "") . "'>
            <a class='page-link' href='#' onclick='cambiar_vista_ver_archivos(" . ($page - 1) . ")'>&laquo; Anterior</a>
          </li>";

    // Enlaces de páginas
    for ($i = 1; $i <= $totalPages; $i++) {
        echo "<li class='page-item" . ($i == $page ? " active" : "") . "'>
                <a class='page-link' href='#' onclick='cambiar_vista_ver_archivos($i)'>$i</a>
              </li>";
    }

    // Enlace de página siguiente
    echo "<li class='page-item" . ($page >= $totalPages ? " disabled" : "") . "'>
            <a class='page-link' href='#' onclick='cambiar_vista_ver_archivos(" . ($page + 1) . ")'>Siguiente &raquo;</a>
          </li>";

    echo "  </ul>
          </nav>";
} else {
    echo "<tr><td colspan='5'>Error al recuperar documentos: " . $conn->error . "</td></tr>";
}
?>
