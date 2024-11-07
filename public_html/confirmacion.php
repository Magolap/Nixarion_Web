<?php
session_start();

if (!isset($_SESSION['pedido_confirmado'])) {
    echo "No hay información sobre el pedido confirmado.";
    exit;
}

$pedido_confirmado = $_SESSION['pedido_confirmado'];
$cliente = $pedido_confirmado['cliente'] ?? 'Información no disponible';
$telefono = $pedido_confirmado['telefono'] ?? 'Información no disponible';
$metodo_pago = $pedido_confirmado['metodo_pago'] ?? 'Información no disponible';
$direccion = $pedido_confirmado['direccion'] ?? 'Información no disponible';
$total = $pedido_confirmado['total'] ?? 0;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Pedido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .confirmation-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            text-align: center;
        }
        .confirmation-container h2 {
            color: #27ae60;
            margin-bottom: 20px;
        }
        .confirmation-container p {
            font-size: 16px;
            line-height: 1.5;
            margin: 10px 0;
        }
        .highlight {
            font-weight: bold;
            color: #2c3e50;
        }
        .total {
            font-size: 20px;
            color: #e74c3c;
            font-weight: bold;
        }
        .back-to-shop {
            margin-top: 20px;
            display: inline-block;
            text-decoration: none;
            color: #fff;
            background-color: #3498db;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .back-to-shop:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="confirmation-container">
    <h2>Confirmación de Pedido</h2>
    <p><span class="highlight">ID del Pedido:</span> <?php echo htmlspecialchars($pedido_confirmado['id']); ?></p>
    <p><span class="highlight">Cliente:</span> <?php echo htmlspecialchars($cliente); ?></p>
    <p><span class="highlight">Teléfono:</span> <?php echo htmlspecialchars($telefono); ?></p>
    <p><span class="highlight">Método de Pago:</span> <?php echo htmlspecialchars($metodo_pago); ?></p>
    <p><span class="highlight">Dirección:</span> <?php echo htmlspecialchars($direccion); ?></p>
    <p class="total">Total: $<?php echo number_format($total, 2); ?></p>
    <a href="index.php" class="back-to-shop">Volver a la Tienda</a>
</div>

</body>
</html>
