<?php
//include_once("libreria/motor.php");
include_once("libreria/carteles.php");

$str_b =  $_GET['b'];
//echo "QUE".$_GET['b'];
$cart=Cartel::seleccionar($str_b);

?>
<style>
.card-custom {
  height: 100%;
  display: flex;
  flex-direction: column;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  border-radius: 10px;
  margin-bottom: 24px;
  background: #fff;
}
.card-img-top-custom {
  width: 100%;
  height: 180px;
  object-fit: cover;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
}
.card-body-custom {
  flex: 1 1 auto;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  padding: 16px;
}
.card-title-custom {
  font-size: 1.1em;
  font-weight: bold;
  margin-bottom: 8px;
}
.card-text-custom {
  font-size: 0.98em;
  color: #444;
  margin-bottom: 12px;
}
.card-footer-custom {
  background: #f8f9fa;
  border-top: 1px solid #eee;
  padding: 8px 16px;
  border-bottom-left-radius: 10px;
  border-bottom-right-radius: 10px;
  font-size: 0.9em;
  color: #888;
}
/* Plantilla 1: fondo azul claro, texto blanco */
.plantilla1 {
  background: linear-gradient(135deg, #4a90e2 60%, #357ab7 100%);
  color: #fff;
  border: 2px solid #357ab7;
}
.plantilla1 .card-title-custom, .plantilla1 .card-text-custom, .plantilla1 .card-footer-custom {
  color: #fff;
}
/* Plantilla 2: fondo amarillo suave, bordes redondeados */
.plantilla2 {
  background: linear-gradient(135deg, #fffbe6 80%, #ffe082 100%);
  border: 2px solid #ffe082;
}
.plantilla2 .card-title-custom {
  color: #bfa100;
}
.plantilla2 .card-footer-custom {
  color: #bfa100;
}
</style>
<?php
if (isset($cart) && count($cart) > 0){
  echo '<div class="row">';
  foreach($cart as $carteles){
    $plantilla = isset($carteles['plantilla']) ? intval($carteles['plantilla']) : 0;
    $plantillaClass = $plantilla === 1 ? 'plantilla1' : ($plantilla === 2 ? 'plantilla2' : '');
    echo '<div class="col-md-6 col-lg-4 d-flex align-items-stretch">';
    echo '<div class="card card-custom w-100 '.$plantillaClass.'">';
    if($carteles['imagen1']!=""){
        $img_h="images/cartelera/".$carteles['imagen1'];
        echo '<img src="'.$img_h.'" class="card-img-top-custom" alt="Imagen Encabezado">';
    }
    echo '<div class="card-body card-body-custom">';
    echo '<div class="card-title card-title-custom">'.htmlspecialchars($carteles['titulo']).'</div>';
    echo '<button class="btn btn-info btn-xs mb-2" onclick="mostrarDetalleCartel(\''.
      htmlspecialchars(addslashes($carteles['titulo'])).'\', \
      `<div><b>Categoría:</b> '.htmlspecialchars(addslashes($carteles['categoria'])).'<br><b>Texto:</b> '.addslashes($carteles['texto']).'<br>'.
      ($carteles['imagen'] ? '<img src=\'images/cartelera/'.addslashes($carteles['imagen']).'\' class=\'img-fluid\' style=\'max-width:100%;\'><br>' : '').
      ($carteles['link'] ? '<a href=\''.addslashes($carteles['link']).'\' target=\'_blank\'>Ver en la web</a><br>' : '').
      ($carteles['texto1'] ? '<div>'.htmlspecialchars(addslashes($carteles['texto1'])).'</div>' : '').
      ($carteles['texto2'] ? '<div>'.htmlspecialchars(addslashes($carteles['texto2'])).'</div>' : '').
      ($carteles['v_desde'] || $carteles['v_hasta'] ? '<div><b>Vigencia:</b> '.htmlspecialchars($carteles['v_desde']).' - '.htmlspecialchars($carteles['v_hasta']).'</div>' : '').
      '`)">Ver detalles</button>';
    if($carteles['link']!=""){
        echo '<a href="'.htmlspecialchars($carteles['link']).'" target="_blank" class="btn btn-primary btn-xs mb-2 ml-1">Ver en la web</a>';
    }
    echo '<div class="card-text card-text-custom">'.mb_strimwidth(strip_tags($carteles['texto']),0,90,'...').'</div>';
    if($carteles['imagen']!=""){
        $img='images/cartelera/'.$carteles['imagen'];
        echo '<img src="'.$img.'" class="img-fluid rounded mb-2" style="max-height:100px; object-fit:cover;"/>';
    }
    echo '</div>';
    if($carteles['v_desde']!="" || $carteles['v_hasta']!=""){
        echo '<div class="card-footer-custom">'.$carteles['v_desde'].' '.$carteles['v_hasta'].'</div>';
    }
    echo '</div>';
    echo '</div>';
  }
  echo '</div>';
} else {
  echo '<div class="alert alert-info">No hay carteles en esta categoría.</div>';
}
?>