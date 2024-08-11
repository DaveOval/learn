<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos Subidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKzj..." crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
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
        .table {
            margin-top: 20px;
        }
        .table th {
            background-color: #343a40;
            color: #ffffff;
        }
        .pagination {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container-fluid">
            <span class="navbar-text">
                <h1 class="card-title">Documentos Subidos</h1>
            </span>
            <div>
                <button onclick="cambiar_vista_home()" class="btn btn-success">Inicio</button>
                <button onclick="cambiar_vista_subir_archivo()" class="btn btn-success">Subir Documentos</button>
            </div>
        </div>
    </nav>

    <div class="container">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">Nombre Comercial</th>
                    <th scope="col">Representante Legal</th>
                    <th scope="col">Tipo de Documento</th>
                    <th scope="col">Fecha de Subida</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody id="documents-body">
                <!-- Los registros se cargarán aquí mediante AJAX -->
            </tbody>
        </table>
        <nav>
            <ul class="pagination" id="pagination-links">
                <!-- Los enlaces de paginación se generarán aquí -->
            </ul>
        </nav>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function cambiar_vista_ver_archivos(page = 1){
            $.ajax({
                url: `includes/view_files.php?page=${page}`, // URL de tu archivo PHP
                type: 'GET', // Método HTTP para la solicitud (puede ser GET o POST según lo que necesites)
                dataType: 'html', // Tipo de datos esperado en la respuesta
                success: function(response) {
                    $('#documents-body').html(response); // Mostrar la respuesta en el tbody con id "documents-body"
                },
                error: function(xhr, status, error) {
                    console.error('Error al abrir el archivo PHP:', error); // Manejar errores
                }
            });
        }

        // Cargar la vista por defecto (página 1) al inicio
        $(document).ready(function() {
            cambiar_vista_ver_archivos(1);
        });
    </script>
</body>
</html>
