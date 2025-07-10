<?php
include_once("libreria/motor.php");
if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'administrador') {
  echo '<div class="container"><div class="alert alert-danger">Acceso denegado. Solo los administradores pueden registrar o devolver préstamos.</div></div>';
  exit;
}
$mensaje = '';
// Marcar devolución
if (isset($_GET['devolver'])) {
    $id_prestamo = intval($_GET['devolver']);
    $sql = "UPDATE prestamos_imp SET devuelto = 1, fecha_devolucion = CURDATE() WHERE id_prestamo = ?";
    $stmt = $objConexion->enlace->prepare($sql);
    $stmt->bind_param('i', $id_prestamo);
    $stmt->execute();
    $mensaje = '<div class="alert alert-success">Préstamo marcado como devuelto.</div>';
}
// Registrar préstamo
if (!empty($_POST) && isset($_POST['registrar_prestamo'])) {
    $id_libro = intval($_POST['id_libro']);
    $id_socio = intval($_POST['id_socio']);
    $fecha_prestamo = $_POST['fecha_prestamo'];
    $sql = "INSERT INTO prestamos_imp (id_libro, id_socio, fecha_prestamo) VALUES (?, ?, ?)";
    $stmt = $objConexion->enlace->prepare($sql);
    $stmt->bind_param('iis', $id_libro, $id_socio, $fecha_prestamo);
    $stmt->execute();
    $mensaje = '<div class="alert alert-success">Préstamo registrado correctamente.</div>';
}
// Obtener libro
$id_libro = isset($_GET['id_libro']) ? intval($_GET['id_libro']) : 0;
$libro = null;
if ($id_libro) {
    $res = $objConexion->enlace->query("SELECT * FROM libros_imp WHERE id_libro = $id_libro");
    $libro = $res->fetch_assoc();
}
// Obtener socios
$socios = $objConexion->enlace->query("SELECT id, user FROM personas ORDER BY user");
?>
<div class="container">
  <h3>Registrar Préstamo</h3>
  <?php if($mensaje) echo $mensaje; ?>
  <?php if($libro): ?>
    <form method="POST">
      <input type="hidden" name="registrar_prestamo" value="1">
      <input type="hidden" name="id_libro" value="<?php echo $libro['id_libro']; ?>">
      <div class="form-group">
        <label>Libro</label>
        <input type="text" class="form-control" value="<?php echo htmlspecialchars($libro['titulo']); ?>" disabled>
      </div>
      <div class="form-group">
        <label>Socio</label>
        <select name="id_socio" class="form-control" required>
          <option value="">Seleccione socio...</option>
          <?php while($s = $socios->fetch_assoc()): ?>
            <option value="<?php echo $s['id']; ?>"><?php echo htmlspecialchars($s['user']); ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group">
        <label>Fecha Préstamo</label>
        <input type="date" name="fecha_prestamo" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
      </div>
      <button type="submit" class="btn btn-primary">Registrar</button>
      <a href="abm_imp.php" class="btn btn-secondary">Volver</a>
    </form>
  <?php else: ?>
    <a href="abm_imp.php" class="btn btn-secondary">Volver</a>
  <?php endif; ?>
</div> 