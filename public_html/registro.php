<?php
session_start();
require_once '../includes/config.php'; // Incluye la configuración de la base de datos
require_once '../includes/functions.php'; // Incluye funciones necesarias

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Validar si el email ya está registrado
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $error = "Este correo ya está registrado.";
    } else {
        // Hash de la contraseña
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        // Insertar el nuevo usuario en la base de datos
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password, es_admin, fecha_registro) VALUES (?, ?, ?, 0, NOW())");
        $stmt->execute([$nombre, $email, $passwordHash]);
        
        // Redirigir a la página de inicio de sesión o mostrar un mensaje de éxito
        header("Location: login.php");
        exit();
    }
}
?>

<!-- Formulario de registro -->
<form method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit">Registrarse</button>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</form>
