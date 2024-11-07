<?php
include('../includes/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    $sql = "INSERT INTO productos (nombre, precio, stock) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $precio, $stock]);

    header('Location: productos.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Producto</title>
</head>
<body>
    <h2>Añadir Producto</h2>
    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre del producto" required><br>
        <input type="number" step="0.01" name="precio" placeholder="Precio" required><br>
        <input type="number" name="stock" placeholder="Stock disponible" required><br>
        <button type="submit">Añadir Producto</button>
    </form>
</body>
</html>
