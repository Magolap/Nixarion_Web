<?php
session_start();
include('../includes/config.php');

$query = $_GET['query'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de búsqueda</title>
    <link rel="stylesheet" href="../assets/css/styles.css"> <!-- Vincula tu archivo CSS principal -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .logo {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        header {
            padding: 15px 0;
            background-color: #343a40;
        }
        .search-bar input {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }
        .search-bar button {
            border: none;
            background-color: #4B0082; /* Morado */
            border-radius: 50%;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            color: white;
            font-size: 30px;
        }
        .product {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin: 15px 0;
            display: flex;
            gap: 15px;
        }
        .product img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
        }
        .product-details {
            flex-grow: 1;
        }
        .product h3 {
            margin: 0 0 10px;
            font-size: 1.2em;
        }
        .product p {
            margin: 5px 0;
        }
        .product-price {
            font-weight: bold;
            color: #2e7d32;
        }
        .product-sales, .product-stock {
            color: #757575;
            font-size: 0.9em;
        }
        .add-to-cart {
            background-color: #4B0082; /* Morado */
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .add-to-cart:hover {
            background-color: #6A0DAD;
        }
        /* Estilos para la notificación */
        #notification {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4B0082;
            color: white;
            padding: 10px;
            border-radius: 5px;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <header class="bg-dark text-white">
        <div class="container d-flex justify-content-between align-items-center">
            <img src="assets/img/logo.jpg" alt="Logo NIXARION" class="logo">
            <form action="search.php" method="GET" class="search-bar d-flex">
                <input type="text" name="query" placeholder="Buscar..." required class="form-control">
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <nav>
                <ul class="nav">
                    <li class="nav-item"><a href="index.php" class="nav-link text-white">Inicio</a></li>
                    <li class="nav-item"><a href="login.php" class="nav-link text-white">Login</a></li>
                    <li class="nav-item">
                        <a href="carrito.php" class="nav-link text-white carrito">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cantidad" id="cart-count">
                                <?= isset($_SESSION['carrito']) ? array_sum(array_column($_SESSION['carrito'], 'cantidad')) : 0; ?>
                            </span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container mt-5">
        <?php
        if (empty($query)) {
            echo "<h1>Por favor ingresa un término de búsqueda.</h1>";
            exit;
        }
        
        echo "<h1>Buscaste: " . htmlspecialchars($query) . "</h1>";

        
        $sql = "SELECT * FROM productos WHERE nombre LIKE ? OR descripcion LIKE ?";
        $stmt = $pdo->prepare($sql); 
        $searchTerm = '%' . $query . '%';
        $stmt->execute([$searchTerm, $searchTerm]); 

       
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<div class='search-results'>";
        if (count($result) > 0) {
            echo "<h2>Resultados para: " . htmlspecialchars($query) . "</h2>";
            foreach ($result as $producto) {
                echo "<div class='product'>";
                if (!empty($producto['imagen'])) {
                    echo "<img src='" . htmlspecialchars($producto['imagen']) . "' alt='" . htmlspecialchars($producto['nombre']) . "'>";
                }
                echo "<div class='product-details'>";
                echo "<h3>" . htmlspecialchars($producto['nombre']) . "</h3>";
                echo "<p>" . htmlspecialchars($producto['descripcion']) . "</p>";
                echo "<p class='product-price'>Precio: " . number_format($producto['precio'], 2) . " COP</p>";
                echo "<form method='post' action='agregar_carrito.php' class='add-to-cart-form'>";
                echo "<input type='hidden' name='id_producto' value='" . $producto['id'] . "'>";
                echo "<input type='hidden' name='cantidad' value='1'>"; 
                echo "<button type='submit' class='add-to-cart btn btn-primary'><i class='fas fa-shopping-cart'></i> Añadir al carrito</button>";
                echo "</form>";
                echo "</div>"; 
                echo "</div>"; 
            }
        } else {
            echo "<h2>No se encontraron resultados para: " . htmlspecialchars($query) . "</h2>";
        }
        echo "</div>"; 
        ?>
    </div> <

   
    <div id="notification">Producto añadido al carrito con éxito.</div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const form = this.closest('.add-to-cart-form');
                const formData = new FormData(form);
                fetch('agregar_carrito.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const cartCount = document.getElementById('cart-count');
                        cartCount.textContent = data.cartCount; 
                        
                       
                    } else {
                        alert('Hubo un problema al añadir el producto al carrito.');
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });
    </script>
</body>
</html>
