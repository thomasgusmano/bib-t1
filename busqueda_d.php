<?php
include("libreria/motor.php");
include_once("libreria/libro_d.php");
session_start();

$str_b = $_POST['b'];

// Usar el método getConexion() para obtener el objeto mysqli válido
$lib = Libro_d::buscar($objConexion->getConexion(), $str_b);
?>

<?php
if (isset($lib)){
?>
<div class="panel panel-default">
  <div class="panel-heading">Publicaciones Encontradas</div> 
  <div style="overflow: scroll; height: 350px;">  
    <table class="tabla_edicion table table-hover">
      <thead>
        <tr>
          <th>Titulo</th>
          <th>Autor</th>
          <th>Tipo</th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach($lib as $libros){
            echo "
            <tr>
              <td><a href='libros_d/".$libros['Archivo']."' target='_blank' >".htmlspecialchars($libros['Titulo'])."</a></td>
              <td>".htmlspecialchars($libros['Autor'])."</td>
              <td>".htmlspecialchars($libros['tipo'])."</td>";
             
            $file_l = $libros['Archivo'];
            if (isset($_SESSION['username']) && $_SESSION['rol']=='administrador'){
              echo '<td><button class="btn btn-primary btn-xs" onclick="editar(' . $libros['id_libro'] . ')" >Editar</button></td>';
              echo '<td><button class="btn btn-primary btn-xs" onclick="borrar(' . $libros['id_libro'] . ')" >Borrar</button></td>';
            }
            else{
              echo '<td><button class="btn btn-primary btn-xs" onclick="ver_info(' . $libros['id_libro'] . ')" >Info</button></td>';
            }
            echo '<td><button class="btn btn-primary btn-xs" onclick="cargar_pdf(\'#capa_d\',\'' .$file_l . '\')" >Min</button></td>';
            echo "</tr>";
          }
        ?>
      </tbody>
    </table>
  </div>
</div>

<?php
}
?>
