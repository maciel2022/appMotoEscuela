let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const turno = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
});

function iniciarApp() {
    mostrarSeccion(); // Mostrar y oculta la seccion
    tabs(); // Cambia la seccion cuando se presionen los tabs
    botonesPaginador(); // Muestra y  oculta los botones de paginacion
    paginaAnterior();
    paginaSiguiente();

    consultarAPI(); // Consulta la API en el backend de PHP

    nombreCliente(); // Añade el nombre del cliente al objeto del turno
    idCliente(); // Añade el id del cliente al objeto del turno
    seleccionarFecha(); // Añade la fecha del turno en el objeto
    seleccionarHora(); // Añade la hora del turno en el objeto

    mostrarResumen(); // muestra el resumen del turno
}

function mostrarSeccion() {

    // Ocultar la seccion que tenga la clas de mostrar
    const seccionAnterior  = document.querySelector('.mostrar');
    if(seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }

    // Seleccionar loa seccion con el paso...
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');

    // Quitar la clase de actual al tab anterior
    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior) {
        tabAnterior.classList.remove('actual');
    }

    // Resaltar el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach( boton => {
        boton.addEventListener('click', function(e){
            paso = parseInt(e.target.dataset.paso);
            mostrarSeccion();
            botonesPaginador();
        });
    });  
}

function botonesPaginador() {
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if(paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    } else if(paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');

        mostrarResumen();
    } else {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();
}

function paginaAnterior() {
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function () {
        if(paso <= pasoInicial) return;
        paso--;
        botonesPaginador();
    });
}

function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function () {
        if(paso >= pasoFinal) return;
        paso++;
        botonesPaginador();
    });
}

async function consultarAPI() {
    try {
        const url = '/api/servicios';
        const resultado = await fetch(url);
        const servicios = await resultado.json();

        mostrarServicios(servicios);

    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios) {
    servicios.forEach( servicio => {
        const { id, nombre, precio } = servicio;
        
        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;
        
        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`;
        
        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function() {
            seleccionarServicio(servicio);
        }

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);
        document.querySelector('#servicios').appendChild(servicioDiv);
    });
}

function seleccionarServicio(servicio) {
    const { id } = servicio;
    const { servicios } = turno;

    // identificar al elemento que se le da click
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    if( servicios.some( agregado => agregado.id === id )) {
        // Eliminarlo
        turno.servicios = servicios.filter( agregado => agregado.id !== id ); // Eliminar del arreglo servicios con la funcion filter()
        divServicio.classList.remove('seleccionado');
    } else {
        // Agregarlo
        turno.servicios = [...servicios, servicio]; // Los ...crea una imagen del arreglo servicios para agregar al servicio que dimos click
        divServicio.classList.add('seleccionado');
    }

    console.log(turno);
}

function idCliente() {
    turno.id = document.querySelector('#id').value;
}

function nombreCliente() {
    turno.nombre = document.querySelector('#nombre').value;
}

function seleccionarFecha() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function(e){
        // Metodo para obtener el numero del dia, 0 = domingo, 1 = lunes etc....
        const dia = new Date(e.target.value).getUTCDay();

        if( [6, 0].includes(dia) ) {
            e.target.value = '';
            mostrarAlerta('Sabados y Domingos no disponibles.', 'error', '.formulario');
        } else {
            turno.fecha =e.target.value;
        }
        
        console.log(inputFecha.value)
    });
}
function seleccionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function(e) {
        const horaCita = e.target.value;
        const  hora = horaCita.split(":")[0];
        console.log(hora);
        if( hora < 8 || hora > 18 ) {
            e.target.value = '';
            mostrarAlerta('Hora no válida.', 'error', '.formulario');
        } else {
            turno.hora = e.target.value;
        }
    });
}

function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {
    // Previene que se genere mas de un alerta
    const alertaPrevia = document.querySelector('.alerta');
    if( alertaPrevia ) {
        alertaPrevia.remove();
    }

    // Scripting para crear la alerta
    const alerta  = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if(desaparece) {
        // Eliminar la alerta
        setTimeout(() => {
            alerta.remove();
        },3000);
    }
}

function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');

    // Limpiar el contenido de Resumen
    while( resumen.firstChild ) {
        resumen.removeChild(resumen.firstChild);
    }

    // Verificamos que no tengas datos vacios, y que tengas seleccionado un servicio
    if( Object.values(turno).includes('') || turno.servicios.length === 0) {
        mostrarAlerta('Faltan datos de Servicios, Fecha u Hora.', 'error', '.contenido-resumen', false);
        
        return;
    } 

    // Formatear el div de resumen
    const { nombre, fecha, hora, servicios } = turno; // Destructuring de turno

    // Heading para Servicios en Resumen
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen de Servicios';
    resumen.appendChild(headingServicios);

    servicios.forEach(servicio =>{
        // Aplicamos Destructuring a servicio, con esto evitamos escribir servicio.id o servicio.nombre y directamente escribimos id o nombre
        const { id, precio, nombre } = servicio; 
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P')
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);
    });

    // Heading para Turno en Resumen
    const headingTurno = document.createElement('H3');
    headingTurno.textContent = 'Resumen de Turno';
    resumen.appendChild(headingTurno);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    // Formatear fecha
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date( Date.UTC(year, mes, dia));

    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const fechaFormateada = fechaUTC.toLocaleDateString('es-AR', opciones);

    const fechaTurno = document.createElement('P');
    fechaTurno.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;
    
    const horaTurno = document.createElement('P');
    horaTurno.innerHTML = `<span>Hora:</span> ${hora} hs.`;



    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar turno';
    botonReservar.onclick = reservarTurno;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaTurno);
    resumen.appendChild(horaTurno);
    resumen.appendChild(botonReservar);
}

async function reservarTurno() {
    
    const { id, fecha, hora, servicios } = turno;

    const idServicios = servicios.map( servicio => servicio.id );

    const datos = new FormData();
    
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuarioId', id);
    datos.append('servicios', idServicios);

    try {
        // Peticion hacia la API
        const url = '/api/turnos';

        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();
        console.log(resultado.resultado);

        if (resultado.resultado) {
            Swal.fire({
                icon: "success",
                title: "Turno Creado",
                text: "Tu turno se creo correctamente",
                button: 'OK'
            }).then(() => {
                setTimeout( () => {
                    window.location.reload();
                }, 1000)          
            })
    }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Hubo un error al crear el turno"
          });
    }


    //console.log([...datos]); // Spread Operator
}