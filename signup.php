<?php
session_start();

require_once('./bd/conexion.php');
require_once('./bd/consultas_usuarios.php');

function test_input($data) {
  return htmlspecialchars(stripslashes(trim($data)));
}

function filter_password($password, $min_length = 8) {
  if (strlen($password) < $min_length) return null;
  if (!preg_match('/[a-z]/', $password)) return null;
  if (!preg_match('/[A-Z]/', $password)) return null;
  if (!preg_match('/[0-9]/', $password)) return null;
  if (!preg_match('/[\W_]/', $password)) return null;
  return $password;
}

$errores = [];
$nombre = $apellido = $email = $password = $repetir = $rol = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre   = test_input($_POST["nombre"] ?? "");
  $apellido = test_input($_POST["apellido"] ?? "");
  $email    = test_input($_POST["email"] ?? "");
  $password = $_POST["password"] ?? "";
  $repetir  = $_POST["repetir"] ?? "";
  $rol      = $_POST["rol"] ?? "";

  if (empty($nombre) || empty($apellido) || empty($email) || empty($password) || empty($repetir) || empty($rol)) {
    $errores[] = "Todos los campos son obligatorios.";
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El correo electrónico no es válido.";
  }

  if ($password !== $repetir) {
    $errores[] = "Las contraseñas no coinciden.";
  }

  if (!filter_password($password)) {
    $errores[] = "La contraseña debe tener al menos 8 caracteres, incluyendo mayúsculas, minúsculas, números y un carácter especial.";
  }

  if (empty($errores)) {
    $contrasena_hash = password_hash($password, PASSWORD_DEFAULT);

    $data = [
      'nombre'     => $nombre,
      'apellido'   => $apellido,
      'email'      => $email,
      'contrasena' => $contrasena_hash,
      'rol'        => $rol
    ];

    try {
      addUsuario($conexion, $data);
      $ultimo_id = $conexion->lastInsertId();

      $_SESSION['usuario'] = [
        'id'     => $ultimo_id,
        'nombre' => $nombre,
        'rol'    => $rol
      ];

      header('Location: bienvenido.php');
      exit;
    } catch (PDOException $e) {
      $_SESSION['error'] = "";
      header('Location: error.php');
      exit;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro - Buscador de Key West</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="img/favicon.ico" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'includes/nav.php'; ?>

<div class="container mt-5 mb-5">
  <h1 class="mb-4">Crear cuenta</h1>
  <h3>No te pierdas las novedades de la isla!</h3>

  <?php if (!empty($errores)): ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach ($errores as $error): ?>
          <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="POST" action="">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre" required value="<?= htmlspecialchars($nombre) ?>">
    </div>

    <div class="mb-3">
      <label for="apellido" class="form-label">Apellido</label>
      <input type="text" class="form-control" id="apellido" name="apellido" required value="<?= htmlspecialchars($apellido) ?>">
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Correo electrónico</label>
      <input type="email" class="form-control" id="email" name="email" required value="<?= htmlspecialchars($email) ?>">
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Contraseña</label>
      <input type="password" class="form-control" id="password" name="password" required>
    </div>

    <div class="mb-3">
      <label for="repetir" class="form-label">Repetir contraseña</label>
      <input type="password" class="form-control" id="repetir" name="repetir" required>
    </div>

    <div class="mb-3">
      <label class="form-label">¿De visita o propietario?</label><br>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="rol" id="invitado" value="invitado" <?= $rol == 'invitado' ? 'checked' : '' ?> required>
        <label class="form-check-label" for="invitado">Invitado</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="rol" id="propietario" value="propietario" <?= $rol == 'propietario' ? 'checked' : '' ?> required>
        <label class="form-check-label" for="propietario">Propietario</label>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">Registrarse</button>
  </form>
</div>

<?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
