<!-- crearProducto.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto</title>
    <link rel="stylesheet" href="css/Home.css"> <!-- Enlace a los estilos -->
</head>
<body>
    <div class="product-form">
        <h2>Agregar Nuevo Producto</h2>
        <form action="/VitalMarket/CONTROLL/productos-control.php" method="POST">
            <label for="nombre">Nombre del Producto</label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre del Producto" required>

            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" placeholder="Descripción del Producto"></textarea>

            <label for="precio">Precio</label>
            <input type="number" step="0.01" id="precio" name="precio" placeholder="Precio" required>

            <label for="stock">Cantidad en Stock</label>
            <input type="number" id="stock" name="stock" placeholder="Cantidad en Stock" required>

            <label for="categoria">Categoría</label>
            <input type="text" id="categoria" name="categoria" placeholder="Categoría del Producto">

            <button type="submit" name="agregar_producto">Agregar Producto</button>
        </form>
    </div>
</body>
</html>
