<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Administrador</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            height: 100vh;
            background-color: #f4f6f9;
        }
        .dashboard-container {
            display: flex;
            width: 100%;
        }
        .sidebar {
            width: 250px;
            background-color: #8c42c0;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        .sidebar .logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }
        .admin-title {
            display: flex;
            align-items: center;
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .admin-title i {
            margin-right: 8px;
            
        }
        .menu {
            list-style: none;
            width: 100%;
        }
        .menu li {
            width: 100%;
            margin: 10px 0;
        }
        .menu a {
            text-decoration: none;
            color: #fff;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #1A237E;
            border-radius: 8px;
            transition: background-color 0.3s;
        }
        .menu a i {
            margin-right: 10px;
        }
        .menu a:hover {
            background-color: #2563eb;
        }
        .content {
            flex: 1;
            padding: 20px;
            background-color: #f9fafb;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .content h1 {
            color: #1e3a8a;
        }
        .content img {
            max-width: 100%;
            height: auto;
            opacity: 0.5; 
            position: absolute;
        }
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            color: #1e3a8a;
            font-size: 1.5rem;
            cursor: pointer;
        }
        .notification-counter {
            background-color: red;
            color: white;
            font-size: 0.8rem;
            border-radius: 50%;
            padding: 4px 8px;
            position: absolute;
            top: -5px;
            right: -10px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <a href="index.php" class="logo">
                <img src="../assets/img/logo.jpg" alt="Logo NIXARION" style="width: 100px; height: 100px; border-radius:50%;">
            </a>
            <p class="admin-title"><i class="fas fa-user"></i> Administrador</p>
            <ul class="menu">
                <li><a href="usuarios.php"><i class="fas fa-users"></i> Usuarios</a></li>
                <li><a href="productos.php"><i class="fas fa-box"></i> Productos</a></li>
                <li><a href="pedidos.php"><i class="fas fa-shopping-cart"></i> Pedidos</a></li>
                <li><a href="reports/generar_reporte.php"><i class="fas fa-file-alt"></i> Reporte</a></li>
                <li><a href="estadisticas.php"><i class="fas fa-chart-line"></i> Estadística Rápida</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
            </ul>
        </aside>
        <main class="content" id="main-content">
            <div class="notification">
                <i class="fas fa-bell"></i>
                <span id="notification-counter" class="notification-counter">0</span>
            </div>
            <h1>Bienvenido al Panel de Administración</h1>
            <img src="../assets/img/panel.jpg" alt="Administración" />
        </main>
    </div>

    <script>
        function checkNewOrders() {
            fetch('notificaciones.php')
                .then(response => response.json())
                .then(data => {
                    const notificationCounter = document.getElementById('notification-counter');
                    
                    if (data.newOrders > 0) {
                        notificationCounter.style.display = 'inline';
                        notificationCounter.textContent = data.newOrders;
                    } else {
                        notificationCounter.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error al verificar pedidos:', error));
        }

        setInterval(checkNewOrders, 10000);
    </script>
</body>
</html>
