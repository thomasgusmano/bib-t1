<?php
//include_once("libreria/motor.php");
include_once("libreria/carteles.php");


$cats=Cartel::categorias();

$datos = new Cartel();
$cartel = new Cartel();
$mensaje = '';

$operacion = '';
$id_cartel = '';
$categoria = '';
$titulo = '';
$texto = '';
$imagen = '';
$plantilla = '';
$v_desde = '';
$v_hasta = '';
$activo = '';
$link = '';
$texto1 = '';
$texto2 = '';
$imagen1 = '';
$texto1 = '';
$texto2 = '';
$imagen1 = '';

if (!empty($_POST)) {
    
    //$operacion = $_GET['operacion']  ;
	$operacion = isset($_GET['operacion']) ? $_GET['operacion'] : 'alta' ;
	
	//echo "*".$operacion."*";
	
	if ($operacion == 'alta' && !isset($_GET['id_cart'])){
	    $cartel->categoria=$_POST['txtCategoria'];
		$cartel->titulo=$_POST['txtTitulo'];
		$cartel->texto=$_POST['txtTexto'];
		$cartel->imagen=$_POST['txtImagen'];
		$cartel->plantilla=$_POST['txtPlantilla'];
		$cartel->v_desde=$_POST['txtV_desde'];
		$cartel->v_hasta=$_POST['txtV_hasta'];
		$cartel->activo=isset($_POST['txtActivo']) ? 1 : 1;
		$cartel->link=$_POST['txtLink'];
		$cartel->texto1=$_POST['txtTexto1'];
		$cartel->texto2=$_POST['txtTexto2'];
		$cartel->imagen1=$_POST['txtImagen1'];
		$cartel->guardar();
		$mensaje = '<div class="alert alert-success">Cartel agregado correctamente.</div>';
	}
}
?>

<div class="container">
  <div class="row">
    <div class="col-sm-6">
      <div id="capa_d">
        <form role="form" method="POST" action="" enctype="multipart/form-data" id="formCartel">
          <legend>Registro Cartelera</legend>
          <?php if($mensaje) echo $mensaje; ?>
          <div class="form-group">
            <label>Título *</label>
            <input type="text" name="txtTitulo" class="form-control" required placeholder="Encabezado/Título de la publicación">
          </div>
          <div class="form-group">
            <label>Texto *</label>
            <textarea rows="3" name="txtTexto" class="form-control" required></textarea>
          </div>
          <div class="form-group">
            <label>Otro Texto</label>
            <textarea rows="2" name="txtTexto1" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <label>Más Texto</label>
            <textarea rows="2" name="txtTexto2" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <label>Link</label>
            <input type="url" name="txtLink" class="form-control" placeholder="Un enlace optativo">
          </div>
          <div class="form-group">
            <label>Categoría *</label>
            <div style="display: flex; gap: 8px; align-items: center;">
              <select class="form-control" name="txtCategoria" id="sel_categoria" required style="max-width: 70%;">
                <option value="">Seleccione...</option>
                <option value="Ayuda">Ayuda</option>
                <?php foreach($cats as $cat): ?>
                  <?php if(strtolower($cat['categoria']) !== 'ayuda'): ?>
                    <option value="<?php echo htmlspecialchars($cat['categoria']); ?>"><?php echo htmlspecialchars($cat['categoria']); ?></option>
                  <?php endif; ?>
                <?php endforeach; ?>
              </select>
              <button type="button" class="btn btn-info btn-sm" onclick="document.getElementById('sel_categoria').value='Ayuda'">Artículo de Ayuda</button>
            </div>
          </div>
          <div class="form-group">
            <label>Fecha Desde</label>
            <input type="date" name="txtV_desde" class="form-control">
          </div>
          <div class="form-group">
            <label>Fecha Hasta</label>
            <input type="date" name="txtV_hasta" class="form-control">
          </div>
          <div class="form-group">
            <label>Plantilla</label>
            <select name="txtPlantilla" class="form-control">
              <option value="0">Por defecto</option>
              <option value="1">Plantilla Azul</option>
              <option value="2">Plantilla Amarilla</option>
            </select>
          </div>
          <div class="form-group">
            <label>Activo</label>
            <input type="checkbox" name="txtActivo" checked>
          </div>
          <div class="form-group">
            <label>Imagen Cuerpo *</label>
            <input type="file" id="fileToUpload" accept="image/*" class="form-control" onchange="previewImage(this, 'imgPreview')">
            <input type="hidden" name="txtImagen" id="t_file">
            <img id="imgPreview" src="#" alt="Previsualización" style="max-width:100%; display:none; margin-top:10px;" />
          </div>
          <div class="form-group">
            <label>Imagen Encabezado</label>
            <input type="file" id="fileToUpload1" accept="image/*" class="form-control" onchange="previewImage(this, 'imgPreview1')">
            <input type="hidden" name="txtImagen1" id="t_file1">
            <img id="imgPreview1" src="#" alt="Previsualización" style="max-width:100%; display:none; margin-top:10px;" />
          </div>
          <button type="submit" class="btn btn-success">Agregar</button>
          <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancelar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
function previewImage(input, imgId) {
  var file = input.files[0];
  if (file) {
    var reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById(imgId).src = e.target.result;
      document.getElementById(imgId).style.display = 'block';
    }
    reader.readAsDataURL(file);
    // Guardar el nombre del archivo en el input hidden
    var hiddenInput = (imgId === 'imgPreview') ? 't_file' : 't_file1';
    document.getElementById(hiddenInput).value = file.name;
  }
}
</script>