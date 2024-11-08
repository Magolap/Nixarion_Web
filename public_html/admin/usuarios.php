<?php

require_once '../../includes/config.php';

function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? hashPassword($_POST['password']) : null;
    $es_admin = isset($_POST['es_admin']) ? 1 : 0;

    if ($id) {
        if ($password) {
            $query = "UPDATE usuarios SET nombre=?, email=?, password=?, es_admin=? WHERE id=?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$nombre, $email, $password, $es_admin, $id]);
        } else {
            $query = "UPDATE usuarios SET nombre=?, email=?, es_admin=? WHERE id=?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$nombre, $email, $es_admin, $id]);
        }
    } else {
        $query = "INSERT INTO usuarios (nombre, email, password, es_admin, fecha_registro) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$nombre, $email, $password, $es_admin]);
    }

    header("Location: usuarios.php");
    exit();
}

if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $query = "DELETE FROM usuarios WHERE id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);

    header("Location: usuarios.php");
    exit();
}

$query = "SELECT * FROM usuarios";
$stmt = $pdo->query($query);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto 30px;
        }

        form input, form button, form label {
            display: block;
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 5px;
            display: inline-block;
        }

        .btn-editar {
            background-color: #4CAF50;
            color: white;
        }

        .btn-eliminar {
            background-color: #f44336;
            color: white;
        }

        .btn-editar:hover {
            background-color: #45a049;
        }

        .btn-eliminar:hover {
            background-color: #e53935;
        }

        .acciones {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <h1>Gestión de Usuarios</h1>

    <form method="POST" action="usuarios.php">
        <input type="hidden" name="id" value="<?php echo $_GET['editar'] ?? ''; ?>">
        <input type="text" name="nombre" placeholder="Nombre" required value="<?php echo $_GET['nombre'] ?? ''; ?>">
        <input type="email" name="email" placeholder="Email" required value="<?php echo $_GET['email'] ?? ''; ?>">
        <input type="password" name="password" placeholder="Contraseña">
        <label>
            <input type="checkbox" name="es_admin" <?php echo (isset($_GET['es_admin']) && $_GET['es_admin']) ? 'checked' : ''; ?>>
            ¿Es Administrador?
        </label>
        <button type="submit">Guardar</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Administrador</th>
                <th>Fecha de Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo $usuario['id']; ?></td>
                    <td><?php echo $usuario['nombre']; ?></td>
                    <td><?php echo $usuario['email']; ?></td>
                    <td><?php echo $usuario['es_admin'] ? 'Sí' : 'No'; ?></td>
                    <td><?php echo $usuario['fecha_registro']; ?></td>
                    <td class="acciones">
                        <a href="usuarios.php?editar=<?php echo $usuario['id']; ?>&nombre=<?php echo $usuario['nombre']; ?>&email=<?php echo $usuario['email']; ?>&es_admin=<?php echo $usuario['es_admin']; ?>" class="btn btn-editar">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="usuarios.php?eliminar=<?php echo $usuario['id']; ?>" class="btn btn-eliminar" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">
                            <i class="fas fa-trash"></i> Eliminar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
