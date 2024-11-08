<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

$productos = obtenerProductos($pdo);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - NIXARION</title>
    <link rel="stylesheet" href="../assets/css/styles.css"> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        .rating-stars {
            color: #FFD700; 
        }
        .carousel-inner img {
            width: 100%;
            height: 100%;
            max-height: 700px; 
        }
        
body {
    background-color: #eae7ec; 
}


.search-bar {
    display: flex;
    align-items: center;
    width: 100%; 
    max-width: 400px;
    background-color: #f5f5f5;
    border-radius: 50px;
    padding: 10px 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 20px auto;
}

.search-bar input {
    flex: 1;
    border: none;
    outline: none;
    font-size: 18px;
    padding: 10px;
    border-radius: 50px;
    background-color: transparent;
}

.search-bar button {
    border: none;
    background-color: #4B0082; 
    border-radius: 50%;
    padding: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.search-bar button i {
    color: white;
    font-size: 20px;
}

.search-bar button:hover {
    background-color: #6A0DAD;
}


.container {
    max-width: 1200px;
    margin-top: 40px;
}


.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%; 
    display: flex;
    flex-direction: column;
}

.card:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.card img {
    width: 100%;
    height: 250px; 
    object-fit: cover;
    border-bottom: 1px solid #ddd;
}

.card-title {
    font-size: 1.2em;
    color: #333;
    font-weight: bold;
    margin-top: 10px;
}

.card-text {
    font-size: 0.9em;
    color: #666;
}

.card-text strong {
    color: #4B0082; 
}


.btn-primary {
    background-color: #6a0dad;
    border-color: #6a0dad;
    width: 100%;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #4B0082;
    border-color: #4B0082;
}


footer {
    text-align: center;
    padding: 20px;
    background-color: #6a0dad;
    color: #fff;
    margin-top: 40px;
}


    </style>
</head>
<body>

    <header class="bg-dark text-white text-center p-4">
        <h1>Bienvenido a NIXARION</h1>
        <div class="container d-flex justify-content-between align-items-center">
            <img src="assets/img/logo.jpg" alt="Logotipo NIXARION" style="width: 150px; border-radius: 90px;">
            <form action="search.php" method="GET" class="search-bar d-flex mt-2">
                <input type="text" name="query" placeholder="Buscar..." required class="form-control">
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        <nav>
            <a class="text-white" href="index.php">Inicio</a>
            <a class="text-white" href="productos.php">Productos</a>
            <a class="text-white" href="login.php">Login</a>
            <a href="carrito.php" class="nav-link text-white carrito">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cantidad" id="cart-count">
                                <?= isset($_SESSION['carrito']) ? array_sum(array_column($_SESSION['carrito'], 'cantidad')) : 0; ?>
                            </span>
        </nav>
    </header>

    <main class="container mt-4">
        <h2 class="text-center">Productos Disponibles</h2>

        <div class="row">
            <?php if (count($productos) > 0): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?= $producto['imagen']; ?>" class="card-img-top" alt="<?= $producto['nombre']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $producto['nombre']; ?></h5>
                                <p class="card-text"><?= $producto['descripcion']; ?></p>
                                <p class="card-text"><strong>Precio: <?= number_format($producto['precio'], 2); ?> COP</strong></p>
                                <p class="card-text">Stock: <?= $producto['stock']; ?></p>
                                
                                <form action="agregar_carrito.php" method="POST">
                                    <input type="hidden" name="id" value="<?= $producto['id']; ?>">
                                    <input type="number" name="cantidad" min="1" max="<?= $producto['stock']; ?>" value="1" class="form-control mb-2">
                                    <button type="submit" class="btn btn-primary">Agregar al Carrito</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay productos disponibles.</p>
            <?php endif; ?>
        </div>
    </main>

    <footer class="text-center mt-4">
        <p>© 2024 NIXARION. Todos los derechos reservados.</p>
    </footer>
    
   
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
