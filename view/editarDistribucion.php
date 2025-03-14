<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Distribución</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Editar Distribución</h1>

        <!-- Formulario para editar la distribución -->
        <form action="/distribuciones/<?= $distribucion['id_distribucion'] ?>/modificar" method="POST">
            <input type="hidden" name="id_distribucion" value="<?= $distribucion['id_distribucion'] ?>">

            <div class="mb-3">
                <label for="Pais_id_pais" class="form-label">País de Destino:</label>
                <select name="Pais_id_pais" id="Pais_id_pais" class="form-control" required>
                    <?php foreach ($paises as $pais): ?>
                        <option value="<?= $pais['id_pais'] ?>" <?= ($pais['id_pais'] == $distribucion['Pais_id_pais']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($pais['nombre_pais']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="fecha_distribucion" class="form-label">Fecha de Distribución:</label>
                <input type="date" name="fecha_distribucion" id="fecha_distribucion" class="form-control" value="<?= $distribucion['fecha_distribucion'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="cantidad_total" class="form-label">Cantidad Total:</label>
                <input type="number" name="cantidad_total" id="cantidad_total" class="form-control" value="<?= $distribucion['cantidad_total'] ?>" min="1" required>
            </div>

            <h4>Productos en la Distribución:</h4>

            <?php foreach ($detalles as $index => $detalle): ?>
                <div class="row mb-2">
                    <input type="hidden" name="detalles[<?= $index ?>][id_detalle]" value="<?= $detalle['Distribuciones_id_distribucion'] ?>">
                    
                    <div class="col-md-3">
                        <select name="detalles[<?= $index ?>][Productos_id_producto]" class="form-control" required>
                            <option value="">Selecciona un producto</option>
                            <?php foreach ($productos as $producto): ?>
                                <option value="<?= $producto['id_producto'] ?>" <?= ($producto['id_producto'] == $detalle['Productos_id_producto']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($producto['nombre_producto']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <input type="number" name="detalles[<?= $index ?>][cantidad]" class="form-control" value="<?= $detalle['cantidad'] ?>" min="1" required>
                    </div>

                    <div class="col-md-3">
                        <input type="text" name="detalles[<?= $index ?>][unidad_medida]" class="form-control" value="<?= $detalle['unidad_medida'] ?>" required>
                    </div>

                    <div class="col-md-4">
                        <input type="text" name="detalles[<?= $index ?>][observaciones]" class="form-control" value="<?= $detalle['observaciones'] ?>">
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="/listaDistribuciones/1" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
