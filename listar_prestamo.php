<?php
include_once("libreria/conexion.php");

$conn = conexion();

if(isset($_GET['devolver'])){
    $id_prestamo = intval($_GET['devolver']);
    $fecha_devolucion = date('Y-m-d');

    $sql = "UPDATE prestamos SET fecha_devolucion = ? WHERE id_prestamo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $fecha_devolucion, $id_prestamo);
    $stmt->execute();
}

// Traer préstamos activos (sin devolución)
$sql = "SELECT p.id_prestamo, l.Titulo, per.nombre, per.apellido, p.fecha_prestamo
        FROM prestamos p
        JOIN libros_d l ON p.id_libro = l.id_libro
        JOIN personas per ON p.id_persona = per.id
        WHERE p.fecha_devolucion IS NULL
        ORDER BY p.fecha_prestamo";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Préstamos Activos</title>
    <link rel="stylesheet" href="bootstrap/carteles.css">
</head>
<body>
<h1>Préstamos activos</h1>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID Préstamo</th>
            <th>Libro</th>
            <th>Socio</th>
            <th>Fecha Préstamo</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id_prestamo'] ?></td>
            <td><?= htmlspecialchars($row['Titulo']) ?></td>
            <td><?= htmlspecialchars($row['apellido'] . ", " . $row['nombre']) ?></td>
            <td><?= $row['fecha_prestamo'] ?></td>
            <td><a href="?devolver=<?= $row['id_prestamo'] ?>" onclick="return confirm('Confirmar devolución?')">Devolver</a></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</body>
</html>
