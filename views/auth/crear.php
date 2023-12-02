<?php include_once __DIR__.'/header.php';?>

<main class="auth">
    <h1 class="nombre-pagina">Crear Cuenta</h1>
    <p class="descripcion-pagina">Llena el siguiente formulario para crear una cuenta</p>

    <?php
    include_once __DIR__ . "/../templates/alertas.php";    
    ?>

    <form class ="formulario__campo" method="POST" action="/crear">
        <div class="formulario__campo">
            <label for="nombre">Nombre</label>
            <input class="formulario__input" type="text" id="nombre" placeholder="Ingrese Nombre..." name="nombre" value="<?php echo s($usuario->nombre)?>">
        </div>
        <div class="formulario__campo">
            <label for="apellido">Apellido</label>
            <input class="formulario__input" type="text" id="apellido" placeholder="Ingrese Apellido..." name="apellido" value="<?php echo s($usuario->apellido)?>">
        </div>
        <div class="formulario__campo">
            <label for="telefono">Teléfono</label>
            <input class="formulario__input" type="tel" id="apellido" placeholder="Ingrese Teléfono..." name="telefono" value="<?php echo s($usuario->telefono)?>">
        </div>
        <div class="formulario__campo">
            <label for="email">Email</label>
            <input class="formulario__input" type="email" id="email" placeholder="Ingrese Email..." name="email"  value="<?php echo s($usuario->email)?>">
        </div>
        <div class="formulario__campo">
            <label for="password">Password</label>
            <input class="formulario__input" type="password" id="password" placeholder="Ingrese Password..." name="password">
        </div>
        <div class="formulario__campo">
                <label for="password2">Repetir Password</label>
                <input class="formulario__input" type="password" id="password" placeholder="Repite tu Password..." name="password2" >
        </div>
        <input type="submit" class="boton" value="Crear Cuenta">
    </form>

    <div class="acciones">
        <a href="/">¿Ya tienes una Cuenta?. Inicia Sesión</a>
        <a href="/olvide">¿Olvidaste tu Password?</a>
    </div>
</main>
        
<?php include_once __DIR__.'/footer.php';?>