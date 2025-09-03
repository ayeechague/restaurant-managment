<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Error de Conexión - Buscador de Key West</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="img/favicon.ico" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <?php include 'includes/nav.php'; ?>

  <div class="container d-flex flex-column justify-content-center align-items-center text-center min-vh-100">
    <div class="mb-4">
      <img src="img/error.png" class="img-fluid" style="max-width: 400px;" alt="Error de conexión">
    </div>
    <h2 class="text-muted mb-3">Parece que hay un problema de conexión </h2>
    <p class="text-secondary mb-4">Intenta de nuevo más tarde.</p>
    <a href="/" class="btn btn-primary">Volver al inicio</a>
  </div>

  <?php include 'includes/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
