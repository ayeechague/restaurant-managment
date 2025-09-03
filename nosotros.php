<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Nosotros - Buscador de Key West</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="img/favicon.ico" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <?php include 'includes/nav.php'; ?>

  <div class="container mt-5">
    <h1 class="mb-4 text-center">Sobre Nosotros</h1>

    <div class="row align-items-center">
      <div class="col-md-6">
        <p>
          El <strong>Buscador de Key West</strong> nace de la idea de ayudar a residentes y turistas a encontrar los mejores lugares para comer, disfrutar y relajarse en esta hermosa isla.
        </p>
        <p>
          Reunimos recomendaciones confiables, actualizadas por personas locales, para que vivas una experiencia auténtica.
        </p>
        <p>
          Nuestro objetivo es ofrecerte una guía útil, práctica y amigable que reúna lo mejor de Key West en un solo lugar.
        </p>
      </div>
      <div class="col-md-6 text-center d-flex justify-content-center align-items-center">
  <img src="img/keywest.jpg" 
       alt="Key West" 
       class="rounded shadow"
       style="width: 400px; height: 300px; object-fit: cover;">
</div>
    </div>

    <hr class="my-5">

    <div class="row">
      <div class="col text-center">
        <h2>¿Quiénes somos?</h2>
        <p class="mt-3">
          Somos un equipo apasionado por la buena comida, los espacios pet-friendly, y todo lo que hace única a esta isla.
          Creemos en apoyar a los negocios locales compartiendo nuestras experiencias con vos.
        </p>
      </div>
    </div>
  </div>

  <?php include 'includes/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
