

<main class="auth">
    <h1 class="nombre-pagina">Crear Cuenta</h1>
    <p class="descripcion-pagina">Llena el siguiente formulario para crear una cuenta</p>

    <?php
    include_once __DIR__ . "/../templates/alertas.php";    
    ?>

    <form method="POST" action="/crear" enctype="multipart/form-data" class="formulario__campo">
        
    <?php include_once __DIR__ . '/formulario.php'; ?>
    
</form>

    <div class="acciones">
        <a href="/">¿Ya tienes una Cuenta?. Inicia Sesión</a>
        <a href="/olvide">¿Olvidaste tu Password?</a>
    </div>
</main>
        
