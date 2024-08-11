<?php
// config.php

/* $host = 'localhost'; // Cambia esto a la dirección de tu servidor de base de datos
$db = 'learntof_database'; // Cambia esto al nombre de tu base de datos
$user = 'learntof_admin'; // Cambia esto a tu usuario de base de datos
$pass = 'Uud^-mjs3sIY'; // Cambia esto a tu contraseña de base de datos */

$host = 'localhost'; // Cambia esto a la dirección de tu servidor de base de datos
$db = 'pasarela'; // Cambia esto al nombre de tu base de datos
$user = 'root'; // Cambia esto a tu usuario de base de datos
$pass = ''; // Cambia esto a tu contraseña de base de datos 

// Crear una nueva conexión
$conn = new mysqli($host, $user, $pass, $db);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

//echo "Conexión exitosa";
?>