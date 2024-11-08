<?php
require_once '../../includes/config.php';  
session_start();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       
        if (
            isset($_POST['cliente'], $_POST['direccion'], $_POST['telefono'], $_POST['metodo_pago'], $_POST['total'])
        ) {
            $cliente = $_POST['cliente'];
            $direccion = $_POST['direccion'];
            $telefono = $_POST['telefono'];
            $metodo_pago = $_POST['metodo_pago'];
            $total = $_POST['total'];

           
            $query = "INSERT INTO pedidos (cliente, direccion, telefono, metodo_pago, total, estado, fecha_pedido)
                      VALUES (?, ?, ?, ?, ?, 'Pendiente', NOW())";
            $stmt = $pdo->prepare($query);

            if ($stmt->execute([$cliente, $direccion, $telefono, $metodo_pago, $total])) {
                
                $pedido_id = $pdo->lastInsertId();

               
                foreach ($_SESSION['carrito'] as $item) {
                    $producto_id = $item['id'];
                    $cantidad = $item['cantidad'];
                    $precio_unitario = $item['precio'];

                    $query_detalle = "INSERT INTO pedidos_detalles (pedido_id, producto_id, cantidad, precio_unitario)
                                      VALUES (?, ?, ?, ?)";
                    $stmt_detalle = $pdo->prepare($query_detalle);
                    $stmt_detalle->execute([$pedido_id, $producto_id, $cantidad, $precio_unitario]);
                }

            
                unset($_SESSION['carrito']);

              
                header('Location: confirmacion.php');
                exit();
            } else {
                echo "Error al guardar el pedido.";
            }
        } else {
            echo "Faltan datos para completar el pedido.";
        }
    }
} catch (Exception $e) {
  
    echo "Error: " . $e->getMessage();
}
?>
