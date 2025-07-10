<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
 <head>
   <title>BASES PWD</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>
   <script src="bootstrap/js/funciones_gral.js"></script>
   <link rel="stylesheet" href="bootstrap/css/style_chat.css" media="all"/>	
   <link rel="stylesheet" href="bootstrap/ui/jquery-ui.css">
   <link rel="stylesheet" href="bootstrap/cust.css">
   <script src="bootstrap/ui/jquery-ui.js"></script>
     
   <!-----https://sourcecodesite.com/how-to-create-chat-system-in-php-using-ajax-2.html--->
   <!--Include Custom CSS-->
   <!---
   <script src="bootstrap/js/funciones_e.js"></script>
   <script src="bootstrap/js/funciones_d.js"></script>
   --->
   <script>
   function cargar(div,desde)
   {
   $(div).load(desde);
   } 
   </script>
   <script>
   function poner_nombre(div,nombre)
   {
   $(div).text(nombre);
   } 
   </script>
   <style>
pre {
    display: block;
    font-family: arial;
    white-space: pre;
    margin: 2em 0;
} 
#background {
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('images/b_bkg_3.jpg');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: 100%;
    opacity: 0.6;
    filter:alpha(opacity=80);
}
</style>
 </head>
 
 <!-----body style="padding: 0px 0px 0px 0px;background-image: url(images/b_bkg_4.jpg);" onload="cargar('#capa_P','txts/init_1.html');cargar('#capa_C','txts/init_2.html')"---->
 <body style="padding: 0px 0px 0px 0px;"  >
  <div id="background"></div>
 <div class="container-fluid" >
 
   <nav class="navbar navbar-static-top navbar2" role="navigation" style="background-color: #d9d7c3; border-bottom: 1px solid #bdbdbd;">
      <div class="navbar-header" style="display: flex; align-items: center;">
        <img src="images/logo.png" alt="Logo" style="height:38px; margin-right:8px;">
        <span style="font-size: 22px; font-weight: bold; color: #6b5e3c; vertical-align: middle;">
          <?php if(isset($_SESSION['username'])) { echo htmlspecialchars($_SESSION['username']); } else { echo 'Invitado'; } ?>
        </span>
      </div>
      <ul class="nav navbar-nav ">
        <li><a href="index.php"><span class="glyphicon glyphicon-home"></span></a></li>
		<li><a href="cartelera.php">Cartelera</a></li>
		<li><a href="#" id="ayuda-link">Ayuda</a></li>
		<li><a href="abm_imp.php">Material Impreso</a></li>
		<li><a href="abm_ld.php">Libros</a></li>
		<?php 
		if (isset($_SESSION['username']) && $_SESSION['rol']=='administrador'){
		 echo '<li><a href="abm_p.php">Usuarios</a></li>';
		 echo '<li><a href="abm_c.php">Carteles</a></li>';
		}
		?>
	  
	  
	  </ul>
	  <ul class="nav navbar-nav navbar-right" style="padding-right: 10px;">
      
	  <?php 
	  if (isset($_SESSION['username'])) {
	  echo ' <li class="navbar-brand">'.$_SESSION['rol'].' : '.$_SESSION['username'].'</li>'; 
      }
	  ?>
	  
      
<?php
	  if (!isset($_SESSION['username'])){
	    echo '	  
	        <li><a href="registro.php"  data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-user"></span> Registro</a></li>
             ';
        echo '	  
	        <li><a href="login.php" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
             ';
		  }	 
	  else{
	    echo '	  
		    <li><a href="i_chat.php">Chat</a></li>
	        <li><a href="logout.php" ><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
             ';
	       }
?>		   
	</ul>
	  
	  
	 
	 
   </nav>
  

  
  
 
  
 <!-- Modal -->
 
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<?php 
if (isset($_SESSION['username']) && $_SESSION['rol']=='administrador') {
    echo '<li><span id="usuarios_conectados" style="color: #000; font-weight: bold;">Usuarios conectados: <span id="num_conectados">0</span></span></li>';
}
?>

</div>
 
<script>
$(document).ready(function() {
    function actualizarUsuariosConectados() {
        $.get('usuarios_conectados.php', function(data) {
            $('#num_conectados').text(data);
        });
    }
    actualizarUsuariosConectados();
    setInterval(actualizarUsuariosConectados, 5000);
    $('#ayuda-link').on('click', function(e) {
        e.preventDefault();
        if (window.location.pathname.indexOf('cartelera.php') !== -1) {
            $("#cat-list a[data-cat='Ayuda']").trigger('click');
        } else {
            window.location.href = 'cartelera.php#ayuda';
        }
    });
    if (window.location.hash === '#ayuda' && $("#cat-list a[data-cat='Ayuda']").length) {
        $("#cat-list a[data-cat='Ayuda']").trigger('click');
    }
});
</script>
 
</body>
