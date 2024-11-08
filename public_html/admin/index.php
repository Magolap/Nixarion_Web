<?php
include('../../includes/config.php');  
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NIXARION - Tienda Online</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="index.php">
                <img src="../assets/img/logo.jpg" alt="Logo NIXARION" class="rounded-circle" style="width: 100px; height: 100px;">
            </a>
            <nav>
                <ul class="nav">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link text-white">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a href="login.php" class="nav-link text-white">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a href="carrito.php" class="nav-link text-white">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="badge bg-secondary" id="cart-count">
                                <?= isset($_SESSION['carrito']) ? array_sum(array_column($_SESSION['carrito'], 'cantidad')) : 0; ?>
                            </span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Bienvenido a NIXARION</h1>

        <div class="row">
            <?php
            $sql = "SELECT * FROM productos";
            $stmt = $pdo->query($sql);  
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($productos as $producto) {
                echo '<div class="col-md-4 mb-4">';
                echo '<div class="card">';
                if (!empty($producto['imagen'])) {
                    echo '<img src="' . htmlspecialchars($producto['imagen']) . '" class="card-img-top" alt="' . htmlspecialchars($producto['nombre']) . '">';
                }
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . htmlspecialchars($producto['nombre']) . '</h5>';
                echo '<p class="card-text">' . htmlspecialchars($producto['descripcion']) . '</p>';
                echo '<p class="card-text">Precio: ' . number_format($producto['precio'], 2) . ' COP</p>';
                echo '<form method="post" action="agregar_carrito.php">';
                echo '<input type="hidden" name="id_producto" value="' . $producto['id'] . '">';
                echo '<button type="submit" class="btn btn-primary w-100">Añadir al carrito</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('form[action="agregar_carrito.php"]').forEach(form => {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    const formData = new FormData(this);

                    fetch('agregar_carrito.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Producto añadido al carrito.');
                            const cartCount = document.getElementById('cart-count');
                            cartCount.textContent = parseInt(cartCount.textContent) + 1;
                        } else {
                            alert('Error al añadir el producto.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
</body>
</html>
