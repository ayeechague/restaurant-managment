<?php
session_start();
require_once('./bd/conexion.php');


$stmt = $conexion->query("SELECT * FROM restaurantes");
$lista_menu = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Restaurantes</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="img/favicon.ico" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include 'includes/nav.php'; ?>

  <div class="container mt-5">
    <h1 class="mb-4 text-center">Lista de Restaurantes</h1>

    <div class="row row-cols-1 row-cols-md-2 g-4">
      <?php foreach ($lista_menu as $item) { ?>
        <div class="col">
          <div class="card h-100 shadow-sm">
            <img src="img/restaurantes/<?php echo htmlspecialchars($item['imagen'] ?? 'default.jpg'); ?>" 
     alt="Imagen de <?php echo htmlspecialchars($item['nombre']); ?>" 
     class="card-img-top" 
     style="height: 200px; object-fit: cover;" 
     onerror="this.src='img/restaurantes/default.jpg';">

            <div class="card-body">
              <h5 class="card-title"><?php echo $item["nombre"]; ?></h5>
              <p class="card-text">
                <strong>Tipo:</strong>
                <img src="img/logos/<?php echo $item["tipo"]; ?>.png" alt="Logo de <?php echo $item['tipo']; ?>" style="width: 30px; height: 30px; object-fit: contain; margin-right: 5px;">
                <?php echo $item["tipo"]; ?><br>
                <strong>Pet Friendly:</strong> <?php echo $item["petFriendly"]; ?><br>
                <strong>Música:</strong> <?php echo $item["musica"]; ?><br>
                <strong>Precio:</strong> <?php echo $item["precio"]; ?>
              </p>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>

  <?php include 'includes/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
