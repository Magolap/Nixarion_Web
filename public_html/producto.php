<?php
include '../includes/config.php'; // Incluye el archivo de configuración
include '../includes/functions.php';

$id_producto = $_GET['id']; // Obtén el id del producto desde la URL
$producto = obtenerProductoPorId($id_producto); // Usa la función para obtener el producto

if (!$producto) {
    echo "Producto no encontrado";
    exit; // Detén la ejecución si no se encuentra el producto
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $producto['nombre']; ?></title>
    <link rel="stylesheet" href="../assets/css/styles.css"> <!-- Ajusta la ruta según sea necesario -->
</head>
<body>
    <h1><?= $producto['nombre']; ?></h1>
    <p><?= $producto['descripcion']; ?></p>
    <p>Precio: $<?= number_format($producto['precio'], 0, ',', '.'); ?> COP</p>
    <p>Stock: <?= $producto['stock']; ?></p>
    <img src="<?= $producto['imagen']; ?>" alt="<?= $producto['nombre']; ?>"> <!-- Asegúrate de que la ruta sea correcta -->
</body>
</html>
