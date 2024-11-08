<?php
session_start();

if (isset($_POST['vaciar_carrito'])) {
    unset($_SESSION['carrito']); 
    header("Location: carrito.php"); 
    exit();
}


if (isset($_POST['eliminar_producto'])) {
    $id_producto = $_POST['id_producto'];

    // Elimina el producto del carrito
    if (isset($_SESSION['carrito'][$id_producto])) {
        unset($_SESSION['carrito'][$id_producto]);
    }

    header("Location: carrito.php"); 
    exit();
}


$carrito = $_SESSION['carrito'] ?? [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - NIXARION</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Carrito de Compras</h1>

        <?php if (!empty($carrito)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    <?php foreach ($carrito as $id_producto => $producto): ?>
                        <tr>
                            <td><?= htmlspecialchars($producto['nombre']); ?></td>
                            <td><?= htmlspecialchars($producto['cantidad']); ?></td>
                            <td>$<?= number_format($producto['precio'], 2); ?> COP</td>
                            <td>$<?= number_format($producto['precio'] * $producto['cantidad'], 2); ?> COP</td>
                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="id_producto" value="<?= $id_producto; ?>">
                                    <button type="submit" name="eliminar_producto" class="btn btn-danger btn-sm">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php $total += $producto['precio'] * $producto['cantidad']; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h3 class="text-end">Total: $<?= number_format($total, 2); ?> COP</h3>

            <form method="post">
                <button type="submit" name="vaciar_carrito" class="btn btn-danger w-100 mt-3">
                    Vaciar Carrito
                </button>
            </form>
         
             <form action="realizar_pedido.php" method="POST">
                <button type="submit" class="btn btn-success w-100 mt-2">Realizar Pedido</button>
             </form>
        <?php else: ?>
            <p class="text-center">El carrito está vacío.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
