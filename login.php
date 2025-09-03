<?php
session_start();

require_once('./funciones/funciones_input.php');
require_once('./bd/conexion.php');
require_once('./bd/consultas_usuarios.php');

$errores = [];
$email = $_POST['email'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  $email = filter_var($email, FILTER_VALIDATE_EMAIL);
  $contrasena = test_input($contrasena);

  if (!$email || empty($contrasena)) {
    $errores[] = 'Todos los campos son obligatorios y el email debe ser válido.';
  } else {
    $usuario = getUsuarioLogin($conexion, $email);

    if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
      $_SESSION['usuario'] = [
        'id' => $usuario['id'],
        'nombre' => $usuario['nombre'],
        'rol' => $usuario['rol']
      ];

      header('Location: ./bienvenido.php'); 
      exit;
    } else {
      $errores[] = 'Los datos ingresados son incorrectos.';
    }
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar sesión - Buscador de Key West</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="img/favicon.ico" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'includes/nav.php'; ?>

<div class="container mt-5 mb-5">
  <h1 class="mb-4">Iniciar sesión</h1>

  <?php if (!empty($errores)): ?>
    <div class="alert alert-danger">
      <?php foreach ($errores as $error): ?>
        <p><?= htmlspecialchars($error) ?></p>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <form method="POST" action="">
    <div class="mb-3">
      <label for="email" class="form-label">Correo electrónico</label>
      <input type="email" class="form-control" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
    </div>

    <div class="mb-3">
      <label for="contrasena" class="form-label">Contraseña</label>
      <input type="password" class="form-control" id="contrasena" name="contrasena" required>
    </div>

    <button type="submit" class="btn btn-primary">Enviar</button>
  </form>
</div>

<?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
