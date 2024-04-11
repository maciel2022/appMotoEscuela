<h1 class="nombre-pagina">Olvide Contraseña</h1>
<p class="descripcion-pagina">Recupera tu Contraseña escribiendo tu e-mail a continuación</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php"; 
?> 

<form class="formulario" method="POST" action="/olvide">
    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email"
            id="email"
            placeholder="Tu Email"
            name="email"
        >
    </div>

    <input type="submit" class="boton" value="Enviar Instrucciones">
</form>

<div class="acciones">
    <a href="/">Ya tenes una cuenta? Iniciar Sesión.</a>
    <a href="/crear-cuenta">Aún no tenes una cuenta? Crear una nueva.</a> 
</div>