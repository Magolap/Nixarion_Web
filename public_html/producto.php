<?php
include '../includes/config.php'; 
include '../includes/functions.php';

$id_producto = $_GET['id']; 
$producto = obtenerProductoPorId($id_producto); 

if (!$producto) {
    echo "Producto no encontrado";
    exit; 
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $producto['nombre']; ?></title>
    <link rel="stylesheet" href="../assets/css/styles.css"> 
</head>
<body>
    <h1><?= $producto['nombre']; ?></h1>
    <p><?= $producto['descripcion']; ?></p>
    <p>Precio: $<?= number_format($producto['precio'], 0, ',', '.'); ?> COP</p>
    <p>Stock: <?= $producto['stock']; ?></p>
    <img src="<?= $producto['imagen']; ?>" alt="<?= $producto['nombre']; ?>"> 
</body>
</html>
