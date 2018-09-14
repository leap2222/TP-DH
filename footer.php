
</div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="col-sm">
    <?php if($usuario):?>
      <div>
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">

          <li class="nav-item active"><a href="VerEventos.php" class="nav-link btn btn-primary">Eventos</a></li>
          <li class="nav-item active"><a href="VerUsuarios.php" class="nav-link btn btn-primary">Usuarios</a></li>
          <li class="nav-item active"><a href="EditarUsuario.php" class="nav-link btn btn-primary">Editar Perfil</a></li>
          <?php if($usuario->isAdmin()): ?>
            <li class="nav-item active"><a href="CrearEvento.php" class="nav-link btn btn-primary">Cargar Evento</a></li>
            <li class="nav-item active"><a href="ImportarDB.php" class="nav-link btn btn-primary">ImportarDB</a></li>
          <?php endif; ?>
        </ul>
      </div>
    <?php endif; ?>
  </div>
</nav>


<div class="row">
  <div class="col-sm">
    <!-- Footer -->
    <footer class="footer bg-dark">
      <a href="http://facebook.com"><ion-icon name="logo-facebook"></ion-icon></a>
      <a href="http://twitter.com"><ion-icon name="logo-twitter"></ion-icon></a>
      <a href="http://instagram.com"><ion-icon name="logo-instagram"></ion-icon></a>
      <ion-icon name="call"></ion-icon> 5555-5555
    </footer>
    <!-- Fin de Footer -->
  </div>
</div>

<script src="https://unpkg.com/ionicons@4.1.2/dist/ionicons.js"></script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</div>
</body>
</html>
