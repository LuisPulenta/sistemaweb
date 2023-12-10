
<main class="auth">
    <h1 class="nombre-pagina">Recuperar Password</h1>

    <?php
    if(!$error){?>
        <p class="descripcion-pagina">Coloca tu nuevo Password a continuación</p>   
    <?php };?>

    <?php
    include_once __DIR__ . "/../templates/alertas.php";    
    // ?>


    <?php
    if($error) return;    
    ?>

    <form class ="formulario" method="POST">
        <div class="formulario__campo">
            <label for="password">Password</label>
            <input class="formulario__input" type="password" id="password" placeholder="Ingrese Password..." name="password">
        </div>

        <div class="formulario__campo">
                <label for="password2">Repetir Password</label>
                <input class="formulario__input" type="password" id="password" placeholder="Repite tu Password..." name="password2" >
        </div>






        <input type="submit" class="boton" value="Guardar Nuevo Password">
    </form>

    <div class="acciones">
        <a href="/">¿Ya tienes una Cuenta?. Inicia Sesión</a>
        <a href="/crear">¿Aún no tienes una cuenta?. Crea una...</a>
    </div>
</main>
