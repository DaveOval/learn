<?php
require_once('../PHPMailer/class.phpmailer.php');

$orderID=$_POST["orderID"];
include 'conn.php';
$sql = "SELECT * FROM `cobro` WHERE `orderID`='$orderID' LIMIT 1;";
$result = $conn->query($sql);
$fila = mysqli_fetch_array($result);
// Vars
/* $name = $_GET["name"];
$email = $_GET["mail"];
$origen = $_GET["origen"];
$destino = $_GET["destino"];
$pasajeros = $_GET["pasajeros"];
$fecha_salida = $_GET["fecha_salida"];
$fecha_regreso = isset($_GET["fecha_regreso"]) ? $_GET["fecha_regreso"] : "";

$adultos = $_GET["adultos"];
$menores = $_GET["ninos"];
$infantes = $_GET["infantes"];

$redondo = isset($_GET["redondo"]) && $_GET["redondo"] === "true"; */

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
$nombreHotel = "confirmacion";
$imagenEncabezado = "../assets/img/d5aec425-e4c4-4c46-a5a9-9f2269ae9de1.jpeg";
$imagenID = $mail->AddEmbeddedImage($imagenEncabezado, 'd5aec425-e4c4-4c46-a5a9-9f2269ae9de1', "d5aec425-e4c4-4c46-a5a9-9f2269ae9de1.jpeg");
//$correo="pinedoerick76@gmail.com";
$correo="gerenciareservaciones@learntoflyoperadora.com.mx";

try {
    //Server settings                   //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'learntoflyoperadora.com.mx';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'cotizaciones@learntoflyoperadora.com.mx';                   //SMTP username
    $mail->Password   = '(%o&F6&f7HQn';                               //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->CharSet = 'UTF-8';                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('cotizaciones@learntoflyoperadora.com.mx', $nombreHotel);
    $mail->addAddress($correo, $nombreHotel);
    $mail->addCC('pagosyfacturacion@learntoflyoperadora.com.mx', 'Cotizaciones'); // Add a CC recipient
    $mail->addCC('direccion@learntoflyoperadora.com.mx', 'Cotizaciones'); // Add a CC recipient

    //Attachments
    /*$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');  */  //Optional name

   
    if ($pasajeros >= 10) {
        $label = 'Cotización para grupo de ';
    } else {
        $label = 'Cotización individual de ';
    }

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->CharSet = "UTF-8";
    $mail->Encoding = "base64";

    $subject = $label . " " . $name . " " . $fecha_salida;
    $mail->Subject = mb_encode_mimeheader($subject, 'UTF-8');

    $mail->Body = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Confirmación de Cotización</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 600px;
                    margin: 20px auto;
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 5px;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                }
                h1, h2, p {
                    margin: 0;
                }
                .header {
                    text-align: center;
                    padding-bottom: 20px;
                    border-bottom: 1px solid #ccc;
                }
                .content {
                    padding: 20px 0;
                }
                .reservation-details {
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    padding: 15px;
                    margin-bottom: 20px;
                }
                .footer {
                    text-align: center;
                    padding-top: 20px;
                    border-top: 1px solid #ccc;
                }
                .logo {
                    display: block;
                    margin: 0 auto;
                    max-width: 100%;
                    height: auto;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <img src="cid:d5aec425-e4c4-4c46-a5a9-9f2269ae9de1" alt="Logo" class="logo">
                    <h1>Confirmacion de pago</h1>
                </div>
                <div class="content">
                    <div class="reservation-details">
                        <p><strong>Folio:</strong> '.$fila['id'].'</p>
                        <p><strong>Nombre:</strong> '.$fila['nombre'].'</p>
                        <p><strong>Descripcion:</strong> '.$fila['descripcion'].'</p>
                        <p><strong>Total:</strong> $'.number_format($fila['monto'],2).'</p>
                        <p><strong>Id de orden:</strong> '.$orderID.'</p>
                        <p><strong>Estatus:</strong> Pagado</p>
                        
                    </div>
                    
                </div>
                <div class="footer">
                </div>
            </div>
        </body>
        </html>
    ';
    $mail->AltBody = 'Cotización';
    // Verificación del cuerpo del correo
    if (empty($mail->Body)) {
        throw new Exception('El cuerpo del correo está vacío');
    }

    
    $mail->send();

    echo 'Messagehasbeensent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>
