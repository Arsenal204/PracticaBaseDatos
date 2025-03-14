<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Distribución</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Crear Nueva Distribución</h1>
        
        <form action="/distribuciones/insertar" method="POST">
            <div class="mb-3">
                <label for="Pais_id_pais" class="form-label">País de Destino:</label>
                <select name="Pais_id_pais" id="Pais_id_pais" class="form-control" required>
                    <option value="">Selecciona un país</option>
                    <?php foreach ($paises as $pais): ?>
                        <option value="<?= $pais['id_pais'] ?>"><?= htmlspecialchars($pais['nombre_pais']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="fecha_distribucion" class="form-label">Fecha de Distribución:</label>
                <input type="date" name="fecha_distribucion" id="fecha_distribucion" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="cantidad_total" class="form-label">Cantidad Total:</label>
                <input type="number" name="cantidad_total" id="cantidad_total" class="form-control" min="1" required>
            </div>

            <h4>Productos a Enviar:</h4>

            <?php for ($i = 0; $i < 3; $i++): ?>
                <div class="row mb-2">
                    <div class="col-md-3">
                        <select name="productos[]" class="form-control" required>
                            <option value="">Selecciona un producto</option>
                            <?php foreach ($productos as $producto): ?>
                                <option value="<?= $producto['id_producto'] ?>"><?= htmlspecialchars($producto['nombre_producto']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="cantidades[]" class="form-control" placeholder="Cantidad" min="1" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="unidad_medida[]" class="form-control" placeholder="Unidad de Medida" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="observaciones[]" class="form-control" placeholder="Observaciones">
                    </div>
                </div>
            <?php endfor; ?>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">Guardar Distribución</button>
                <a href="/listaDistribuciones/1" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
