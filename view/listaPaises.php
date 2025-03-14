<!DOCTYPE html>
<html lang="es">
<?php 
include 'auth.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Países en Conflicto</title>
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
        <h1 class="margen text-center">Lista de Países</h1>
        <a href="/paises/crear" class="btn btn-success mb-3">Agregar Nuevo País</a>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Región</th>
                    <th>Estado de Conflicto</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paises as $pais): ?>
                    <tr>
                        <td><?= $pais['id_pais'] ?></td>
                        <td><?= htmlspecialchars($pais['nombre_pais']) ?></td>
                        <td><?= htmlspecialchars($pais['region']) ?></td>
                        <td>
                            <?= $pais['estado_conflicto'] ? '<span class="text-danger">En Conflicto</span>' : '<span class="text-success">Estable</span>'; ?>
                        </td>
                        <td>
                            <a href="/paises/<?= $pais['id_pais'] ?>" class="btn btn-info btn-sm">Ver</a>
                            <a href="/paises/<?= $pais['id_pais'] ?>/modificar" class="btn btn-warning btn-sm">Editar</a>
                            <a href="/paises/<?= $pais['id_pais'] ?>/eliminar" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este país?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Paginación -->
        <?php 
        if($pagina > 1){
            echo "<a href='/listaPaises/".($pagina-1)."' class='btn btn-dark btn-sm'>Anterior</a>";
        }

        for($i = 1; $i <= $totalPaginas; $i++){
            if($i == $pagina){
                echo "<a href='/listaPaises/$i' class='btn btn-success btn-sm'>$i</a>";
            } else {
                echo "<a href='/listaPaises/$i' class='btn btn-link btn-sm'>$i</a>";
            }
        }
        
        if($pagina < $totalPaginas){
            echo "<a href='/listaPaises/".($pagina+1)."' class='btn btn-dark btn-sm'>Siguiente</a>";
        }
        ?>
    </div>
</body>
</html>
