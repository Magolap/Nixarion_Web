<?php
session_start();
error_reporting(E_ALL); // Reportar todos los errores
ini_set('display_errors', 1); // Mostrar errores en pantalla

require_once '../includes/config.php';
require_once '../includes/functions.php';

// Verificar conexión
if (isset($pdo)) {
    echo "Conexión exitosa a la base de datos.";
} else {
    echo "No se pudo conectar a la base de datos.";
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener el ID del usuario de la sesión
$usuario_id = $_SESSION['usuario_id'];

// Obtener la dirección de envío desde el formulario
$direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';

// Procesar el pedido si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar que la dirección no esté vacía
    if (!empty($direccion)) {
        // Calcular el total del pedido
        $total = calcularTotalDelCarrito();

        // Insertar el pedido en la base de datos
        $stmt = $pdo->prepare("INSERT INTO pedidos (usuario_id, total, direccion, estado) VALUES (?, ?, ?, 'pendiente')");
        $stmt->execute([$usuario_id, $total, $direccion]);

        // Obtener el ID del nuevo pedido
        $pedido_id = $pdo->lastInsertId();

        // Procesar los productos en el carrito y añadirlos al pedido
        procesarCarrito($pedido_id, $usuario_id);

        // Redirigir a la página de confirmación
        header("Location: confirmacion.php?id=$pedido_id");
        exit();
    } else {
        echo "La dirección no puede estar vacía.";
    }
}

// Función para calcular el total del carrito
function calcularTotalDelCarrito() {
    $total = 0;

    // Verificar si hay productos en el carrito
    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $producto) {
            // Suponiendo que cada producto tiene 'precio' y 'cantidad'
            $total += $producto['precio'] * $producto['cantidad'];
        }
    }

    return $total;
}

// Función para procesar los productos del carrito
function procesarCarrito($pedido_id, $usuario_id) {
    global $pdo; // Usar la conexión de la base de datos

    // Verificar si hay productos en el carrito
    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $producto) {
            // Insertar cada producto en la tabla de detalles del pedido
            $stmt = $pdo->prepare("INSERT INTO detalles_pedido (pedido_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)");
            $stmt->execute([$pedido_id, $producto['id'], $producto['cantidad'], $producto['precio']]);
        }

        // Limpiar el carrito después de procesar
        unset($_SESSION['carrito']);
    }
}
?>
