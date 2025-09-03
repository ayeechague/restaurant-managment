<?php
require_once('./_init.php');
require_once('./bd/conexion.php');
require_once('./bd/consultas_restaurantes.php');

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $petFriendly = $_POST['petFriendly'] ?? '';
    $musica = $_POST['musica'] ?? '';
    $precio = $_POST['precio'] ?? '';

    $nombreImagen = 'default.png';

    if (empty($nombre) || empty($tipo) || empty($petFriendly) || empty($musica) || empty($precio)) {
        $errores[] = "Todos los campos son obligatorios.";
    }

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $nombreImagen = uniqid() . '_' . basename($_FILES['imagen']['name']);
        $rutaDestino = 'img/restaurantes/' . $nombreImagen;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino);
    }

    if (empty($errores)) {
        addRestaurante($conexion, [
            'nombre' => $nombre,
            'tipo' => $tipo,
            'petFriendly' => $petFriendly,
            'musica' => $musica,
            'precio' => $precio,
            'imagen' => $nombreImagen
        ]);

        header('Location: lista_restaurantes.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Restaurante</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="img/favicon.ico" type="image/x-icon">
</head>
<body>
<?php include './includes/nav.php'; ?>

<div class="container mt-5">
  <h2>Agregar nuevo restaurante</h2>

  <?php if (!empty($errores)): ?>
    <div class="alert alert-danger">
      <ul>
        <?php foreach ($errores as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" name="nombre" id="nombre" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="tipo" class="form-label">Tipo</label>
      <select name="tipo" class="form-select" required>
        <option value="Brunch">Brunch</option>
        <option value="Italian">Italian</option>
        <option value="Mexican">Mexican</option>
        <option value="Fine dinning">Fine dinning</option>
        <option value="Sushi">Sushi</option>
        <option value="Dessert">Dessert</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Pet Friendly</label>
      <select name="petFriendly" class="form-select" required>
        <option value="Si">Sí</option>
        <option value="No">No</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Música en vivo</label>
      <select name="musica" class="form-select" required>
        <option value="Si">Sí</option>
        <option value="No">No</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Precio</label>
      <select name="precio" class="form-select" required>
        <option value="$">$</option>
        <option value="$$">$$</option>
        <option value="$$$">$$$</option>
        <option value="$$$$">$$$$</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="imagen" class="form-label">Imagen (opcional)</label>
      <input type="file" name="imagen" id="imagen" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Agregar</button>
    <a href="lista_restaurantes.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
</body>
</html>

