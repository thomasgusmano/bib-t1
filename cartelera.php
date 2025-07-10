<?php
include("menu_bs.php");

include_once("libreria/carteles.php");


$cats=Cartel::categorias();
$cat_js = json_encode(array_column($cats, 'categoria'));


echo '
<div class="container-fluid" >

<div class="row">
 
  <div class="col-sm-4">
  <div id="capa_d">
 
	  <H3>BIBLIOTECA T1</H3>
	  <H4>Cartelera</H4>
	  <ul class="nav nav-pills nav-stacked" id="cat-list">';

foreach($cats as $cat){
echo '<li><a href="#" class="cat-link" data-cat="'.$cat['categoria'].'">'.$cat['categoria'].'</a></li>'  ; $cat['categoria'];
}	  
	   
		echo '           
	  </ul>
	</div>
    </div>
	<div class="col-sm-8">
	  <div id="capa_C">	
	  
	  </div>
	</div>	
	  
	  </div>
	 
 </div>
';
?>

<!-- Modal para detalles -->
<div class="modal fade" id="cartelModal" tabindex="-1" role="dialog" aria-labelledby="cartelModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="cartelModalLabel"></h4>
      </div>
      <div class="modal-body" id="cartelModalBody"></div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
  var categorias = <?php echo $cat_js; ?>;
  function cargarCategoria(cat) {
    $("#cat-list li").removeClass("active");
    $("#cat-list a[data-cat='"+cat+"']").parent().addClass("active");
    cargar('#capa_C','mostrar_cartelera.php?b='+encodeURIComponent(cat));
  }
  $("#cat-list").on("click", ".cat-link", function(e) {
    e.preventDefault();
    var cat = $(this).data('cat');
    cargarCategoria(cat);
  });
  // Cargar la primera categoría por defecto
  if (categorias.length > 0) cargarCategoria(categorias[0]);
  // Modal para detalles (se usará desde mostrar_cartelera.php)
  window.mostrarDetalleCartel = function(titulo, html) {
    $('#cartelModalLabel').text(titulo);
    $('#cartelModalBody').html(html);
    $('#cartelModal').modal('show');
  }
});
</script>

