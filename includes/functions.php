<?php
include 'config.php'; // Asegúrate de incluir el archivo de configuración

function obtenerProductos($pdo) {
    $sql = "SELECT * FROM productos";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerProductoPorId($id) {
    global $pdo; // Usamos la variable global para acceder a la conexión
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function contarProductosEnCarrito() {
    if (isset($_SESSION['carrito'])) {
        return array_sum(array_column($_SESSION['carrito'], 'cantidad'));
    }
    return 0; // Si no hay productos, devuelve 0
}

?>
