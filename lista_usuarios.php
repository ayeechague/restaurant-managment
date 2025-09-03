<?php
require_once('./_init.php');
require_once('./bd/conexion.php');
require_once('./bd/consultas_usuarios.php');

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
  header('Location: ../index.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'] ?? null;
  $rol = $_POST['rol'] ?? null;

  if ($id && in_array($rol, ['admin', 'propietario', 'invitado'])) {
    actualizarRol($conexion, $id, $rol);
  }
}

$usuarios = getUsuarios($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Administrar Usuarios</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="img/favicon.ico" type="image/x-icon">
</head>
<body>

<?php include './includes/nav.php'; ?>

<div class="container mt-5">
  <h2>Administrar Usuarios</h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Email</th>
        <th>Rol</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($usuarios as $usuario): ?>
        <tr>
          <form method="POST">
            <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
            <td><?= htmlspecialchars($usuario['nombre']) ?></td>
            <td><?= htmlspecialchars($usuario['apellido']) ?></td>
            <td><?= htmlspecialchars($usuario['email']) ?></td>
            <td>
              <select name="rol" class="form-select">
                <option value="invitado" <?= $usuario['rol'] == 'invitado' ? 'selected' : '' ?>>Invitado</option>
                <option value="propietario" <?= $usuario['rol'] == 'propietario' ? 'selected' : '' ?>>Propietario</option>
                <option value="admin" <?= $usuario['rol'] == 'admin' ? 'selected' : '' ?>>Administrador</option>
              </select>
            </td>
            <td>
              <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
            </td>
          </form>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

</body>
</html>
