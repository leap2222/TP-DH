<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once("funciones.php");

  if (!estaLogueado()) {
	 	header('location: login.php');
	 	exit;
	}

  if(isset($_GET['id'])){

    // COMENTARIO

    $usuariosInscriptos = Inscripciones::ObtenerTodas($_GET['id']);
    $comentariosDelEvento = Comentarios::ObtenerTodos($_GET['id']);

    $elEvento = traerEventoPorId($_GET['id']);
    // Variables para persistencia
    $name = $elEvento->getName();
    $site = $elEvento->getSite();
    $language = $elEvento->getLanguage();
    $estado = $elEvento->getStatus();

    // RESPUESTA A Comentarios ///  REVISARRRR!!!!
    if(isset($_POST['respuestaAlComentario'])) {
      $respuesta = isset($_POST['respuesta']) ? trim($_POST['respuesta']) : "";
      if($respuesta) {
        $unaRespuesta = guardarRespuesta($_POST['respuestaAlComentario'], $_SESSION['id'], $respuesta);
        $respuesta='';
      }
    }
}

  $comentario='';
  $respuesta='';
  $nuevoComentario ='';
  $nuevaRespuesta='';

  if($_POST){

      $comentario = isset($_POST['comentario']) ? trim($_POST['comentario']) : "";

      if($comentario) {
        $unComentario = new comentario;
        $unComentario->setUserId($_SESSION['id']);
        $unComentario->setEventId($_GET['id']);
        $unComentario->setComment($comentario);
        $unComentario->setParentId(0);
        $unComentario->setTimestamp(date('Y-m-d H:i:s'));
        $unComentario->Guardar();

        header('location: EventoDetalle.php?id=' . $_GET['id']);
        exit;
      }
	}

?>

<!-- HTML -->

<?php $TituloPagina = "Detalles del Evento"; include 'header.php'; ?>

<div class="data-form">
	<div class="row">
		<div class="col-sm">
			<div class="form-group">
				<label class="control-label">Nombre:</label>
				<input type="text" class="form-control" name="" value="<?=$name?>">
			</div>
		</div>
		<div class="col-sm">
			<div class="form-group">
				<label class="control-label">Lugar del Encuentro:</label>
				<input class="form-control" type="text" name="" value="<?=$site?>">
      </div>
		</div>
  </div>
	<div class="row">
		<div class="col-sm">
			<div class="form-group">
				<label class="control-label">Idioma Preferido:</label>
				<input class="form-control" type="text" name="" value="<?=$language?>">
      </div>
		</div>
		<div class="col-sm">
			<div class="form-group">
				<label class="control-label">Estado:</label>
				<input class="form-control" type="text" name="" value="<?=$estado?>">
      </div>
		</div>
  </div>
</div>

<?php if(!$elEvento->EstaInscripto($_SESSION['id'])): ?>
  <a class="btn btn-success" href="inscribir.php?event_id=<?=$elEvento->getId()?>">Inscribirme</a>
<?php else: ?>
  <a class="btn btn-danger" href="deleteInscription.php?event_id=<?=$elEvento->getId()?>">Cancelar Inscripción</a>
<?php endif; ?>

<br><br>

<div class="row">
  <div class="col-sm">
    <label>Usuarios Inscriptos:</label>
    <?php if($usuariosInscriptos): ?>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>email</th>
            <th>Idioma Interesado</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($usuariosInscriptos as $unaInscripcion): ?>
            <?php $unUsuario = traerUsuarioPorId($unaInscripcion->getUserId());?>
            <tr>
              <td><a href=usuarioDetalle.php?id=<?=$unUsuario->getId() ?> class='nombreUsuario'><?=$unUsuario->getName();?></a></td>
              <td><?=$unUsuario->getEmail();?></td>
              <td><?=$unUsuario->getLanguage();?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <br>
    <?php else: ?>
      <label> No hay usuarios inscriptos en este evento</label>
      <br>
    <?php endif; ?>
  </div>
</div>



<?php if($comentariosDelEvento): // COMENTARIOS ?>
  <div class="table table-striped table-hover">

    <?php
      $pila = [];
      $actual = 0;

     while(count($comentariosDelEvento)) {

       if(!$pila) {
         $encontrado = false;
         for($x=0; $x<count($comentariosDelEvento) && !$encontrado; $x++) {
           if($comentariosDelEvento[$x]->getParentId() == end($pila)) {
             $actual = $x;
             $encontrado = true;
//             break;
           }
         }

         if(!$encontrado) {
           echo "NO ENCONTRADO!";
           exit;
           echo "</ul>";
           array_pop($pila);
           $actual = 0;
         }

       }
         array_push($pila, $comentariosDelEvento[$actual]->getId());
         $unComentario = $comentariosDelEvento[$actual];
         array_splice($comentariosDelEvento, $actual, 1);

         $unUsuario = traerUsuarioPorId($unComentario->getUserId()); ?>
         <ul class="<?= $unComentario->getParentId() == 0 ? '' : 'anidado' ?>">
             <div class="comment">
               <p><a href=usuarioDetalle.php?id=<?=$unUsuario->getId() ?> class='nombreUsuario'><?=$unUsuario->getName();?></a> (#<?=$unComentario->GetId() ?>) (parent #<?=$unComentario->getParentId()?>) <em><?=$unComentario->timestamp ?></em></p>
               <p><?php $nuevoComentario = $unComentario->getComment(); ?></p>
               <p class="texto-comentario"><?=$unComentario->getComment();?></p>
               <p><a href=#ResponderComentario class='nombreUsuario'>(Responder)</a>
                 <?php if(($unComentario->getUserId() == $_SESSION['id']) || $usuario->isAdmin()): ?>
                   <a href=deleteComment.php?id_comment=<?=$unComentario->GetId() ?>&id_event=<?=$_GET['id']?> class='nombreUsuario'>(Borrar)</a>
                 <?php endif; ?>
               </p>
             </div>
        <?php
     } ?>
  </div>
  <br><br>
<?php endif; ?>


<?php if($elEvento->EstaInscripto($_SESSION['id'])): ?>
  <div class="row">
    <div class="col-sm">
      <form  method="post" enctype="multipart/form-data">
          <label>Comenta:</label>
          <textarea class="form-control" name="comentario" value="<?=$comentario?>"><?=$comentario?></textarea>
          <br>
          <input class="btn btn-primary" type="submit" name="accion" value="Comentar">
      </form>
    </div>
  </div>
  <br>
<?php endif; ?>

<a class="btn btn-success" href="VerEventos.php">Volver</a>

<?php include 'footer.php' ?>
