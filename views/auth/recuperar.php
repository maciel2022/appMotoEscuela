<h1 class="nombre-pagina">Recuperar Contraseña</h1>
<p class="descripcion-pagina">Coloca tu nueva Contraseña a continuación</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php"; 
?> 

<?php if($error) return; ?>
<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Contraseña</label>
        <input 
            type="password"
            id="password"
            name="password"
            placeholder="Tu nueva Contraseña"
        />
    </div>

    <input type="submit" value="Guardar Nueva Contraseña" class="boton">
</form>

<div class="acciones">
    <a href="/">Ya tenes cuenta? Iniciar Sesión</a>
    <a href="/crear-cuenta">Aún no tenes cuenta? Crear una nueva.</a>
</div>