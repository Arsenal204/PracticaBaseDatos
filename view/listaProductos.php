<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
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
        <h1 class="text-center">Lista de Productos</h1>
        <a href="/productos/crear" class="btn btn-success mb-3">Agregar Nuevo Producto</a>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Stock</th>
                    <th>Fecha de Caducidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?= htmlspecialchars($producto['id_producto']) ?></td>
                        <td><?= htmlspecialchars($producto['nombre_producto']) ?></td>
                        <td><?= htmlspecialchars($producto['tipo']) ?></td>
                        <td><?= htmlspecialchars($producto['stock']) ?></td>
                        <td><?= htmlspecialchars($producto['fecha_caducidad']) ?></td>
                        <td>
                            <a href="/productos/<?= $producto['id_producto'] ?>" class="btn btn-info btn-sm">Ver</a>
                            <a href="/productos/<?= $producto['id_producto'] ?>/modificar" class="btn btn-warning btn-sm">Editar</a>
                            <a href="/productos/<?= $producto['id_producto'] ?>/eliminar" class="btn btn-danger btn-sm"
                               onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php 
        if($pagina > 1){
            echo "<a href='/productos/".($pagina-1)."' class='btn btn-dark btn-sm'>Anterior</a>";
        }

        for($i = 1; $i <= $totalPaginas; $i++){
            if($i == $pagina){
                echo "<a href='/productos/$i' class='btn btn-success btn-sm'>$i</a>";
            } else {
                echo "<a href='/productos/$i' class='btn btn-link btn-sm'>$i</a>";
            }
        }
        
        if($pagina < $totalPaginas){
            echo "<a href='/productos/".($pagina+1)."' class='btn btn-dark btn-sm'>Siguiente</a>";
        }
        ?>
    </div>
</body>
</html>
