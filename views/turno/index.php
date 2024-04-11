<h1 class="nombre-pagina">Nuevo Turno</h1>
<p class="descripcion-pagina">Elige tu servicio y coloca tus datos</p>

<?php 
    include_once __DIR__ . '/../templates/barra.php'; 
?>

<div id="app">
    <nav class="tabs">
    <button class="actual" type="button" data-paso="1">Servicios</button>
    <button type="button" data-paso="2">Información Turno</button>
    <button type="button" data-paso="3">Resumen</button>
    </nav>

    <div class="seccion" id="paso-1">
        <h2>Servicios</h2>
        <p class="text-center">Elige tu servicio a continuación</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>

    <div class="seccion" id="paso-2">
        <h2>Tus Datos y Turno</h2>
        <p class="text-center">Coloca tus datos y fecha del turno</p>
        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input 
                    type="text"
                    id="nombre"
                    name="nombre"
                    placeholder="Tu Nombre"
                    value="<?php echo $nombre; ?>"
                    disabled
                />
            </div>

            <div class="campo">
                <label for="fecha">Fecha</label>
                <input 
                    type="date"
                    id="fecha"
                    name="fecha"
                    min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>"
                />
            </div>

            <div class="campo">
                <label for="hora">Hora</label>
                <input 
                    type="time"
                    id="hora"
                    name="hora"
                />
            </div>
            <input type="hidden" id="id" value="<?php echo $id; ?>">
        </form> 
    </div>

    <div class="seccion contenido-resumen" id="paso-3">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que tu información sea correcta</p>
    </div>

    <div class="paginacion">
        <button
            id="anterior"
            class="boton"
        >&laquo; Anterior</button>

        <button
            id="siguiente"
            class="boton"
        >Siguiente &raquo;</button>
    </div>
    
</div>

<?php 
    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
    "; 
?>
