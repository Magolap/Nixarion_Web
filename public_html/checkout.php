<?php
session_start();
error_reporting(E_ALL); 
ini_set('display_errors', 1); 

require_once '../includes/config.php';
require_once '../includes/functions.php';

if (isset($pdo)) {
    echo "Conexión exitosa a la base de datos.";
} else {
    echo "No se pudo conectar a la base de datos.";
}


if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];


$direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (!empty($direccion)) {
 
        $total = calcularTotalDelCarrito();

     
        $stmt = $pdo->prepare("INSERT INTO pedidos (usuario_id, total, direccion, estado) VALUES (?, ?, ?, 'pendiente')");
        $stmt->execute([$usuario_id, $total, $direccion]);

       
        $pedido_id = $pdo->lastInsertId();

        
        procesarCarrito($pedido_id, $usuario_id);

      
        header("Location: confirmacion.php?id=$pedido_id");
        exit();
    } else {
        echo "La dirección no puede estar vacía.";
    }
}

function calcularTotalDelCarrito() {
    $total = 0;

 
    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $producto) {
           
            $total += $producto['precio'] * $producto['cantidad'];
        }
    }

    return $total;
}


function procesarCarrito($pedido_id, $usuario_id) {
    global $pdo; 

    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $producto) {
           
            $stmt = $pdo->prepare("INSERT INTO detalles_pedido (pedido_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)");
            $stmt->execute([$pedido_id, $producto['id'], $producto['cantidad'], $producto['precio']]);
        }

     
        unset($_SESSION['carrito']);
    }
}
?>
