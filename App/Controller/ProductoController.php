<?php
namespace App\Controller;

use App\Utils\Utils;
use App\Model\Producto;

class ProductoController
{
    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function crearProducto()
    {
        Utils::render("crearProducto");
    }

    /**
     * Insertar un nuevo producto en la base de datos.
     */
    public function insertarProducto() {
        $con = Utils::getConnection();
        $productoM = new Producto($con);

        // Validar datos antes de insertar
        if (!isset($_POST['nombre_producto'], $_POST['tipo'], $_POST['stock'], $_POST['fecha_caducidad'])) {
            die("❌ ERROR: Datos de producto incompletos.");
        }

        // Obtener los datos del formulario
        $nombre_producto = $_POST['nombre_producto'];
        $tipo = $_POST['tipo'];
        $stock = $_POST['stock'];
        $fecha_caducidad = $_POST['fecha_caducidad'];

        // Insertar en la base de datos
        $id_producto = $productoM->insertar([
            'nombre_producto' => $nombre_producto,
            'tipo' => $tipo,
            'stock' => $stock,
            'fecha_caducidad' => $fecha_caducidad
        ]);

        if (!$id_producto) {
            die("❌ ERROR: No se pudo insertar el producto.");
        }

        // Redirigir al listado de productos
        Utils::redirect('/productos');
    }

    /**
     * Lista los productos de forma paginada.
     */
    public function listarProductos($datos)
    {
        $con = Utils::getConnection();
        $productoM = new Producto($con);

        $pagina = $datos['pagina'] ?? 1;
        $elementosPorPagina = 10;

        $productos = $productoM->cargarTodoPaginado($pagina, $elementosPorPagina);
        $totalProductos = $productoM->contarTotalRegistros();
        $totalPaginas = ceil($totalProductos / $elementosPorPagina);

        // Enviar datos a la vista
        $datos = compact("productos", "pagina", "totalPaginas");
        Utils::render("listaProductos", $datos);
    }

    /**
     * Muestra el formulario para modificar un producto.
     */
    public function editarProducto($datos)
    {
        $con = Utils::getConnection();
        $productoM = new Producto($con);

        if (!isset($datos['id'])) {
            die("❌ ERROR: ID de producto no proporcionado.");
        }

        $id_producto = $datos['id'];

        $producto = $productoM->cargar($id_producto);
        if (!$producto) {
            die("❌ ERROR: No se encontró el producto con ID: $id_producto");
        }

        // Pasar los datos a la vista
        $datos = compact("producto");
        Utils::render("editarProducto", $datos);
    }

    /**
     * Modifica un producto en la base de datos.
     */
    public function modificarProducto() {
        $con = Utils::getConnection();
        $productoM = new Producto($con);

        // Verificar que se pasaron todos los datos requeridos
        if (!isset($_POST['id_producto'], $_POST['nombre_producto'], $_POST['tipo'], $_POST['stock'], $_POST['fecha_caducidad'])) {
            die("❌ ERROR: Datos incompletos para modificar el producto.");
        }

        $id_producto = $_POST['id_producto'];
        $nombre_producto = $_POST['nombre_producto'];
        $tipo = $_POST['tipo'];
        $stock = $_POST['stock'];
        $fecha_caducidad = $_POST['fecha_caducidad'];

        // Actualizar el producto
        $productoM->modificar([
            'id_producto' => $id_producto,
            'nombre_producto' => $nombre_producto,
            'tipo' => $tipo,
            'stock' => $stock,
            'fecha_caducidad' => $fecha_caducidad
        ]);

        // Redirigir al listado de productos
        Utils::redirect('/productos');
    }

    /**
     * Eliminar un producto.
     */
    public function eliminarProducto($datos) {
        if (!isset($datos['id'])) {
            die("❌ ERROR: ID de producto no proporcionado.");
        }

        $id_producto = $datos['id'];

        $con = Utils::getConnection();
        $productoM = new Producto($con);

        $resultado = $productoM->borrar($id_producto);

        if ($resultado) {
            Utils::redirect('/productos');
        } else {
            die("❌ ERROR: No se pudo eliminar el producto.");
        }
    }

    /**
     * Muestra los detalles de un producto específico.
     */
    public function mostrarProducto($datos) {
        $con = Utils::getConnection();
        $productoM = new Producto($con);

        if (!isset($datos['id'])) {
            die("❌ ERROR: ID de producto no proporcionado.");
        }

        $id_producto = $datos['id'];

        $producto = $productoM->cargar($id_producto);
        if (!$producto) {
            die("❌ ERROR: No se encontró el producto con ID: $id_producto");
        }

        $datos = compact("producto");
        Utils::render("verProducto", $datos);
    }
}
