<?php require_once("funciones.php"); ?>
<div class="row">
  <div class="col-sm-8">
    <div class="form-group">
      <!-- Cabecera con Barra de navegacion -->
      <header class="main-header">

        <img class="logo" src="images/Logo.png">

        <h1><a href="index.php">Multilanguage Meetings</a></h1>

        <div>
        <?php if(estaLogueado()): ?>
          <?php $usuario = traerUsuarioPorId($_SESSION['id']); ?>
                <a href=perfil.php> Hola <?= $usuario->getName() ?> </a>
                <br>
                <a href=logout.php>Salir</a>
        <?php else: ?>
                <a href=login.php>Ingresar</a>
        <?php endif;?>
        </div>

        <a href="#" class="toggle-nav">
          <div class="ion-navicon-round"></div>
        </a>
        <nav class="main-nav">
          <ul>
            <a href="quienesSomos.php"><li>QUIENES SOMOS</li></a>
            <a href="preguntasFrecuentes.php"><li>PREGUNTAS FRECUENTES</li></a>

            <a href="VerEventos.php"><li>PROXIMOS EVENTOS</li></a>
          </ul>
        </nav>
    </div>
  </div>
</div>
