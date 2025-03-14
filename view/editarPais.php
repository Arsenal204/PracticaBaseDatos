<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar País</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Editar País</h1>

        <form action="/paises/<?= $pais['id_pais'] ?>/modificar" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombre_pais" class="form-label">Nombre del País:</label>
                <input type="text" name="nombre_pais" id="nombre_pais" 
                       value="<?= htmlspecialchars($pais['nombre_pais']) ?>" 
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="region" class="form-label">Región:</label>
                <input type="text" name="region" id="region" 
                       value="<?= htmlspecialchars($pais['region']) ?>" 
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="estado_conflicto" class="form-label">Estado de Conflicto:</label>
                <select name="estado_conflicto" id="estado_conflicto" class="form-control">
                    <option value="1" <?= $pais['estado_conflicto'] == 1 ? 'selected' : '' ?>>En conflicto</option>
                    <option value="0" <?= $pais['estado_conflicto'] == 0 ? 'selected' : '' ?>>Sin conflicto</option>
                </select>
            </div>

            <div class="mb-3 text-center">
                <label for="imagen_actual" class="form-label">Imagen Actual:</label><br>
                <img src="/img/paises/<?= htmlspecialchars($pais['imagen'] ?? 'default.jpg') ?>" 
                     alt="Imagen de <?= htmlspecialchars($pais['nombre_pais']) ?>" 
                     class="img-thumbnail border border-dark"
                     style="max-width: 250px; border-radius: 10px;">
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Subir Nueva Imagen:</label>
                <input type="file" name="imagen" id="imagen" class="form-control">
            </div>

            <!-- Campo oculto para mantener la imagen actual si no se sube una nueva -->
            <input type="hidden" name="imagen_actual" value="<?= htmlspecialchars($pais['imagen']) ?>">

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="/paises/<?= $pais['id_pais'] ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
