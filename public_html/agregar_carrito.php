<?php
session_start();
include '../includes/config.php'; 

if (isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];
    
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->execute([$id_producto]);
    $producto = $stmt->fetch();

    if ($producto) {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;

        $producto_en_carrito = false;
        foreach ($_SESSION['carrito'] as &$item) {
            if ($item['id'] === $producto['id']) {
                $item['cantidad'] += $cantidad; 
                $producto_en_carrito = true;
                break;
            }
        }

      
        if (!$producto_en_carrito) {
            $_SESSION['carrito'][] = [
                'id' => $producto['id'],
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio'],
                'cantidad' => $cantidad,
            ];
        }

      
        $totalCantidad = array_sum(array_column($_SESSION['carrito'], 'cantidad'));


        echo json_encode(['success' => true, 'cartCount' => $totalCantidad]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Producto no encontrado.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID de producto no proporcionado.']);
}
?>
