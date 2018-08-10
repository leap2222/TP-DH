<div class="row">
  <div class="col-sm-8">
    <div class="form-group">
      <!-- Cabecera con Barra de navegacion -->
      <header class="main-header">

        <img class="logo" src="images/Logo.png">

        <h1><a href="index.php">Multilanguage Meetings</a></h1>

        <div>
        <?php
          if(null !== $usuario->getName()) {
            echo "<a href=perfil.php>{$usuario->getEmail()} </a>(<a href=logout.php>Salir</a>)";
          } else {
            echo "<a href=login.php>Ingresar</a>";
          }
        ?>
        </div>

        <a href="#" class="toggle-nav">
          <div class="ion-navicon-round"></div>
        </a>


        <nav class="main-nav">
          <ul>
            <a href="quienesSomos.php"><li>QUIENES SOMOS</li></a>
            <a href="preguntasFrecuentes.php"><li>PREGUNTAS FRECUENTES</li></a>
            <a href="#"><li>PROXIMOS EVENTOS</li></a>
          </ul>
        </nav>
    </div>
  </div>
</div>
