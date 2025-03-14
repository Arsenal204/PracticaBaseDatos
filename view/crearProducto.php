<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Crear Producto</h1>

        <form action="/productos/crear" method="POST">
            <div class="mb-3">
                <label for="nombre_producto" class="form-label">Nombre del Producto:</label>
                <input type="text" name="nombre_producto" id="nombre_producto" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo:</label>
                <input type="text" name="tipo" id="tipo" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock:</label>
                <input type="number" name="stock" id="stock" class="form-control" min="0" required>
            </div>

            <div class="mb-3">
                <label for="fecha_caducidad" class="form-label">Fecha de Caducidad:</label>
                <input type="date" name="fecha_caducidad" id="fecha_caducidad" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Crear Producto</button>
            <a href="/productos" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
