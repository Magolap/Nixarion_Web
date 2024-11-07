<?php
session_start();
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "Tu carrito está vacío. <a href='index.php'>Volver a la tienda</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Pedido - NIXARION</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Información de Envío y Pago</h2>
        <form action="confirmar_pedido.php" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre Completo</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección de Envío</label>
                <input type="text" name="direccion" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="metodo_pago" class="form-label">Método de Pago</label>
                <select name="metodo_pago" class="form-select" required>
                    <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                    <option value="transferencia">Transferencia Bancaria</option>
                    <option value="efectivo">Pago Contra Entrega</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success w-100">Confirmar Pedido</button>
        </form>
    </div>
</body>
</html>
