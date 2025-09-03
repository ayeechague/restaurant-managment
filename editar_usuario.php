<?php
require_once('./_init.php');
require_once('./bd/conexion.php');
require_once('./bd/consultas_usuarios.php');

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuario = $_SESSION['usuario'];
$errores = [];
$exito = "";

if (!isset($usuario['id'])) {
    header('Location: login.php');
    exit;
}

$datos = getUsuarioPorId($conexion, (int)$usuario['id']);


$nombre = $datos['nombre'] ?? '';
$apellido = $datos['apellido'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $nueva_contra = $_POST['password'] ?? '';
    $repetir = $_POST['repetir'] ?? '';

    if (empty($nombre) || empty($apellido)) {
        $errores[] = "Nombre y apellido son obligatorios.";
    }

    if (!empty($nueva_contra)) {
        if (strlen($nueva_contra) < 8) {
            $errores[] = "La contraseña debe tener al menos 8 caracteres.";
        } elseif ($nueva_contra !== $repetir) {
            $errores[] = "Las contraseñas no coinciden.";
        }
    }

    if (empty($errores)) {
        $datos_actualizados = [
            'id' => $usuario['id'],
            'nombre' => $nombre,
            'apellido' => $apellido,
            'contrasena' => !empty($nueva_contra) ? password_hash($nueva_contra, PASSWORD_DEFAULT) : null
        ];

        actualizarUsuario($conexion, $datos_actualizados);
        $_SESSION['usuario']['nombre'] = $nombre;
        $exito = "Los datos fueron actualizados correctamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cuenta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
</head>
<body>
<?php include 'includes/nav.php'; ?>

<div class="container mt-5 mb-5">
    <h1>Editar mis datos</h1>

    <?php if ($exito): ?>
        <div class="alert alert-success"><?= $exito ?></div>
    <?php endif; ?>

    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($nombre) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Apellido</label>
            <input type="text" name="apellido" class="form-control" value="<?= htmlspecialchars($apellido) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nueva Contraseña (opcional)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Repetir Nueva Contraseña</label>
            <input type="password" name="repetir" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
