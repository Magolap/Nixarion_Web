<?php
session_start();
include '../../includes/config.php'; // Asegúrate de que esta ruta sea correcta

// Verificar si el usuario ha iniciado sesión como administrador
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria_id = $_POST['categoria_id'];
    $imagen = $_FILES['imagen']['name'];
    $imagen_tmp = $_FILES['imagen']['tmp_name'];

    if (!empty($imagen)) {
        $ruta_imagen = 'assets/img/' . basename($imagen);
        if (move_uploaded_file($imagen_tmp, '../../public_html/' . $ruta_imagen)) {
            echo "Imagen subida correctamente.";
        } else {
            echo "Error al subir la imagen.";
        }
    } else {
        if ($id) {
            $stmt = $pdo->prepare("SELECT imagen FROM productos WHERE id = ?");
            $stmt->execute([$id]);
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);
            $ruta_imagen = $producto['imagen'];
        } else {
            $ruta_imagen = '';
        }
    }

    if ($id) {
        $query = "UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=?, categoria_id=?, imagen=? WHERE id=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$nombre, $descripcion, $precio, $stock, $categoria_id, $ruta_imagen, $id]);
    } else {
        $query = "INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, imagen) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$nombre, $descripcion, $precio, $stock, $categoria_id, $ruta_imagen]);
    }

    header("Location: productos.php");
    exit();
}

// Eliminar producto
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: productos.php");
    exit();
}

// Obtener todos los productos
$query = $pdo->query("SELECT * FROM productos");
$productos = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f6f9;
    }
    .container {
        max-width: 1000px;
        margin-top: 50px;
    }
    h1 {
        color: #4a4a8e; /* Cambié el color del título a un morado suave */
        text-align: center;
        margin-bottom: 20px;
        font-size: 2em;
    }
    .form-container {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); /* Sombra más suave */
        margin-bottom: 20px;
    }
    .form-group label {
        font-weight: bold;
        color: #4a4a8e; /* Cambié el color del texto */
    }
    .form-control, .form-control-file {
        border-radius: 8px; /* Bordes redondeados para los campos */
        border: 1px solid #d1d3d4; /* Color más claro en el borde */
    }
    .form-control:focus {
        border-color: #4a4a8e;
        box-shadow: 0 0 5px rgba(74, 74, 142, 0.5);
    }
    .btn-primary {
        background-color: #4a4a8e; /* Cambié el color a morado */
        border: none;
        padding: 12px;
        font-weight: bold;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(74, 74, 142, 0.3);
    }
    .btn-primary:hover {
        background-color: #373769; /* Morado más oscuro al pasar el mouse */
    }
    table {
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        overflow: hidden;
    }
    th {
        background-color: #4a4a8e;
        color: white;
        font-weight: bold;
        text-align: center;
    }
    td {
        text-align: center;
        vertical-align: middle;
    }
    .btn-edit {
        background-color: #4a90e2; /* Azul suave */
        color: white;
        border-radius: 8px;
        padding: 6px 12px;
        margin: 2px;
    }
    .btn-delete {
        background-color: #ff6b6b; /* Rojo suave */
        color: white;
        border-radius: 8px;
        padding: 6px 12px;
        margin: 2px;
    }
    .btn-edit:hover {
        background-color: #357ab7;
    }
    .btn-delete:hover {
        background-color: #d9534f;
    }
    img {
        border-radius: 8px;
    }
</style>

</head>
<body>
    <div class="container">
        <h1>Gestión de Productos</h1>

        <div class="form-container">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="producto-id">
                <div class="form-group">
                    <label for="nombre">Nombre del Producto</label>
                    <input type="text" class="form-control" name="nombre" placeholder="Nombre" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" name="descripcion" placeholder="Descripción" required></textarea>
                </div>
                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input type="number" class="form-control" name="precio" placeholder="Precio" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" class="form-control" name="stock" placeholder="Stock" required>
                </div>
                <div class="form-group">
                    <label for="categoria_id">Categoría ID</label>
                    <input type="number" class="form-control" name="categoria_id" placeholder="Categoría ID" required>
                </div>
                <div class="form-group">
                    <label for="imagen">Imagen</label>
                    <input type="file" class="form-control-file" name="imagen" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Guardar</button>
            </form>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?= $producto['id'] ?></td>
                    <td><?= $producto['nombre'] ?></td>
                    <td><?= $producto['descripcion'] ?></td>
                    <td>$<?= number_format($producto['precio'], 2) ?></td>
                    <td><?= $producto['stock'] ?></td>
                    <td><?= $producto['categoria_id'] ?></td>
                    <td><img src="../assets/img/<?= $producto['imagen'] ?>" width="50"></td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-sm btn-edit" onclick="editarProducto(<?= htmlspecialchars(json_encode($producto)) ?>)">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="productos.php?eliminar=<?= $producto['id'] ?>" class="btn btn-sm btn-delete" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        function editarProducto(producto) {
            document.getElementById('producto-id').value = producto.id;
            document.querySelector('input[name="nombre"]').value = producto.nombre;
            document.querySelector('textarea[name="descripcion"]').value = producto.descripcion;
            document.querySelector('input[name="precio"]').value = producto.precio;
            document.querySelector('input[name="stock"]').value = producto.stock;
            document.querySelector('input[name="categoria_id"]').value = producto.categoria_id;
        }
    </script>
</body>
</html>
