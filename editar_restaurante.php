<?php
require_once('./_init.php');
require_once('./bd/conexion.php');
require_once('./bd/consultas_restaurantes.php');

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: lista_restaurantes.php');
    exit;
}

$restaurante = getRestaurantePorID($conexion, $id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $petFriendly = $_POST['petFriendly'];
    $musica = $_POST['musica'];
    $precio = $_POST['precio'];

    $imagen = $restaurante['imagen'];

    if (!empty($_FILES['imagen']['name'])) {
        $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nuevoNombre = $id . '.' . $extension;
        $rutaImagen = 'img/restaurantes/' . $nuevoNombre;

        move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen);
        $imagen = $nuevoNombre;
    }

    $data = [
        'nombre' => $nombre,
        'tipo' => $tipo,
        'petFriendly' => $petFriendly,
        'musica' => $musica,
        'precio' => $precio,
        'imagen' => $imagen
    ];

    actualizarRestaurante($conexion, $id, $data);
    header('Location: lista_restaurantes.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Restaurante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include './includes/nav.php'; ?>

<div class="container mt-5">
    <h2>Editar restaurante</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del restaurante</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required value="<?= htmlspecialchars($restaurante['nombre']) ?>">
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <select name="tipo" class="form-select" required>
                <?php foreach (['Brunch', 'Italian', 'Mexican', 'Fine dinning', 'Sushi', 'Dessert'] as $opcion): ?>
                    <option value="<?= $opcion ?>" <?= $restaurante['tipo'] === $opcion ? 'selected' : '' ?>><?= $opcion ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Pet Friendly</label>
            <select name="petFriendly" class="form-select" required>
                <option value="Si" <?= $restaurante['petFriendly'] === 'Si' ? 'selected' : '' ?>>Sí</option>
                <option value="No" <?= $restaurante['petFriendly'] === 'No' ? 'selected' : '' ?>>No</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Música en vivo</label>
            <select name="musica" class="form-select" required>
                <option value="Si" <?= $restaurante['musica'] === 'Si' ? 'selected' : '' ?>>Sí</option>
                <option value="No" <?= $restaurante['musica'] === 'No' ? 'selected' : '' ?>>No</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Precio</label>
            <select name="precio" class="form-select" required>
                <?php foreach (['$', '$$', '$$$', '$$$$'] as $precio): ?>
                    <option value="<?= $precio ?>" <?= $restaurante['precio'] === $precio ? 'selected' : '' ?>><?= $precio ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Cambiar imagen (opcional)</label><br>
            <input type="file" name="imagen" accept="image/*" class="form-control">
            <small class="form-text text-muted">Si no seleccionás ninguna imagen, se mantiene la actual.</small>
        </div>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="lista_restaurantes.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>

