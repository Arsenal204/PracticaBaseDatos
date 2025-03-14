<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Distribuciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <a class="nav-link" href="/listaDistribuciones/1">Distribuciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/listaProductos/1">Productos</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h1 class="text-center">Lista de Distribuciones</h1>
        
        <a href="/distribuciones/crear" class="btn btn-success mb-3">Agregar Nueva Distribución</a>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID Distribución</th>
                    <th>País</th>
                    <th>Fecha de Distribución</th>
                    <th>Cantidad Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($distribuciones)): ?>
                    <?php foreach ($distribuciones as $distribucion): ?>
                        <tr>
                            <td><?= $distribucion['id_distribucion'] ?></td>
                            <td><?= htmlspecialchars($distribucion['Pais_id_pais']) ?></td>
                            <td><?= htmlspecialchars($distribucion['fecha_distribucion']) ?></td>
                            <td><?= htmlspecialchars($distribucion['cantidad_total']) ?></td>
                            <td><?= htmlspecialchars($distribucion['estado']) ?></td>
                            <td>
                                <a href="/distribuciones/<?= $distribucion['id_distribucion'] ?>" class="btn btn-info btn-sm">Ver</a>
                                <a href="/distribuciones/<?= $distribucion['id_distribucion'] ?>/modificar" class="btn btn-warning btn-sm">Editar</a>
                                <a href="/distribuciones/<?= $distribucion['id_distribucion'] ?>/eliminar" class="btn btn-danger btn-sm"
                                   onclick="return confirm('¿Estás seguro de que deseas eliminar esta distribución?');">
                                   Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No hay distribuciones registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="text-center mt-3">
            <?php if ($pagina > 1): ?>
                <a href="/listaDistribuciones/<?= $pagina - 1 ?>" class="btn btn-dark btn-sm">Anterior</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <?php if ($i == $pagina): ?>
                    <a href="/listaDistribuciones/<?= $i ?>" class="btn btn-success btn-sm"><?= $i ?></a>
                <?php else: ?>
                    <a href="/listaDistribuciones/<?= $i ?>" class="btn btn-link btn-sm"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($pagina < $totalPaginas): ?>
                <a href="/listaDistribuciones/<?= $pagina + 1 ?>" class="btn btn-dark btn-sm">Siguiente</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
