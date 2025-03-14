<!DOCTYPE html>
<html lang="es">
<?php 
include 'auth.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del País</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: rgb(137, 255, 235);
        }
        .navbar .nav-link {
            color: rgb(0, 0, 0);
            margin-right: 15px;
        }
        .navbar .nav-link:hover {
            color: rgb(255, 252, 215);
        }
        .navbar .navbar-brand {
            font-weight: bold;
            color: rgb(0, 0, 0);
        }
        .navbar .navbar-brand:hover {
            color: rgb(255, 252, 215);
        }
        .margen {
            margin-top: 60px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Países en Conflicto</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/listaPaises/1">Países</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/listaDistribuciones/1">Distribuciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/listaProductos/1">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/listaReportes/1">Reportes</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="margen text-center">Detalles del País</h1>

        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td><?= $pais['id_pais'] ?></td>
            </tr>
            <tr>
                <th>Nombre</th>
                <td><?= htmlspecialchars($pais['nombre_pais']) ?></td>
            </tr>
            <tr>
                <th>Región</th>
                <td><?= htmlspecialchars($pais['region']) ?></td>
            </tr>
            <tr>
                <th>Estado de Conflicto</th>
                <td>
                    <?= $pais['estado_conflicto'] ? '<span class="text-danger">En Conflicto</span>' : '<span class="text-success">Estable</span>'; ?>
                </td>
            </tr>
        </table>

        <h2 class="mt-4">Distribuciones de Ayuda Humanitaria</h2>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID Distribución</th>
                    <th>Fecha</th>
                    <th>Cantidad Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <h2 class="text-center"><?= htmlspecialchars($pais['nombre_pais']) ?></h2>

<div class="text-center mt-3">
            <h5>Imagen del País</h5>
            <?php 
            $imagenPath = '/PracticaBasesDeDatos/public/img/paises/' . ($pais['imagen'] ?? 'default.jpg');
            ?>
            <img src="<?= 'public/img/paises/' . htmlspecialchars($pais['imagen'] ?? 'default.jpg') ?>"
                 alt="Imagen de <?= htmlspecialchars($pais['nombre_pais']) ?>" 
                 class="img-thumbnail border border-dark"
                 style="max-width: 400px; border-radius: 10px;">
        </div>

            <tbody>
                <?php if (!empty($distribuciones)) : ?>
                    <?php foreach ($distribuciones as $distribucion) : ?>
                        <tr>
                            <td><?= $distribucion['id_distribucion'] ?></td>
                            <td><?= $distribucion['fecha_distribucion'] ?></td>
                            <td><?= $distribucion['cantidad_total'] ?></td>
                            <td>
                                <a href="/distribuciones/<?= $distribucion['id_distribucion'] ?>" class="btn btn-info btn-sm">Ver Detalle</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" class="text-center">No hay distribuciones registradas para este país.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        
        <a href="/listaPaises/1" class="btn btn-secondary">Volver al listado</a>
    </div>
</body>
</html>
