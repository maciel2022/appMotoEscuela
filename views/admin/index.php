<h1 class="nombre-pagina">Panel Administración</h1>

<?php 
    include_once __DIR__ . '/../templates/barra.php'; 
?>

<h2>Buscar Turnos</h2>

<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input 
                type="date"
                id="fecha"
                name="fecha"
                value="<?php echo $fecha; ?>"
            >
        </div>
    </form>
</div>

<?php 
    if(count($turnos) === 0) {
        echo "<h2>No hay Turnos en esta fecha.</h2>";
    }; 
?>

<div class="citas-admin">
    <ul class="turnos">
        <?php 
            $idTurno = 0;
            foreach( $turnos as $key => $turno) {  
                if($idTurno !== $turno->id) { 
                    $total = 0;
        ?>
        <li>
            <p>ID: <span><?php echo $turno->id; ?></span></p>
            <p>Hora: <span><?php echo $turno->hora; ?></span></p>
            <p>Cliente: <span><?php echo $turno->cliente; ?></span></p>
            <p>Email: <span><?php echo $turno->email; ?></span></p>
            <p>Telefono: <span><?php echo $turno->telefono; ?></span></p>

            <h3>Servicios</h3>
        <?php 
                $idTurno = $turno->id;
                } // Fin de if; 
            $total += $turno->precio;
        ?>
            <p class="servicio"><?php echo $turno->servicio . ' - $' . $turno->precio; ?></p>
        <?php 
            $actual = $turno->id;
            $proximo = $turnos[$key + 1]->id ?? 0;
            
            if(esUltimo($actual, $proximo)) { ?>
                <p class="total">Total: <span>$<?php echo $total; ?></span></p>

                <form action="/api/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $turno->id; ?>">
                    <input type="submit" class="boton-eliminar" value="Eliminar">
                </form>
            <?php 
            }
        } // Fin de foreach; ?>
    </ul>    

</div>

<?php 
    $script = "<script src='build/js/buscador.js'></script>"; 
?>