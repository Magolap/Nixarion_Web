<?php
session_start();
require_once '../includes/config.php'; 


if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "No tienes productos en el carrito. <a href='index.php'>Volver a la tienda</a>";
    exit;
}


$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$metodo_pago = $_POST['metodo_pago'];

try {
    $pdo->beginTransaction();

    
    $query_pedido = "INSERT INTO pedidos (cliente, direccion, telefono, metodo_pago, total, estado, fecha) VALUES (?, ?, ?, ?, ?, 'Pendiente', NOW())";
    $stmt_pedido = $pdo->prepare($query_pedido);
    $total = array_sum(array_map(fn($producto) => $producto['precio'] * $producto['cantidad'], $_SESSION['carrito']));
    $stmt_pedido->execute([$nombre, $direccion, $telefono, $metodo_pago, $total]);
    $pedido_id = $pdo->lastInsertId();

    
    $query_detalle = "INSERT INTO pedidos_detalles (pedido_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
    $stmt_detalle = $pdo->prepare($query_detalle);

    $query_stock = "UPDATE productos SET stock = stock - ? WHERE id = ?";
    $stmt_stock = $pdo->prepare($query_stock);

    foreach ($_SESSION['carrito'] as $producto) {
       
        $stmt_detalle->execute([$pedido_id, $producto['id'], $producto['cantidad'], $producto['precio']]);

        
        $stmt_stock->execute([$producto['cantidad'], $producto['id']]);
    }

    $pdo->commit();


    unset($_SESSION['carrito']);
    $_SESSION['pedido_confirmado'] = [
        'id' => $pedido_id,
        'total' => $total,
        'productos' => $_SESSION['carrito'],
        'cliente' => $nombre,
        'direccion' => $direccion,
        'telefono' => $telefono,
        'metodo_pago' => $metodo_pago
    ];
    header("Location: confirmacion.php");
    exit;
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Error al confirmar el pedido: " . $e->getMessage();
}
?>
