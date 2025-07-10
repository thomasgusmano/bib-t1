<?php
include_once("libreria/motor.php");
include("menu_bs.php");
if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'administrador') {
  echo '<div class="container"><div class="alert alert-danger">Acceso denegado. Solo los administradores pueden gestionar material impreso y préstamos.</div></div>';
  exit;
}

// Alta de libro impreso
$mensaje = '';
if (!empty($_POST) && isset($_POST['alta_libro'])) {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $edicion = $_POST['edicion'];
    $anio = $_POST['anio'];
    $area = $_POST['area'];
    $ejemplares = intval($_POST['ejemplares']);
    $sql = "INSERT INTO libros_imp (titulo, autor, edicion, anio, area, ejemplares) VALUES (?,?,?,?,?,?)";
    $stmt = $objConexion->enlace->prepare($sql);
    $stmt->bind_param('sssssi', $titulo, $autor, $edicion, $anio, $area, $ejemplares);
    $stmt->execute();
    $mensaje = '<div class="alert alert-success">Libro impreso agregado correctamente.</div>';
}

// Listado de libros impresos
$sql = "SELECT * FROM libros_imp ORDER BY id_libro DESC";
$result = $objConexion->enlace->query($sql);

// Listado de préstamos activos
$sql_p = "SELECT p.id_prestamo, l.titulo, per.user, p.fecha_prestamo FROM prestamos_imp p JOIN libros_imp l ON p.id_libro = l.id_libro JOIN personas per ON p.id_socio = per.id WHERE p.devuelto = 0 ORDER BY p.fecha_prestamo DESC";
$prestamos = $objConexion->enlace->query($sql_p);
?>
<div class="container-fluid">
  <h3>Material Impreso</h3>
  <?php if($mensaje) echo $mensaje; ?>
  <form method="POST" class="form-inline mb-3" style="margin-bottom: 24px;">
    <input type="hidden" name="alta_libro" value="1">
    <div class="form-group"><input type="text" name="titulo" class="form-control" placeholder="Título" required></div>
    <div class="form-group"><input type="text" name="autor" class="form-control" placeholder="Autor"></div>
    <div class="form-group"><input type="text" name="edicion" class="form-control" placeholder="Edición"></div>
    <div class="form-group"><input type="text" name="anio" class="form-control" placeholder="Año"></div>
    <div class="form-group"><input type="text" name="area" class="form-control" placeholder="Área"></div>
    <div class="form-group"><input type="number" name="ejemplares" class="form-control" placeholder="Ejemplares" min="1" value="1"></div>
    <button type="submit" class="btn btn-success">Agregar libro</button>
  </form>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Título</th>
        <th>Autor</th>
        <th>Edición</th>
        <th>Año</th>
        <th>Área</th>
        <th>Ejemplares</th>
        <th>Préstamo</th>
      </tr>
    </thead>
    <tbody>
      <?php while($libro = $result->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($libro['titulo']); ?></td>
        <td><?php echo htmlspecialchars($libro['autor']); ?></td>
        <td><?php echo htmlspecialchars($libro['edicion']); ?></td>
        <td><?php echo htmlspecialchars($libro['anio']); ?></td>
        <td><?php echo htmlspecialchars($libro['area']); ?></td>
        <td><?php echo htmlspecialchars($libro['ejemplares']); ?></td>
        <td><a href="registrar_prestamo.php?id_libro=<?php echo $libro['id_libro']; ?>" class="btn btn-primary btn-sm">Registrar Préstamo</a></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <h4>Préstamos activos</h4>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Libro</th>
        <th>Socio</th>
        <th>Fecha Préstamo</th>
        <th>Acción</th>
      </tr>
    </thead>
    <tbody>
      <?php while($p = $prestamos->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($p['titulo']); ?></td>
        <td><?php echo htmlspecialchars($p['user']); ?></td>
        <td><?php echo htmlspecialchars($p['fecha_prestamo']); ?></td>
        <td><a href="registrar_prestamo.php?devolver=<?php echo $p['id_prestamo']; ?>" class="btn btn-success btn-xs">Marcar devolución</a></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div> 