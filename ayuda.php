<?php
require_once 'config.php';
$conn = conectar();

$stmt = $conn->prepare("SELECT * FROM carteles WHERE categoria = 'Ayuda'");
$stmt->execute();
$resultado = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carteles de Ayuda</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css"
          integrity="sha384-HVqWfk6QxiNU5pI0FA+vFg0lF0g2n3ixF0JdGxVg3Tpl0uVGFQh4OH0rRSTfo1Ue"
          crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Carteles de Ayuda</h1>
    <?php while ($fila = $resultado->fetch_assoc()): ?>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"><?= htmlspecialchars($fila['titulo']) ?></h3>
            </div>
            <div class="panel-body">
                <?= nl2br(htmlspecialchars($fila['texto'])) ?>
            </div>
        </div>
    <?php endwhile; ?>
</div>
</body>
</html>
