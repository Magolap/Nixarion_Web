<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Aquí verifica si el usuario existe en la base de datos
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($password, $usuario['password'])) {
        // Iniciar sesión
        $_SESSION['usuario_id'] = $usuario['id'];
        header("Location: index.php"); // Redirigir a la página principal o a donde quieras
        exit();
    } else {
        $error = "Credenciales incorrectas.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }
        .login-container {
            width: 400px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .login-container h1 {
            margin-top: 0;
            font-size: 1.5em;
        }
        .icon-info {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            color: #8e44ad ;
        }
        .icon-info div {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .form-group {
            margin: 15px 0;
            text-align: left;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-top: 5px;
        }
        .submit-button {
            width: 100%;
            padding: 12px;
            background-color: #8e44ad;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.2em;
            cursor: pointer;
        }
        .alt-links {
            margin-top: 15px;
            font-size: 0.9em;
            color: gray;
        }
        .alt-links a {
            text-decoration: none;
            color: #8e44ad;
            margin: 0 10px;
        }
        .social-icons {
            display: flex;
            justify-content: space-around;
            margin-top: 15px;
        }
        .social-icons i {
            font-size: 1.5em;
            color: #555;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div style="color: green; font-size: 0.9em;">🔒 Todos los datos se cifrarán</div>

        <div class="icon-info">
            <div>
                <span>🚚</span>
                <span>Envío gratis</span>
                <small>En todos los pedidos</small>
            </div>
            <div>
                <span>📦</span>
                <span>Devolución en un plazo de 90 días</span>
                <small>desde la fecha de compra</small>
            </div>
        </div>

        <?php if (isset($error)): ?>
            <p style="color: red;"><?= $error; ?></p>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="submit-button">Ingresar</button>
        </form>

        <div class="alt-links"> 
            <a href="registro.php">Registrarse</a> | 
            <a href="#">¿Olvidó su contraseña?</a>
        </div>

        <p>O continúa de otras maneras</p>
        <div class="social-icons">
         <i class="fab fa-google"></i>
         <i class="fab fa-facebook-f"></i>
         <i class="fab fa-apple"></i>
        </div>

        
        <p class="alt-links">
            Al continuar, aceptas nuestros <a href="#">Términos de uso</a> y <a href="#">Política de privacidad</a>.
        </p>
    </div>
</body>
</html>
