const fecha_ida = document.getElementById("fecha_ida");
const fecha_regreso = document.getElementById("fecha_regreso");


document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    fecha_ida.setAttribute('min', today);
    fecha_regreso.setAttribute('min', today);

    fecha_ida.addEventListener("change" , function() {
        const fechaIdaValue = fecha_ida.value;
        fecha_regreso.setAttribute("min", fechaIdaValue);

        if ( fecha_regreso.value && fecha_regreso.value < fechaIdaValue ) {
            fecha_regreso.value = fechaIdaValue;
        }
    })
});

const btn_vuelo_redondo = document.getElementById("redondo")

btn_vuelo_redondo.addEventListener("change", function () {
    const fecha_regreso = document.getElementById("fecha_regreso");
    if( btn_vuelo_redondo.checked ) {
        fecha_regreso.type = "date";
        fecha_regreso.required = true;
        fecha_regreso.disabled = false;
    } else {
        fecha_regreso.type = "text";
        fecha_regreso.required = false;
        fecha_regreso.disabled = true;
        fecha_regreso.value = "";
    }
})

const input_pasajeros = document.getElementById("pasajeros");

input_pasajeros.addEventListener("click", function() {
    const contenedor_pasajeros = document.getElementById("contanedor_clases");

    if ( contenedor_pasajeros.style.display === "none" || contenedor_pasajeros.style.display === "" ) {
        contenedor_pasajeros.style.display = "flex";
    } else {
        contenedor_pasajeros.style.display = "none";
    }
})

document.addEventListener("click", function(event) {

    const contenedor_pasajeros2 = document.getElementById("contanedor_clases");

    if (contenedor_pasajeros2.style.display === "flex" &&
        !contenedor_pasajeros2.contains(event.target) &&
        event.target !== input_pasajeros) {
        contenedor_pasajeros2.style.display = "none";
    }
});

const actualizarNumeroPasajeros = () => {
    const adultos = parseInt(document.getElementById("adults").value)
    const ninos = parseInt(document.getElementById("kids").value)
    const infantes = parseInt(document.getElementById("childs").value)

    const totalPasajeros = adultos + ninos + infantes;

    input_pasajeros.value = totalPasajeros;

    const inputBtn = document.getElementById("submit_btn");

    if (totalPasajeros > 9) {
        inputBtn.value = "Cotizar por Grupo";
    } else {
        inputBtn.value = "Solicitar cotización";
    }

}

document.getElementById("adults").addEventListener("change", actualizarNumeroPasajeros);
document.getElementById("kids").addEventListener("change", actualizarNumeroPasajeros);
document.getElementById("childs").addEventListener("change", actualizarNumeroPasajeros);

const cotizar = (e) => {
    e.preventDefault();
    console.log("cotizando...")

    const name = document.getElementById("name").value;
    const fecha_salida = document.getElementById("fecha_ida").value;
    const mail = document.getElementById("email").value;
    const fecha_regreso = document.getElementById("fecha_regreso").value;
    const origen = document.getElementById("origen").value;
    const destino = document.getElementById("destination").value;
    //const pasajerosElement = document.querySelector('select[name="pasengers"]')
    //const selectedValue = pasajerosElement.value;
    const redondo = document.getElementById("redondo").checked

    if (!name || !fecha_salida || !mail || !destino || !input_pasajeros.value || !origen) {
        swal("Error", "Por favor, completa todos los campos", "error");
        return; 
    }

    if (redondo && !fecha_salida) {
        swal("Error", "Por favor, completa todos los campos", "error");
        return; 
    }
    
    // Verificar formato de correo electrónico
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(mail)) {
        swal("Error", "Formato de correo electrónico inválido", "error");
        return; 
    }

    if ( !input_pasajeros.value || input_pasajeros.value == 0 ) {
        swal("Error", "Por favor, agregue los pasajeros", "error");
        return; 
    }

    const adultos = document.getElementById("adults").value;
    const ninos = document.getElementById("kids").value;
    const infantes = document.getElementById("childs").value;


    const queryString = `name=${encodeURIComponent(name)}&mail=${encodeURIComponent(mail)}&destino=${encodeURIComponent(destino)}&pasajeros=${encodeURIComponent(input_pasajeros.value)}&fecha_salida=${encodeURIComponent(fecha_salida)}&fecha_regreso=${encodeURIComponent(fecha_regreso)}&redondo=${encodeURIComponent(redondo)}&origen=${encodeURIComponent(origen)}&adultos=${adultos}&ninos=${ninos}&infantes=${infantes}`;
    let xhr = new XMLHttpRequest();

    xhr.open("GET" , `src/php/mail.php?${queryString}` , true);

    xhr.onload = function () {
        if ( xhr.status >= 200 && xhr.status < 300 ) {
            console.log(xhr.responseText);
            swal("Cotizacion solicitada con exito!" , "Hemos recibido tu solicitud!" , "success")
                .then(() => {
                    const whatsappMessage = `
Hola, solicito una cotización con los siguientes detalles:
Nombre de agencia: ${name}
Correo: ${mail}
Origen: ${origen}
Destino: ${destino}
Fecha de salida: ${fecha_salida}
Fecha de regreso: ${fecha_regreso ? fecha_regreso : '-'}
Pasajeros: ${input_pasajeros.value}
Adultos: ${adultos}
Menores: ${ninos}
Infantes: ${infantes}
Viaje redondo: ${redondo ? "Si" : "No"}`;
                    const phoneNumber = "3319532857"
                    const whatsappURL = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(whatsappMessage.trim())}`;
                    window.open(whatsappURL, '_blank');
                })
        } else {
            swal("Error" , "Error al crear tu cotización" , "error");
            console.log("Hubo un error al crear la cotización")
        }
    }

    xhr.onerror = function () {
        console.log("Error de red al intentar crear la reserva")
    }

    xhr.send();


}
