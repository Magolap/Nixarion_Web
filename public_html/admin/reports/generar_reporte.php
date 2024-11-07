<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../../includes/config.php';
require_once '../../../includes/fpdf.php'; 
define('FPDF_FONTPATH', '../../../includes/font/');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenemos los datos enviados por el formulario
    $fecha_inicio = $_POST['fecha_inicio'] ?? '';
    $fecha_fin = $_POST['fecha_fin'] ?? '';
    $metodo_pago = $_POST['metodo_pago'] ?? '';
    $estado_pedido = $_POST['estado_pedido'] ?? '';

    if ($fecha_inicio && $fecha_fin) {
        // Aquí iría la lógica para generar el PDF o mostrar los datos
        echo "<p>Generando reporte desde $fecha_inicio hasta $fecha_fin</p>";
        echo "<p>Método de pago: " . ($metodo_pago ?: "Todos") . "</p>";
        echo "<p>Estado del pedido: " . ($estado_pedido ?: "Todos") . "</p>";
        // Código adicional para generar el PDF o mostrar el reporte
    } else {
        echo "<p>No se han enviado datos válidos.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .reporte-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .reporte-container h2 {
            color: #333;
            text-align: center;
        }

        form label {
            display: block;
            margin: 10px 0 5px;
            color: #333;
            font-weight: bold;
        }

        form input[type="date"],
        form select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        form button {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="reporte-container">
        <h2>Generar Reporte de Ventas</h2>
        <form method="POST" action="reportes.php">
            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" required>

            <label for="fecha_fin">Fecha de Fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" required>

            <label for="metodo_pago">Método de Pago:</label>
            <select id="metodo_pago" name="metodo_pago">
                <option value="">-- Todos --</option>
                <option value="efectivo">Efectivo</option>
                <option value="tarjeta">Tarjeta</option>
                <option value="transferencia">Transferencia</option>
            </select>

            <label for="estado_pedido">Estado del Pedido:</label>
            <select id="estado_pedido" name="estado_pedido">
                <option value="">-- Todos --</option>
                <option value="completado">Completado</option>
                <option value="pendiente">Pendiente</option>
                <option value="cancelado">Cancelado</option>
            </select>

            <button type="submit">Generar PDF</button>
        </form>
    </div>
</body>
</html>