<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Detalles del Producto</h1>

        <table class="table table-bordered mt-4">
            <tr>
                <th>ID</th>
                <td><?= htmlspecialchars($producto['id_producto']) ?></td>
            </tr>
            <tr>
                <th>Nombre</th>
                <td><?= htmlspecialchars($producto['nombre_producto']) ?></td>
            </tr>
            <tr>
                <th>Tipo</th>
                <td><?= htmlspecialchars($producto['tipo']) ?></td>
            </tr>
            <tr>
                <th>Stock</th>
                <td><?= htmlspecialchars($producto['stock']) ?></td>
            </tr>
            <tr>
                <th>Fecha de Caducidad</th>
                <td><?= htmlspecialchars($producto['fecha_caducidad']) ?></td>
            </tr>
        </table>

        <a href="/productos" class="btn btn-secondary">Volver al listado</a>
    </div>
</body>
</html>
