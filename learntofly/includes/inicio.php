<?php
include 'conn.php';
$sql = "SELECT * FROM `cobro` WHERE `estado`=0;";
$result = $conn->query($sql);
$sql = "SELECT * FROM `cobro` WHERE `estado`=1;";
$resultpagados = $conn->query($sql);
$conn->close();
echo '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestionar Cobros</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKzj..." crossorigin="anonymous">
        <style>
            body {
                background-color: #f8f9fa;
            }
            .navbar {
                background-color: #343a40;
                margin-bottom: 20px;
            }
            .navbar-text h1, .navbar-text h4 {
                color: #ffffff;
            }
            .card {
                margin-bottom: 20px;
            }
            .btn-primary {
                margin-top: 10px;
            }
            .nav-tabs .nav-link.active {
                background-color: #343a40;
                color: #ffffff;
                border-color: #343a40;
            }
            .table th {
                background-color: #343a40;
                color: #ffffff;
            }
            .table tbody tr:hover {
                background-color: #e9ecef;
            }
            .form-control, .btn-primary {
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <nav class="navbar">
            <div class="container-fluid">
                <span class="navbar-text">
                    <h1 class="card-title">Bienvenido!</h1>
                </span>
                <div>
                    <button onclick="cambiar_vista_subir_archivo()" class="btn btn-success">Subir Documentos</button>
                    <button onclick="cambiar_vista_ver_archivos()" class="btn btn-info">Ver Documentos</button>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-sm-7 mb-3 mb-sm-0">
                    <div class="card">
                        <nav class="navbar">
                            <div class="container-fluid">
                                <span class="navbar-text">
                                    <h4 class="card-title">Ver Cobros</h4>
                                </span>
                            </div>
                        </nav>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Pendientes</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Pagados</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Monto</th>
                                                <th scope="col">Comentario</th>
                                                <th scope="col">Enlace</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                                            while ($fila = mysqli_fetch_array($result)) {
                                                echo '
                                                <tr>
                                                    <th scope="row">'.$fila['id'].'</th>
                                                    <td>'.$fila['nombre'].'</td>
                                                    <td>$'.number_format($fila['monto'], 2).'</td>
                                                    <td>'.$fila['descripcion'].'</td>
                                                    <td>
                                                        <button class="btn btn-primary btn-sm" onclick="copiarTexto('.$fila['id'].')">Copiar enlace</button>
                                                        <input type="input" id="textoACopiar'.$fila['id'].'" class="form-control d-none" value="https://learntoflyoperadora.com.mx/learntofly/includes/pagos.php?id='.$fila['id'].'">
                                                    </td>
                                                </tr>';
                                            }
                                        echo '
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Monto</th>
                                                <th scope="col">Comentario</th>
                                                <th scope="col">ID de Orden</th>
                                                <th scope="col">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                                            while ($fila = mysqli_fetch_array($resultpagados)) {
                                                echo '
                                                <tr>
                                                    <th scope="row">'.$fila['id'].'</th>
                                                    <td>'.$fila['nombre'].'</td>
                                                    <td>$'.number_format($fila['monto'], 2).'</td>
                                                    <td>'.$fila['descripcion'].'</td>
                                                    <td>'.$fila['orderID'].'</td>
                                                    <td>Pagado</td>
                                                </tr>';
                                            }
                                        echo '
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="card">
                        <nav class="navbar">
                            <div class="container-fluid">
                                <span class="navbar-text">
                                    <h4 class="card-title">Crear Cobro</h4>
                                </span>
                            </div>
                        </nav>
                        <div class="card-body">
                            <p class="card-text">En este apartado podrá crear un nuevo cobro.</p>
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Nombre:</label>
                                </div>
                                <div class="col-auto">
                                    <input type="input" id="nombre" class="form-control">
                                </div>
                            </div>
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Monto:</label>
                                </div>
                                <div class="col-auto">
                                    <input type="number" id="monto" class="form-control">
                                </div>
                            </div>
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Descripción:</label>
                                </div>
                                <div class="col-auto">
                                    <textarea id="descripcion" class="form-control"></textarea>
                                </div>
                            </div>
                            <a class="btn btn-primary" onclick="crear_cobro()">Crear</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="js/events.js"></script> 
        <script src="https://www.paypal.com/sdk/js?client-id=AbNIMl1p1ehS_e_Tv7Ozvw_oQjAFAC-JuPiK-foXIlwLXlgmHE13atymtvQybJrmlYiey77AJMJ_44ob&currency=MXN"></script>
        <script src="app.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
    </html>
';
?>
