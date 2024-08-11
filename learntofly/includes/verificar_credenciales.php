<?php
// login.php

// Incluir el archivo de configuración
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //var_dump($_POST);
    $user = $_POST['user'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM usuario WHERE usuario = ?");

    if (!$stmt) {
        echo 'Error en la preparación de la consulta: ' . htmlspecialchars($conn->error);
        exit();
    }

    $stmt->bind_param("s", $user);
    
    $stmt->execute();
    $execute_result = $stmt->execute();
        
    // Imprimir el resultado de la ejecución
   
    // Usar bind_result para obtener los resultados
    $stmt->bind_result($id, $hashed_password);
        //$password = "Fly2024.*";

        // Encriptar la contraseña
        //$hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Mostrar el hash resultante

    if ($stmt->fetch()) {
        // Verificar la contraseña

        if (password_verify($password, $hashed_password)) {
            echo 'success';
        } else {
            echo 'fail ';
        }
        //echo $hashed_password;
        // Contraseña ingresada por el usuario

        
        // Hash almacenado en la base de datos (supongamos que este es el hash generado anteriormente)
       // $stored_hashed_password = '$2y$10$gpNxukW6Q/BJzqsgxrv71um4chDUgKOTJoUsENZTVqUpbxkPttlm.';
        
        // Verificar la contraseña
  

    } else {
        echo 'fail';
    }

    $stmt->close();
}

$conn->close();
?>