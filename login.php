<?php
session_start();
include '../includes/config.php'; // Ajusta la ruta según tu estructura de carpetas

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta para verificar si el usuario existe
    $query = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
    $query->execute(['email' => $email]);
    $usuario = $query->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['password'])) {
        $_SESSION['usuario'] = $usuario;

        // Redirigir según el tipo de usuario
        if ($usuario['es_admin'] == 1) {
            header('Location: admin/gestionar_pedidos.php');
        } else {
            header('Location: index.php');
        }
        exit;
    } else {
        $error = "Credenciales incorrectas o no tienes acceso administrativo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Iniciar Sesión</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>
