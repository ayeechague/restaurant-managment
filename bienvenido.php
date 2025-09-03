<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Bienvenido</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="img/favicon.ico" type="image/x-icon">
</head>
<body>
  <?php include 'includes/nav.php'; ?>
  <div class="container mt-5">
    <div class="alert alert-success">
      <h1>¡Bienvenido/a <?= $_SESSION['usuario']['nombre'] ?? 'usuario' ?>!</h1>
      <a href="index.php" class="btn btn-primary">Ir a la página principal</a>
    </div>
  </div>
  <?php include 'includes/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
