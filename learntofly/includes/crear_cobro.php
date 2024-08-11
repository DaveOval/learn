<?php
// login.php

// Incluir el archivo de configuración
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $monto = $_POST['monto'];
    $comentario = $_POST['comentario'];

    // Consulta para verificar el usuario
    $sql = "INSERT INTO `cobro`( `nombre`, `monto`, `descripcion`) VALUES ('$nombre',$monto,'$comentario');";
    $result = $conn->query($sql);
    //echo $sql;
    
    echo 'success';
     
    $conn->close();
}
?>