<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('BASE_PATH', dirname(dirname(dirname(dirname(__FILE__)))));
require_once BASE_PATH . '/includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Obtener los datos del formulario
        $fecha_inicio = $_POST['fecha_inicio'] ?? '';
        $fecha_fin = $_POST['fecha_fin'] ?? '';
        $metodo_pago = $_POST['metodo_pago'] ?? '';
        $estado_pedido = $_POST['estado_pedido'] ?? '';

        // Construir la consulta SQL
        $query = "SELECT fecha, metodo_pago, estado, total, cliente FROM pedidos WHERE fecha BETWEEN ? AND ?";
        $params = [$fecha_inicio . " 00:00:00", $fecha_fin . " 23:59:59"];
        
        if ($metodo_pago) {
            $query .= " AND metodo_pago = ?";
            $params[] = $metodo_pago;
        }
        
        if ($estado_pedido) {
            $query .= " AND estado = ?";
            $params[] = $estado_pedido;
        }

        // Ejecutar consulta
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Si no se encontraron pedidos, mostrar un mensaje
        if (empty($pedidos)) {
            die("No se encontraron pedidos para el rango de fechas especificado.");
        }

// Generación del PDF
if (isset($_POST['generate_pdf'])) {
    require_once BASE_PATH . '/includes/fpdf.php';
    define('FPDF_FONTPATH', BASE_PATH . '/includes/font/');

    $pdf = new FPDF('L', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Reporte de Ventas', 0, 1, 'C');

    $pdf->SetFont('Arial', '', 12);

    // Ajuste de color para el encabezado
$pdf->SetFillColor(220, 220, 220); // Color gris claro para el encabezado
$pdf->Cell(60, 10, 'Fecha', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Método de Pago', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Estado', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Total', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Cliente', 1, 0, 'C', true);
$pdf->Ln();

    foreach ($pedidos as $pedido) {
        $pdf->Cell(60, 10, htmlspecialchars($pedido['fecha']), 1);
        $pdf->Cell(60, 10, htmlspecialchars($pedido['metodo_pago']), 1);
        $pdf->Cell(40, 10, htmlspecialchars($pedido['estado']), 1);
        $pdf->Cell(50, 10, '$' . number_format($pedido['total'], 2), 1);
        $pdf->Cell(60, 10, htmlspecialchars($pedido['cliente']), 1);
        $pdf->Ln();
    }

    $pdf->Output('ReporteVentas.pdf', 'D');
    exit;
}
        
        // Mostrar vista previa en HTML
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Vista Previa del Reporte</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                }
                .preview-container {
                    max-width: 1000px;
                    margin: 0 auto;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f4f4f4;
                }
                .actions {
                    margin: 20px 0;
                    text-align: center;
                }
                .btn {
                    padding: 10px 20px;
                    background-color: #4CAF50;
                    color: white;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    margin: 0 10px;
                }
                .btn-back {
                    background-color: #666;
                }
                .report-header {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .filters {
                    margin-bottom: 20px;
                    background-color: #f9f9f9;
                    padding: 15px;
                    border-radius: 4px;
                }
            </style>
        </head>
        <body>
            <div class="preview-container">
                <div class="report-header">
                    <h2>Vista Previa - Reporte de Ventas</h2>
                </div>
                
                <div class="filters">
                    <strong>Período:</strong> <?php echo $fecha_inicio; ?> al <?php echo $fecha_fin; ?><br>
                    <strong>Método de Pago:</strong> <?php echo $metodo_pago ?: 'Todos'; ?><br>
                    <strong>Estado:</strong> <?php echo $estado_pedido ?: 'Todos'; ?>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Método de Pago</th>
                            <th>Estado</th>
                            <th>Total</th>
                            <th>Cliente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($pedido['fecha']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['metodo_pago']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['estado']); ?></td>
                            <td>$<?php echo number_format($pedido['total'], 2); ?></td>
                            <td><?php echo htmlspecialchars($pedido['cliente']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="actions">
                    <form method="POST" style="display: inline;">
                        <!-- Campos ocultos para mantener los filtros -->
                        <input type="hidden" name="fecha_inicio" value="<?php echo htmlspecialchars($fecha_inicio); ?>">
                        <input type="hidden" name="fecha_fin" value="<?php echo htmlspecialchars($fecha_fin); ?>">
                        <input type="hidden" name="metodo_pago" value="<?php echo htmlspecialchars($metodo_pago); ?>">
                        <input type="hidden" name="estado_pedido" value="<?php echo htmlspecialchars($estado_pedido); ?>">
                        <input type="hidden" name="generate_pdf" value="1">
                        <button type="submit" class="btn">Descargar PDF</button>
                    </form>
                    <button onclick="window.location.href='generar_reporte.php'" class="btn btn-back">Volver</button>
                </div>
            </div>
        </body>
        </html>
        <?php
        exit;
    } catch (Exception $e) {
        die("Error al generar el reporte: " . $e->getMessage());
    }
}
?>
