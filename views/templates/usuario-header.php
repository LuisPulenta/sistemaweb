<header class="dashboard__header">
    <div class="dashboard__header-grid">
        <a href="/">
            <h2 class="dashboard__logo">
                Sistema Web
            </h2>
        </a>

        <div>
        <p class="dashboard__parrafo">
            <?php            
              echo 'Usuario: '  . $_SESSION['nombre'];
            ?>
        </p>

        <nav class="dashboard__nav">
            <form method="POST" action="/logout" class="dashboard__form">
                <input type="submit" value="Cerrar Sesión" class="dashboard__submit--logout">
            </form>
        </nav>
        </div>
        
    </div>
</header>