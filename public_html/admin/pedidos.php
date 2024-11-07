<?php
// Conexión con la base de datos
require_once '../../includes/config.php';

// Cambiar el estado del pedido si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cambiar_estado'])) {
    $pedido_id = $_POST['pedido_id'];
    $nuevo_estado = $_POST['estado'];

    $query = "UPDATE pedidos SET estado=? WHERE id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$nuevo_estado, $pedido_id]);

    header("Location: pedidos.php");
    exit();
}

// Obtener todos los pedidos
$query = "SELECT * FROM pedidos";
$stmt = $pdo->query($query);
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pedidos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            padding: 20px;
        }
        h1 { text-align: center; color: #333; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #4CAF50; color: white; }
        tr:hover { background-color: #f1f1f1; }
        .btn { padding: 8px 12px; text-decoration: none; border-radius: 5px; margin-right: 5px; display: inline-block; }
        .btn-estado { background-color: #2196F3; color: white; }
        .btn-estado:hover { background-color: #1E88E5; }
    </style>
</head>
<body>
    <h1>Gestión de Pedidos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Método de Pago</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?php echo $pedido['id']; ?></td>
                    <td><?php echo $pedido['cliente']; ?></td>
                    <td><?php echo $pedido['direccion']; ?></td>
                    <td><?php echo $pedido['telefono']; ?></td>
                    <td><?php echo $pedido['metodo_pago']; ?></td>
                    <td><?php echo $pedido['total']; ?></td>
                    <td><?php echo $pedido['estado']; ?></td>
                    <td><?php echo $pedido['fecha']; ?></td>
                    <td>
                        <form method="POST" action="pedidos.php">
                            <input type="hidden" name="pedido_id" value="<?php echo $pedido['id']; ?>">
                            <select name="estado">
                                <option value="Pendiente" <?php echo ($pedido['estado'] === 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="En Proceso" <?php echo ($pedido['estado'] === 'En Proceso') ? 'selected' : ''; ?>>En Proceso</option>
                                <option value="Completado" <?php echo ($pedido['estado'] === 'Completado') ? 'selected' : ''; ?>>Completado</option>
                                <option value="Cancelado" <?php echo ($pedido['estado'] === 'Cancelado') ? 'selected' : ''; ?>>Cancelado</option>
                            </select>
                            <button type="submit" name="cambiar_estado" class="btn btn-estado">Actualizar</button>
                        </form>
                        <?php echo $pedido['Acciones']; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
