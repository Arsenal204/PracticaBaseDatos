<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo País</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Agregar Nuevo País</h1>

        <form action="/paises/crear" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombre_pais" class="form-label">Nombre del País:</label>
                <input type="text" name="nombre_pais" id="nombre_pais" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="region" class="form-label">Región:</label>
                <input type="text" name="region" id="region" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="estado_conflicto" class="form-label">Estado de Conflicto:</label>
                <select name="estado_conflicto" id="estado_conflicto" class="form-control">
                    <option value="1">En conflicto</option>
                    <option value="0">Sin conflicto</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Subir Imagen del País:</label>
                <input type="file" name="imagen" id="imagen" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Crear País</button>
            <a href="/listaPaises/1" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
