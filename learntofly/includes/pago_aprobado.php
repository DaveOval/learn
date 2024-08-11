<?php
// login.php

// Incluir el archivo de configuración
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderID = $_POST['orderID'];
    $payerID = $_POST['payerID'];
    $paymentID = $_POST['paymentID'];
    $id= $_POST['id'];

    // Consulta para verificar el usuario
    $sql = "UPDATE `cobro` SET `orderID`='$orderID',`payerID`='$payerID',`paymentID`='$paymentID',`estado`=1 WHERE `id`=$id ;";
    $result = $conn->query($sql);
    //echo $sql;
    
    echo 'success';
     
    $conn->close();
}
?>