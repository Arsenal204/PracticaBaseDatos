<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Distribución</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Detalles de la Distribución</h1>

        <table class="table table-bordered mt-4">
            <tr>
                <th>ID Distribución</th>
                <td><?= htmlspecialchars($distribucion['id_distribucion']) ?></td>
            </tr>
            <tr>
                <th>País</th>
                <td><?= htmlspecialchars($distribucion['Pais_id_pais']) ?></td>
            </tr>
            <tr>
                <th>Fecha de Distribución</th>
                <td><?= htmlspecialchars($distribucion['fecha_distribucion']) ?></td>
            </tr>
            <tr>
                <th>Cantidad Total</th>
                <td><?= htmlspecialchars($distribucion['cantidad_total']) ?></td>
            </tr>
            <tr>
                <th>Estado</th>
                <td><?= htmlspecialchars($distribucion['estado']) ?></td>
            </tr>
        </table>

        <h3 class="mt-4">Productos Distribuidos</h3>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Unidad de Medida</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($detalles)): ?>
                    <?php foreach ($detalles as $detalle): ?>
                        <tr>
                            <td><?= htmlspecialchars($detalle['Productos_id_producto']) ?></td>
                            <td><?= htmlspecialchars($detalle['cantidad']) ?></td>
                            <td><?= htmlspecialchars($detalle['unidad_medida']) ?></td>
                            <td><?= htmlspecialchars($detalle['observaciones']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No hay productos en esta distribución.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="/listaDistribuciones/1" class="btn btn-secondary">Volver al listado</a>
    </div>
</body>
</html>
