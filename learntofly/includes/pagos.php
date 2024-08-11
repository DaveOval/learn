<?php
    $id= $_GET['id'];
    include 'conn.php';
    $sql = "SELECT * FROM `cobro` WHERE `id`=$id;";
    $result = $conn->query($sql);

    $sql = "SELECT * FROM `config`;";
    $resultconfig = $conn->query($sql);
    $conn->close();
    $fila = mysqli_fetch_array($result);
    $fila2=mysqli_fetch_array($resultconfig);
    $total=$fila['monto'];
    $client_id=$fila2['clientID'];
    echo '
    <html>
        <head>
            <title>Learn to fly</title>
            <link rel="stylesheet" href="../css/pagos.css">
        </head>
        <body>

        <main class="main">
            <picture class="main_img">
                <img src="../assets/img/d5aec425-e4c4-4c46-a5a9-9f2269ae9de1.jpeg" alt="Logo">
            </picture>
        ';
        if($fila['estado']==0){
        //if(false){
            echo'
            <div class="container_pago">
                <picture>
                    <img src="../assets/img/avion_2.webp" alt="Logo">
                </picture>

                <h2>Resumen del pedido</h2>
                <div class="container_datos">
                    <label for="staticEmail" >Nombre</label>
                    <input type="text" readonly id="staticEmail" value="'.$fila['nombre'].'">
                </div>

                <div class="container_datos">
                    <label for="staticEmail" >Descripcion</label>
                    <input type="text" readonly id="staticEmail" value="'.$fila['descripcion'].'">
                </div>

                <div class="container_datos">
                    <label for="staticEmail" >Total</label>
                    <input type="text" readonly  id="staticEmail" value="$'.number_format($total, 2).'">
                </div>
    
                <div id="paypal-button-container"></div>

            </div>
            <script src="https://www.paypal.com/sdk/js?client-id='.$client_id.'&currency=MXN
            "></script>
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <script src="app.js" data-amount='.$total.' data-id='.$id.' data-nombre="'.$fila['nombre'].'"></script>
            ';
        }else{
            echo'
            <div class="container_pago">

                <picture>
                    <img src="../assets/img/avion_3.webp" alt="Logo">
                </picture>

                <h2>Orden pagada</h2>

                <div class="container_datos">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Nombre</label>
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="'.$fila['nombre'].'">
                </div>
                <div class="container_datos">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Descripcion</label>
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="'.$fila['descripcion'].'">
                </div>
                <div class="container_datos">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Total</label>
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="$'.number_format($total, 2).'">
                </div>
            </div>
            ';

        }
            echo'   
            <div class="footer_img">
                <picture class="footer_img_container" >
                    <img src="../assets/img/1a0a7d6c-5534-4282-9ec8-bc9849d35f0f.jpeg" alt="Logo">
                </picture>
                <picture class="footer_img_container" >
                    <img src="../assets/img/c6d4f330-ff81-4b4c-bb5d-83565661a420.jpeg" alt="Logo">
                </picture>
                <picture class="footer_img_container" >
                    <img src="../assets/img/iata.jpeg" alt="Logo">
                </picture>
            </div>
             </main>
        </body>
    </html>
    ';
?>