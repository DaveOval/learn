const scriptElement = document.currentScript;
const monto = scriptElement.getAttribute('data-amount');
const id = scriptElement.getAttribute('data-id');
const nombre = scriptElement.getAttribute('data-id');
window.paypal
paypal.Buttons({
    createOrder: function(data,actions){
        return actions.order.create({
            purchase_units:[{
                description: "Cotización de : "+nombre ,
                reference_id:id,
                amount:{
                    value:monto
                }
            }]
        });
    },
    onApprove: function(data, actions) {
        return actions.order.capture().then(function(details){
            guardar_orden(data,details)
            
        });
        
    }
        
}).render("#paypal-button-container")

function guardar_orden(datos,details){
    const orderID=details.purchase_units[0].payments.captures[0].id;
    const payerID= datos.payerID;
    const paymentID=datos.paymentID;
    //console.log(id);

    $.ajax({
        url: 'pago_aprobado.php', // URL del archivo PHP que maneja el inicio de sesión
        type: 'POST',
        data: {
            orderID: orderID,
            payerID: payerID,
            paymentID: paymentID,
            id:id
        },
        success: function(response) {
          if (response === 'success') {
              //sessionStorage.setItem('user_id', '76758'); // Redirige a la página deseada
              //ingresar()
              //alert('Cobro registrado con exito');
          } 
        },
        error: function() {
          alert('Error en la solicitud. Por favor, inténtelo de nuevo.');
        }
      });
      $.ajax({
        url: 'mail.php', // URL del archivo PHP que maneja el inicio de sesión
        type: 'POST',
        data: {
            orderID: orderID,
            payerID: payerID,
            paymentID: paymentID,
            id:id
        },
        success: function(response) {
          if (response === 'success') {
              //sessionStorage.setItem('user_id', '76758'); // Redirige a la página deseada
              //ingresar()
              alert('Cobro registrado con exito');
          } 
        },
        error: function() {
          alert('Error en la solicitud. Por favor, inténtelo de nuevo.');
        }
      });
}
