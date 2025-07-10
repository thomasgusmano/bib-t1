<?php


if (!empty($_POST)) {
    $file = $_POST['archivo'];
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
}
?>


 <div class="container">
 
  <div class="row" >
 
	  <div class="col-sm-12" >
		  <div id="capa_d">
			<?php if (isset($ext) && ($ext === 'pdf')): ?>
				<object data="<?php echo $file; ?>" type="application/pdf" width="100%" height="500">
					alt : <a href="<?php echo $file; ?>">Descargar PDF</a>
				</object>
			<?php elseif (isset($ext) && ($ext === 'mp4' || $ext === 'webm')): ?>
				<video width="100%" height="400" controls>
					<source src="<?php echo $file; ?>" type="video/<?php echo $ext; ?>">
					Tu navegador no soporta la vista previa de video.
				</video>
			<?php elseif (isset($file)): ?>
				<p>No se puede mostrar vista previa. <a href="<?php echo $file; ?>" target="_blank">Descargar archivo</a></p>
			<?php endif; ?>
		  </div>
	   </div>
  </div> 
</div>