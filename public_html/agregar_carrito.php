<?php
session_start();
include '../includes/config.php'; // Asegúrate de que esta ruta sea correcta

if (isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];
    // Aquí debes obtener el producto desde la base de datos
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->execute([$id_producto]);
    $producto = $stmt->fetch();

    if ($producto) {
        // Lógica para agregar el producto al carrito
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;

        $producto_en_carrito = false;
        foreach ($_SESSION['carrito'] as &$item) {
            if ($item['id'] === $producto['id']) {
                $item['cantidad'] += $cantidad; // Aumentar la cantidad
                $producto_en_carrito = true;
                break;
            }
        }

        // Si el producto no estaba en el carrito, añadirlo
        if (!$producto_en_carrito) {
            $_SESSION['carrito'][] = [
                'id' => $producto['id'],
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio'],
                'cantidad' => $cantidad,
            ];
        }

        // Calcular el número total de productos en el carrito
        $totalCantidad = array_sum(array_column($_SESSION['carrito'], 'cantidad'));

        // Devolver respuesta en JSON
        echo json_encode(['success' => true, 'cartCount' => $totalCantidad]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Producto no encontrado.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID de producto no proporcionado.']);
}
?>
