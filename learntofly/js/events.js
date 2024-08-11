function login() {
    var user = document.getElementById("user").value;
    var password = document.getElementById("password").value;
    
    $.ajax({
      url: './includes/verificar_credenciales.php', // URL del archivo PHP que maneja el inicio de sesión
      type: 'POST',
      data: {
        user: user,
        password: password
      },
      success: function(response) {
        console.log(response);
        if (response === 'success') {
            alert("Credenciales correctas")
            sessionStorage.setItem('user_id', '76758'); // Redirige a la página deseada
            ingresar()
        } else {
          alert('Credenciales incorrectas');
        }
      },
      error: function() {
        alert('Error en la solicitud. Por favor, inténtelo de nuevo.');
      }
    });
  }
function ingresar(){
    $.ajax({
        url: './includes/inicio.php', // URL de tu archivo PHP
        type: 'GET', // Método HTTP para la solicitud (puede ser GET o POST según lo que necesites)
        dataType: 'html', // Tipo de datos esperado en la respuesta
        success: function(response) {
            
            $('#result').html(response); // Mostrar la respuesta en el elemento con id "result"
            $('#login').hide();
        },
        error: function(xhr, status, error) {
          console.error('Error al abrir el archivo PHP:', error); // Manejar errores
        }
      });
}  

function cambiar_vista_subir_archivo(){
    $.ajax({
        url: './includes/upload_file_view.php', // URL de tu archivo PHP
        type: 'GET', // Método HTTP para la solicitud (puede ser GET o POST según lo que necesites)
        dataType: 'html', // Tipo de datos esperado en la respuesta
        success: function(response) {
            
            $('#result').html(response); // Mostrar la respuesta en el elemento con id "result"
        },
        error: function(xhr, status, error) {
          console.error('Error al abrir el archivo PHP:', error); // Manejar errores
        }
      });
}
function cambiar_vista_ver_archivos(page = 1){
    $.ajax({
        url: `./includes/vie_files_view.php?page=${page}`, // URL de tu archivo PHP
        type: 'GET', // Método HTTP para la solicitud (puede ser GET o POST según lo que necesites)
        dataType: 'html', // Tipo de datos esperado en la respuesta
        success: function(response) {
            
            $('#result').html(response); // Mostrar la respuesta en el elemento con id "result"
        },
        error: function(xhr, status, error) {
          console.error('Error al abrir el archivo PHP:', error); // Manejar errores
        }
      });
}
function volver_home(){
    $.ajax({
        url: './includes/inicio.php', // URL de tu archivo PHP
        type: 'GET', // Método HTTP para la solicitud (puede ser GET o POST según lo que necesites)
        dataType: 'html', // Tipo de datos esperado en la respuesta
        success: function(response) {
            
            $('#result').html(response); // Mostrar la respuesta en el elemento con id "result"
        },
        error: function(xhr, status, error) {
          console.error('Error al abrir el archivo PHP:', error); // Manejar errores
        }
      });
}
function crear_cobro(){
    var nombre = document.getElementById("nombre").value;
    var monto = document.getElementById("monto").value;
    var comentario= document.getElementById("descripcion").value;
    
    $.ajax({
      url: './includes/crear_cobro.php', // URL del archivo PHP que maneja el inicio de sesión
      type: 'POST',
      data: {
        nombre: nombre,
        monto: monto,
        comentario: comentario
      },
      success: function(response) {
        if (response === 'success') {
            sessionStorage.setItem('user_id', '76758'); // Redirige a la página deseada
            ingresar()
            alert('Cobro registrado con exito');
        } 
      },
      error: function() {
        alert('Error en la solicitud. Por favor, inténtelo de nuevo.');
      }
    });
}

function copiarTexto(id) {
    var texto = document.getElementById('textoACopiar'+id).value;
    navigator.clipboard.writeText(texto)
      .then(function() {
        alert('Texto copiado al portapapeles.');
      })
      .catch(function(err) {
        console.error('Error al copiar el texto: ', err);
      });
}

function subir_documentos(event) {
  event.preventDefault(); // Prevenir el comportamiento por defecto del formulario

  // Obtener datos del formulario
  const nombre_comercial = document.getElementById('nombre_comercial').value;
  const representante_legal = document.getElementById('representante_legal').value;
  const domicilio = document.getElementById('domicilio').value;
  const cp = document.getElementById('cp').value;
  const municipio = document.getElementById('municipio').value;
  const estado = document.getElementById('estado').value;
  const numero_rnt = document.getElementById('numero_rnt').value;
  const telefono = document.getElementById('telefono').value;

  const registro_fiscal = document.getElementById('registro_fiscal').files[0];
  const comprobante_domicilio = document.getElementById('comprobante_domicilio').files[0];
  const rnt = document.getElementById('rnt').files[0];
  const ine_frente = document.getElementById('ine_frente').files[0];
  const ine_reverso = document.getElementById('ine_reverso').files[0];

  // Crear FormData y agregar datos del formulario y archivos
  const data = new FormData();
  data.append('nombre_comercial', nombre_comercial);
  data.append('representante_legal', representante_legal);
  data.append('domicilio', domicilio);
  data.append('cp', cp);
  data.append('municipio', municipio);
  data.append('estado', estado);
  data.append('numero_rnt', numero_rnt);
  data.append('telefono', telefono);
  data.append('registro_fiscal', registro_fiscal);
  data.append('comprobante_domicilio', comprobante_domicilio);
  data.append('rnt', rnt);
  data.append('ine_frente', ine_frente);
  data.append('ine_reverso', ine_reverso);

  // Enviar datos usando Fetch API
  fetch("./includes/upload_file.php", {
    method: 'POST',
    body: data
  })
  .then(response => response.json())
  .then(responseJson  => {
    if (responseJson.success) {
      alert(responseJson.message || 'Documentos subidos con éxito');
      ingresar();
    } else {
        alert('Error: ' + (responseJson.error || 'No se pudo completar la solicitud.'));
    }
  })
  .catch(error => {
    console.error('Error en la solicitud:', error);
    alert('Error en la solicitud. Por favor, inténtelo de nuevo.');
  });
}