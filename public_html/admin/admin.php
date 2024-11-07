<?php
session_start();
if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    header('Location: ../login.php');
    exit;
}
include('../includes/config.php');

// Obtener estadísticas rápidas
$totalProductos = $pdo->query("SELECT COUNT(*) FROM productos")->fetchColumn();
$totalUsuarios = $pdo->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
$totalPedidos = $pdo->query("SELECT COUNT(*) FROM pedidos")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h1>Bienvenido al Panel de Administración</h1>
    <div>
        <p>Total de productos: <?= $totalProductos ?></p>
        <p>Total de usuarios: <?= $totalUsuarios ?></p>
        <p>Total de pedidos: <?= $totalPedidos ?></p>
    </div>
    <nav>
        <ul>
            <li><a href="productos.php">Gestión de Productos</a></li>
            <li><a href="usuarios.php">Gestión de Usuarios</a></li>
            <li><a href="pedidos.php">Gestión de Pedidos</a></li>
        </ul>
    </nav>
</body>
</html>
