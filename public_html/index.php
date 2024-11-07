<?php
include '../includes/config.php';
include '../includes/functions.php';
$productos = obtenerProductos($pdo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos disponibles - NIXARION</title>
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    

    </style>
</head>
<body>
    <header class="bg-dark text-white">
        <div class="container d-flex justify-content-between align-items-center">
        <img src="assets/img/logo.jpg" alt="Logotipo NIXARION" style="width: 150px; border-radius: 90px; float: left; margin-right: 10px;">
            <form action="search.php" method="GET" class="search-bar d-flex mt-2">
                <input type="text" name="query" placeholder="Buscar..." required class="form-control">
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
          
            <nav class="navbar navbar-expand-lg">
    <div class="container">
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="index.php" class="nav-link">Inicio</a></li>
                <li class="nav-item"><a href="login.php" class="nav-link">Iniciar sesión</a></li>
                <li class="nav-item"><a href="productos.php" class="nav-link">Productos</a></li>
                <li class="nav-item">
                    <a href="carrito.php" class="nav-link position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        <span id="cart-count" class="cart-count-badge"><?= isset($_SESSION['carrito']) ? array_sum(array_column($_SESSION['carrito'], 'cantidad')) : 0; ?></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

        </div>
    </header>

    <!-- Slider -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
            <img src="assets/img/slider 5.png"style="width: 150px;" class="d-block w-100" alt="Oferta 1">
                <div class="carousel-caption d-none d-md-block">
                   
                </div>
            </div>
            <div class="carousel-item">
            <img src="assets/img/envio.png"style="width: 150px;" class="d-block w-100" alt="Producto Nuevo">
                <div class="carousel-caption d-none d-md-block">
                   
                </div>
            </div>
            <div class="carousel-item">
            <img src="assets/img/slider 3.png"style="width: 150px;" class="d-block w-100" alt="Producto Nuevo">
                <div class="carousel-caption d-none d-md-block">
                    
                </div>
            </div>
            <div class="carousel-item">
            <img src="assets/img/slider 4.png"style="width: 150px;" class="d-block w-100" alt="Descuento Especial">
                <div class="carousel-caption d-none d-md-block">
                   
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    

    <div class="container my-4">
    <div class="row text-center">
        <div class="col-md-3">
            <div class="icon-box bg-light-brown text-dark-brown d-inline-flex justify-content-center align-items-center mb-2">
                <i class="fas fa-plane fa-2x"></i>
            </div>
            <h6>Envío gratuito a nivel nacional</h6>
            <p>En pedidos superiores a $25000</p>
        </div>
        <div class="col-md-3">
            <div class="icon-box bg-light-brown text-dark-brown d-inline-flex justify-content-center align-items-center mb-2">
                <i class="fas fa-wallet fa-2x"></i>
            </div>
            <h6>Contrareembolso</h6>
            <p>100% garantía de devolución de dinero</p>
        </div>
        <div class="col-md-3">
            <div class="icon-box bg-light-brown text-dark-brown d-inline-flex justify-content-center align-items-center mb-2">
                <i class="fas fa-gift fa-2x"></i>
            </div>
            <h6>Tarjeta regalo especial</h6>
            <p>Ofrece bonos especiales con regalo</p>
        </div>
        <div class="col-md-3">
            <div class="icon-box bg-light-brown text-dark-brown d-inline-flex justify-content-center align-items-center mb-2">
                <i class="fas fa-headset fa-2x"></i>
            </div>
            <h6>Servicio al cliente 24/7</h6>
    
        </div>
    </div>
</div>

    <main class="container my-5">
    <h2 class="text-center mb-4">Productos Disponibles</h2>
<div class="row g-3"> 
    <?php if ($productos): ?>
        <?php foreach ($productos as $producto): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <!-- Imagen del producto -->
                    <img src="<?= htmlspecialchars($producto['imagen']); ?>" class="card-img-top" alt="<?= htmlspecialchars($producto['nombre']); ?>">
                    
                    <div class="card-body">
                        <!-- Título del producto -->
                        <h5 class="card-title"><?= htmlspecialchars($producto['nombre']); ?></h5>
                        
                        <!-- Descripción del producto -->
                        <p class="card-text"><?= htmlspecialchars($producto['descripcion']); ?></p> 
                        
                        <!-- Precio del producto -->
                        <p class="card-text">Precio: $<?= number_format($producto['precio'], 2); ?> COP</p>
                        
                        <!-- Calificación en estrellas -->
                        <div class="rating-stars mb-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i> <!-- Ejemplo de 4 estrellas -->
                        </div>
                        
                        <!-- Formulario para agregar al carrito -->
                        <form method="post" action="agregar_carrito.php" class="add-to-cart-form">
                            <input type="hidden" name="id_producto" value="<?= $producto['id']; ?>">
                            
                            <div class="d-flex align-items-center">
                                <!-- Campo de cantidad -->
                                <input type="number" name="cantidad" value="1" min="1" max="<?= $producto['stock']; ?>" class="form-control me-2" style="width: 60px;">
                                
                                <!-- Botón de agregar al carrito -->
                                <button type="submit" class="btn btn-primary d-flex align-items-center">
                                    <i class="fas fa-shopping-cart"></i> <!-- Ícono del carrito -->
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center">No hay productos disponibles.</p>
    <?php endif; ?>
</div>
</main>


<footer class="footer">
    <div class="container">
        <div class="row">
            <!-- Sección Sobre Nosotros -->
            <div class="col-md-3">
                <h5>SOBRE NOSOTROS</h5>
                <ul class="footer-links">
                    <li><a href="#">Quiénes Somos</a></li>
                    <li><a href="#">Responsabilidad social</a></li>
                    <li><a href="#">Empleos</a></li>
                    <li><a href="#">Sala de prensa</a></li>
                </ul>
            </div>
            <!-- Sección Ayuda y Apoyo -->
            <div class="col-md-3">
                <h5>AYUDA & APOYO</h5>
                <ul class="footer-links">
                    <li><a href="#">Información De Envío</a></li>
                    <li><a href="#">Devolución</a></li>
                    <li><a href="#">Reembolso</a></li>
                    <li><a href="#">Cómo Realizar El Pedido</a></li>
                    <li><a href="#">Rastrear El Pedido</a></li>
                    <li><a href="#">Guía De Tallas</a></li>
                    
                </ul>
            </div>
            <!-- Sección Servicio al Cliente -->
            <div class="col-md-3">
                <h5>SERVICIO AL CLIENTE</h5>
                <ul class="footer-links">
                    <li><a href="#">Contáctenos</a></li>
                    <li><a href="#">Forma De Pago</a></li>
                    <li><a href="#">Puntos</a></li>
                </ul>
            </div>
            <!-- Sección Redes Sociales y App -->
            <div class="col-md-3 text-center">
                <h5>ENCUÉNTRANOS EN</h5>
                <div class="social-icons">
                    <i class="fab fa-facebook-f"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-youtube"></i>
                    <i class="fab fa-pinterest"></i>
                    <i class="fab fa-snapchat"></i>
                    <i class="fab fa-tiktok"></i>
                </div>
                <h5 class="mt-3">APP</h5>
                <div class="app-icons">
                    <i class="fab fa-apple"></i>
                    <i class="fab fa-android"></i>
                </div>
            </div>
        </div>

        <!-- Suscripción y Medios de Pago -->
        <div class="row mt-4">
            <div class="col-md-6">
                <h5>SUSCRÍBETE PARA RECIBIR OFERTAS EXCLUSIVAS, PROMOCIONES Y NOTICIAS</h5>
                <div class="subscription-form">
                    <input type="email" placeholder="Tu dirección de Email" class="form-control">
                    <button class="btn btn-dark">Suscribir</button>
                </div>
                <div class="subscription-form mt-2">
                    <input type="text" placeholder="Cuenta de WhatsApp" class="form-control">
                    <button class="btn btn-dark">Suscribir</button>
                </div>
            </div>
            <div class="col-md-6 text-center payment-icons">
            <p>Aceptamos</p>
                <i class="fab fa-cc-visa"></i>
                <i class="fab fa-cc-mastercard"></i>
                <i class="fab fa-cc-amex"></i>
                <i class="fab fa-cc-paypal"></i>
                <i class="fab fa-cc-discover"></i>
            </div>
        </div>

        <!-- Derechos reservados -->
        <div class="row mt-4 text-center">
            <div class="col-md-12">
                <p>©2009-2024 NIXARION Todos los derechos reservados</p>
                <div class="footer-legal-links">
                    <a href="#">Centro de Privacidad</a> |
                    <a href="#">Política de privacidad y cookies</a> |
                    <a href="#">Términos y condiciones</a> |
                    <a href="#">Aviso de copyright</a> |
                    <a href="#">Colombia</a>
                </div>
            </div>
        </div>
    </div>
</footer>

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.add-to-cart-form').submit(function(event) {
                event.preventDefault();
                var cantidad = parseInt($(this).find('input[name="cantidad"]').val());
                var currentCount = parseInt($('#cart-count').text()) || 0;
                $.ajax({
                    type: 'POST',
                    url: 'agregar_carrito.php',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#cart-count').text(currentCount + cantidad);
                    },
                    error: function() {
                        alert('Error al agregar el producto al carrito.');
                    }
                });
            });
        });
    </script>
</body>
</html>
