<?php
require_once('./_init.php');
require_once('./bd/conexion.php');
require_once('./bd/consultas_restaurantes.php');

// Verificación de rol admin
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Manejo de eliminación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar_codigo'])) {
    eliminarRestaurante($conexion, $_POST['eliminar_codigo']);
}

// Obtener restaurantes
$restaurantes = getTodosRestaurantes($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Administrar Restaurantes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="../img/favicon.ico" type="image/x-icon">
</head>
<body>
<?php include './includes/nav.php'; ?>

<div class="container mt-5">
  <h2>Panel de administración de restaurantes</h2>
  <a href="agregar_restaurante.php" class="btn btn-success mb-3">Agregar nuevo restaurante</a>

  <table class="table table-bordered table-striped align-middle text-center">
    <thead>
      <tr>
        <th>Código</th>
        <th>Nombre</th>
        <th>Tipo</th>
        <th>Pet Friendly</th>
        <th>Música</th>
        <th>Precio</th>
        <th>Imagen</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($restaurantes as $r): ?>
        <tr>
          <td><?= htmlspecialchars($r['codigo']) ?></td>
          <td><?= htmlspecialchars($r['nombre']) ?></td>
          <td><?= htmlspecialchars($r['tipo']) ?></td>
          <td><?= htmlspecialchars($r['petFriendly']) ?></td>
          <td><?= htmlspecialchars($r['musica']) ?></td>
          <td><?= htmlspecialchars($r['precio']) ?></td>
          <td>
            <img src="../img/restaurantes/<?= htmlspecialchars($r['imagen'] ?? 'default.jpg') ?>" width="100" onerror="this.src='img/restaurantes/default.jpg';">
          </td>
          <td>
            <a href="editar_restaurante.php?id=<?= $r['codigo'] ?>" class="btn btn-primary btn-sm">Editar</a>
            <form action="" method="POST" style="display:inline;">
              <input type="hidden" name="eliminar_codigo" value="<?= $r['codigo'] ?>">
              <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este restaurante?')">Eliminar</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

</body>
</html>
