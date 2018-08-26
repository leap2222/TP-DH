<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once("funciones.php");
  require_once("Clases/evento.php");

  if (!estaLogueado()) {
	 	header('location: login.php');
	 	exit;
	}

  if(isset($_GET['id'])){

    //$idEvento = $_GET['id'];
    require_once("Clases/Inscripciones.php");
    require_once("Clases/Comentarios.php");
    require_once("Clases/Respuestas.php");
    $usuariosInscriptos = Inscripciones::ObtenerTodas($_GET['id']);
    $comentariosDelEvento = Comentarios::ObtenerTodos($_GET['id']);

    $elEvento = traerEventoPorId($_GET['id']);
    // Variables para persistencia
    $name = $elEvento->getName();
    $site = $elEvento->getSite();
    $language = $elEvento->getLanguage();
    $estado = $elEvento->getStatus();

  }
  // Resolver que al inscribirse muestre el detalle del evento sin ir a la pantalla de VerEventos
  // else{
  //   $elEvento = traerEventoPorId($idEvento);
  //   // Variables para persistencia
  //   $name = $elEvento->getName();
  //   $site = $elEvento->getSite();
  //   $language = $elEvento->getLanguage();
  //   $estado = $elEvento->getStatus();
  // }
  // $idEvento = $elEvento->getId();
  $comentario='';
  $respuesta='';
  $nuevoComentario ='';
  $nuevaRespuesta='';

  if($_POST){

      $comentario = isset($_POST['comentario']) ? trim($_POST['comentario']) : "";
      if($comentario){
        $unComentario = guardarComentario($elEvento->getId(), $_SESSION['id'], $comentario);
        $comentario='';
      }

      $respuesta = isset($_POST['respuesta']) ? trim($_POST['respuesta']) : "";
      if($respuesta){
        $unaRespuesta = guardarRespuesta($_POST['idcomment'], $_SESSION['id'], $respuesta);
        $respuesta='';
      }
	}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <!-- <link rel="stylesheet" href="css/styles.css"> -->
    <title>Datos del Evento</title>
  </head>
  <body>
    <?php if (!empty($errores)): ?>
			<div class="div-errores alert alert-danger">
				<ul>
					<?php foreach ($errores as $value): ?>
					<li><?=$value?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
    <div class="data-form">
    	<div class="row">
        <div class="row justify-content-md-center">
    			<div class="col-sm-6">
    				<div class="form-group <?= isset($errores['name']) ? 'has-error' : null ?>">
    					<label class="control-label">Nombre*:</label>
    					<input type="text" class="form-control" name="" value="<?=$name?>">
    					<span class="help-block" style="<?= !isset($errores['name']) ? 'display: none;' : ''; ?>">
    						<b class="glyphicon glyphicon-exclamation-sign"></b>
    							<?= isset($errores['name']) ? $errores['name'] : ''; ?>
    					</span>
    				</div>
    			</div>
    			<div class="col-sm-6">
    				<div class="form-group <?= isset($errores['site']) ? 'has-error' : null ?>">
    					<label class="control-label">Lugar del Encuentro*:</label>
    						<input class="form-control" type="text" name="" value="<?=$site?>">
    						<span class="help-block" style="<?= !isset($errores['site']) ? 'display: none;' : ''; ?>">
    							<b class="glyphicon glyphicon-exclamation-sign"></b>
    							<?= isset($errores['site']) ? $errores['site'] : ''; ?>
    						</span>
            </div>
    			</div>
    		</div>
      </div>
  				<div class="row">
  					<div class="col-sm-6">
  						<div class="form-group <?= isset($errores['language']) ? 'has-error' : null ?>">
  							<label class="control-label">Idioma Preferido*:</label>
  							<input class="form-control" type="text" name="" value="<?=$language?>">
    							<span class="help-block" style="<?= !isset($errores['language']) ? 'display: none;' : ''; ?>">
    								<b class="glyphicon glyphicon-exclamation-sign"></b>
    								<?= isset($errores['language']) ? $errores['language'] : ''; ?>
    							</span>
    		        </div>
    					</div>
    				</div>
            <div class="row">
    					<div class="col-sm-6">
    						<div class="form-group <?= isset($errores['estado']) ? 'has-error' : null ?>">
    							<label class="control-label">Estado*:</label>
    							<input class="form-control" type="text" name="" value="<?=$estado?>">
      							<span class="help-block" style="<?= !isset($errores['estado']) ? 'display: none;' : ''; ?>">
      								<b class="glyphicon glyphicon-exclamation-sign"></b>
      								<?= isset($errores['estado']) ? $errores['estado'] : ''; ?>
      							</span>
      		       </div>
      				</div>
      			</div>
        </div>
        <a class="btn btn-success" href="VerEventos.php">Volver</a>
        <br><br>
        <div class="row">
          <div class="col-sm-6">
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
                      <td><?=$unUsuario->getName();?></td>
                      <td><?=$unUsuario->getEmail();?></td>
                      <td><?=$unUsuario->getLanguage();?></td>
                      <td>
                        <form class="" action="UsuarioDetalle.php" method="get">
                          <input hidden type="text" name="email" value="<?=$unUsuario->getEmail();?>">
                          <button type="submit" class="btn btn-info" name="">
                            <span class="ion-edit" aria-hidden="true"></span>
                            <span><strong>Ver</strong></span>
                          </button>
                        </form>
                      </td>
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

        <?php if($elEvento->EstaInscripto($_SESSION['id'])): ?>
          <div class="row">
            <div class="col-sm-6">
              <form  method="post" enctype="multipart/form-data">
                  <label>Comenta:</label>
                  <textarea class="form-control" name="comentario" value="<?=$comentario?>"><?=$comentario?></textarea>
                  <!-- <input hidden type="text" > -->
                  <br>
                  <input class="btn btn-primary" type="submit" name="accion" value="Comentar">
              </form>
            </div>
          </div>
          <br>
        <?php endif; ?>

        <?php if($comentariosDelEvento): ?>
          <label>Comentarios:</label>
          <table class="table table-striped table-hover">
              <thead>
                  <tr>
                      <th>Usuario</th>
                      <th>Publicaciones</th>
                      <th>Respuestas</th>
                  </tr>
              </thead>
              <tbody>
              <?php foreach($comentariosDelEvento as $unComentario): ?>
                <?php $unUsuario = traerUsuarioPorId($unComentario->getUserId()); ?>
                <tr>
                  <td><?=$unUsuario->getName();?>
                      <form class="" action="UsuarioDetalle.php" method="get">
                        <input hidden type="text" name="email" value="<?=$unUsuario->getEmail();?>">
                        <button type="submit" class="btn btn-info" name="">
                          <span class="ion-edit" aria-hidden="true"></span>
                          <span><strong>Ver</strong></span>
                        </button>
                      </form>
                  </td>
                  <td>
                    <?php $nuevoComentario = $unComentario->getComment(); ?>

                    <?php if($elEvento->EstaInscripto($_SESSION['id'])): ?>
                        <?php if($unComentario->getUserId() == $_SESSION['id']): ?>
                            <form class="" action="editComment.php" method="get">
                              <textarea class="form-control" name="nuevoComentario" value="<?=$nuevoComentario?>"><?=$nuevoComentario?></textarea>
                              <!-- <input hidden type="text" name="nuevoComentario" value="<?//=$nuevoComentario?>"> -->
                              <input hidden type="text" name="idcomment" value="<?=$unComentario->getId();?>">
                              <button type="submit" class="btn btn-primary" name="">
                                <span class="ion-edit" aria-hidden="true"></span>
                                <span><strong>Editar</strong></span>
                              </button>
                            </form>
                            <form class="" action="deleteComment.php" method="get">
                              <input hidden type="text" name="id" value="<?=$unComentario->getId();?>">
                                <button type="submit" class="btn btn-danger" name="">
                                  <span class="ion-android-delete" aria-hidden="true"></span>
                                  <span><strong>Eliminar</strong></span>
                                </button>
                            </form>
                        <?php else: ?>
                            <textarea class="form-control" name=""><?=$unComentario->getComment();?></textarea>
                        <?php endif; ?>
                  </td>
                  <td>
                          <div class="row">
                            <div class="col-sm-6">
                              <form method="post" enctype="multipart/form-data">
                                <label>Responder:</label>
                                <textarea class="form-control" name="respuesta" value="<?=$respuesta?>"><?=$respuesta?></textarea>
                                <input hidden type="text" name="idcomment" value="<?=$unComentario->getId();?>">
                                <!-- <input hidden type="text" name="$idEvento" value="<?//=$idEvento?>"> -->
                                <br>
                                <input class="btn btn-primary" type="submit" name="accion" value="Responder">
                              </form>
                            </div>
                          </div>
                          <br>

                          <?php $respuestasDelComentario = Respuestas::ObtenerTodas($unComentario->getId()); ?>
                          <?php if($respuestasDelComentario): ?>
                              <label>Respuestas: </label>
                              <table>
                                <thead>
                                  <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php foreach($respuestasDelComentario as $unaRespuesta): ?>
                                  <?php $unUsuario = traerUsuarioPorId($unaRespuesta->getUserId()); ?>
                                    <tr>
                                      <td><?=$unUsuario->getName();?>
                                          <br>
                                          <form class="" action="UsuarioDetalle.php" method="get">
                                            <input hidden type="text" name="email" value="<?=$unUsuario->getEmail();?>">
                                            <button type="submit" class="btn btn-info" name="">
                                              <span class="ion-edit" aria-hidden="true"></span>
                                              <span><strong>Ver</strong></span>
                                            </button>
                                          </form>
                                      </td>
                                      <?php if($unaRespuesta->getUserId() == $_SESSION['id']): ?>
                                        <?php $nuevaRespuesta = $unaRespuesta->getReply(); ?>
                                          <td>
                                            <form class="" action="editReply.php" method="get">
                                              <input hidden type="text" name="idreply" value="<?=$unaRespuesta->getId();?>">
                                              <textarea class="form-control" name="nuevaRespuesta" value="<?=$nuevaRespuesta?>"><?=$nuevaRespuesta?></textarea>
                                          </td>
                                          <td>
                                              <button type="submit" class="btn btn-primary" name="">
                                                <span class="ion-edit" aria-hidden="true"></span>
                                                <span><strong>Editar</strong></span>
                                              </button>
                                            </form>

                                            <form class="" action="deleteReply.php" method="get">
                                              <input hidden type="text" name="idreply" value="<?=$unaRespuesta->getId();?>">
                                              <button type="submit" class="btn btn-danger" name="">
                                                <span class="ion-android-delete" aria-hidden="true"></span>
                                                <span><strong>Eliminar</strong></span>
                                              </button>
                                            </form>
                                          </td>
                                          <?php else: ?>
                                            <td>
                                              <textarea class="form-control" name=""><?=$unaRespuesta->getReply();?></textarea>
                                            </td>
                                            <td></td>
                                          <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                              </tbody>
                            </table>
                          <?php else: ?>
                            <label> Sin respuestas </label>
                            <br><br>
                          <?php endif; ?>

                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <br>
        <?php else: ?>
          <label> Sin publicaciones </label>
          <br><br>
        <?php endif; ?>

        <a class="btn btn-success" href="VerEventos.php">Volver</a>

        <?php if(!$elEvento->EstaInscripto($_SESSION['id'])): ?>
          <a class="btn btn-success" href="inscribir.php?event_id=<?=$elEvento->getId()?>">Inscribirme</a>
        <?php else: ?>
          <a class="btn btn-danger" href="deleteInscription.php?event_id=<?=$elEvento->getId()?>">Cancelar Inscripción</a>
        <?php endif; ?>
  </body>
</html>
