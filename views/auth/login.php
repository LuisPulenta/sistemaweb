<?php include_once __DIR__.'/header.php';?>


<main class="auth">
    <h1 class="nombre-pagina">Login</h1>
    <p class="descripcion-pagina">Inicia sesión con tus credenciales</p>

    <?php
        include_once __DIR__ . "/../templates/alertas.php";    
    ?>

    <form class="formulario" method="POST" action="/">
            <div class="formulario__campo">
                <label for="email" class="formulario__label" >Email</label>
                <input class="formulario__input" type="email" placeholder="Ingresa Email..." name="email" id="email">
            </div>
            <div class="formulario__campo">
                <label for="password" class="formulario__label" >Password</label>
                <input class="formulario__input" type="password" placeholder="Ingresa Password..." name="password" id="password">
            </div>

            <input class=formulario__submit type="submit" value="Iniciar Sesión">
        </form>

    <div class="acciones">
        <a href="/crear">¿Aún no tienes una cuenta?. Crea una...</a>
        <a href="/olvide">¿Olvidaste tu Password?</a>
    </div>
</main>

<?php include_once __DIR__.'/footer.php';?>
        