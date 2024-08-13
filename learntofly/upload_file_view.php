<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn to Fly</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKzj..." crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
            padding-bottom: 120px;
        }
        .navbar {
            background-color: #343a40;
        }
        .navbar-text h1 {
            color: #ffffff;
            font-size: 1.8rem;
        }
        .btn-success, .btn-info {
            margin-left: 10px;
        }
        .form-label {
            font-weight: 500;
            color: #495057;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .container {
            max-width: 800px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container-fluid">
            <span class="navbar-text">
                <h1 class="card-title">Learn to fly</h1>
            </span>
        </div>
    </nav>

    <div class="container">
        <form id="miFormulario">
            <div class="mb-3">
                <label for="nombre_comercial" class="form-label">Nombre Comercial</label>
                <input type="text" class="form-control" id="nombre_comercial" name="nombre_comercial" required>
            </div>
            <div class="mb-3">
                <label for="representante_legal" class="form-label">Representante Legal</label>
                <input type="text" class="form-control" id="representante_legal" name="representante_legal" required>
            </div>
            <div class="mb-3">
                <label for="domicilio" class="form-label">Domicilio</label>
                <textarea class="form-control" id="domicilio" name="domicilio" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="cp" class="form-label">Código Postal (CP)</label>
                <input type="text" class="form-control" id="cp" name="cp" required>
            </div>
            <div class="mb-3">
                <label for="municipio" class="form-label">Municipio</label>
                <input type="text" class="form-control" id="municipio" name="municipio" required>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <input type="text" class="form-control" id="estado" name="estado" required>
            </div>
            <div class="mb-3">
                <label for="numero_rnt" class="form-label">Número de RNT o Similar</label>
                <input type="text" class="form-control" id="numero_rnt" name="numero_rnt">
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfonos</label>
                <input type="text" class="form-control" id="telefono" name="telefono">
            </div>
            <div class="mb-3">
                <label for="registro_fiscal" class="form-label">Registro fiscal</label>
                <input class="form-control" type="file" id="registro_fiscal" name="registro_fiscal" required accept=".pdf,.jpg,.jpeg,.png">
            </div>
            <div class="mb-3">
                <label for="comprobante_domicilio" class="form-label">Comprobante de domicilio</label>
                <input class="form-control" type="file" id="comprobante_domicilio" name="comprobante_domicilio" required accept=".pdf,.jpg,.jpeg,.png">
            </div>
            <div class="mb-3">
                <label for="rnt" class="form-label">RNT o similar</label>
                <input class="form-control" type="file" id="rnt" name="rnt" required accept=".pdf,.jpg,.jpeg,.png">
            </div>
            <div class="mb-3">
                <label for="ine_frente" class="form-label">INE (Frente)</label>
                <input class="form-control" type="file" id="ine_frente" name="ine_frente" required accept=".pdf,.jpg,.jpeg,.png">
            </div>
            <div class="mb-3">
                <label for="ine_reverso" class="form-label">INE (Reverso)</label>
                <input class="form-control" type="file" id="ine_reverso" name="ine_reverso" required accept=".pdf,.jpg,.jpeg,.png">
            </div>
            <button type="button" onclick="subir_documentos(event)" class="btn btn-primary">Subir Documento</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="js/events.js"></script> 
    <script src="https://www.paypal.com/sdk/js?client-id=AbNIMl1p1ehS_e_Tv7Ozvw_oQjAFAC-JuPiK-foXIlwLXlgmHE13atymtvQybJrmlYiey77AJMJ_44ob&currency=MXN"></script>
    <script src="app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
