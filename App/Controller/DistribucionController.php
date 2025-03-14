<?php
namespace App\Controller;

use App\Utils\Utils;
use App\Model\Distribucion;
use App\Model\DetallesDistribucion;  
use App\Model\Pais;
use App\Model\Producto;

class DistribucionController
{
    public function crearDistribucion()
    {
        $con = Utils::getConnection();
        $paisM = new Pais($con);
        $productoM = new Producto($con);

        // Obtener la lista de países y productos disponibles
        $paises = $paisM->cargarTodoPaginado(1, 100);
        $productos = $productoM->cargarTodoPaginado(1, 100);

        // Enviar los datos a la vista
        $datos = compact("paises", "productos");
        Utils::render("crearDistribucion", $datos);
    }
    
    /**
     * Mostrar todas las distribuciones de forma paginada.
     */
    public function listarDistribuciones($datos)
    {
        $con = Utils::getConnection();
        $distribucionM = new Distribucion($con);

        // Número de página recibido de la URL
        $pagina = $datos['pagina'] ?? 1;
        $elementosPorPagina = 10;

        // Obtener todas las distribuciones con paginación
        $distribuciones = $distribucionM->cargarTodoPaginado($pagina, $elementosPorPagina);
        $totalDistribuciones = $distribucionM->contarTotalRegistros();
        $totalPaginas = ceil($totalDistribuciones / $elementosPorPagina);

        // Enviar datos a la vista
        $datos = compact("distribuciones", "pagina", "totalPaginas");
        Utils::render("listaDistribuciones", $datos);
    }

    /**
     * Mostrar los detalles de una distribución específica.
     */
    public function modificarDistribucion($datos) {
        $con = Utils::getConnection();
        $distribucionM = new Distribucion($con);
        $detalleM = new DetallesDistribucion($con);
    
        // Validar que todos los datos existen en el formulario
        if (!isset($_POST['id_distribucion'], $_POST['Pais_id_pais'], $_POST['fecha_distribucion'], $_POST['cantidad_total'], $_POST['detalles'])) {
            die(" ERROR: Datos incompletos para modificar la distribución.");
        }
    
        // Datos principales de la distribución
        $id_distribucion = $_POST['id_distribucion'];
        $Pais_id_pais = $_POST['Pais_id_pais'];
        $fecha_distribucion = $_POST['fecha_distribucion'];
        $cantidad_total = $_POST['cantidad_total'];
    
        // Actualizar la distribución
        $distribucionM->modificar([
            'id_distribucion' => $id_distribucion,
            'Pais_id_pais' => $Pais_id_pais,
            'fecha_distribucion' => $fecha_distribucion,
            'cantidad_total' => $cantidad_total
        ]);
    
        // Actualizar los detalles de la distribución
        foreach ($_POST['detalles'] as $detalle) {
            $detalleM->modificar([
                'Distribuciones_id_distribucion' => $id_distribucion,
                'Productos_id_producto' => $detalle['Productos_id_producto'],
                'cantidad' => $detalle['cantidad'],
                'unidad_medida' => $detalle['unidad_medida'],
                'observaciones' => $detalle['observaciones']
            ]);
        }
    
        // Redirigir al listado de distribuciones
        Utils::redirect('/listaDistribuciones/1');
    }
    
    
    

    
    /**
     * Insertar una nueva distribución en la base de datos.
     */
    public function insertarDistribucion() {
        $con = Utils::getConnection();
        $distribucionM = new Distribucion($con);
        $detalleM = new DetallesDistribucion($con);
    
        // Revisar si los datos POST existen antes de usarlos
        if (!isset($_POST['Pais_id_pais']) || !isset($_POST['fecha_distribucion']) || !isset($_POST['cantidad_total'])) {
            die(" ERROR: Datos de distribución incompletos.");
        }
    
        // Recibir datos del formulario
        $Pais_id_pais = $_POST['Pais_id_pais'];
        $fecha_distribucion = $_POST['fecha_distribucion'];
        $cantidad_total = $_POST['cantidad_total'];
        $estado = "Pendiente";
    
        // Insertar la distribución principal
        $id_distribucion = $distribucionM->insertar([
            'Pais_id_pais' => $Pais_id_pais,
            'fecha_distribucion' => $fecha_distribucion,
            'cantidad_total' => $cantidad_total,
            'estado' => $estado
        ]);
    
        if (!$id_distribucion) {
            die(" ERROR: No se pudo insertar la distribución.");
        }
    
        // Validar si los productos fueron enviados correctamente
        if (!isset($_POST['productos']) || !isset($_POST['cantidades']) || !isset($_POST['unidad_medida']) || !isset($_POST['observaciones'])) {
            die(" ERROR: Datos de productos incompletos.");
        }
    
        $productos = $_POST['productos'];
        $cantidades = $_POST['cantidades'];
        $unidad_medida = $_POST['unidad_medida'];
        $observaciones = $_POST['observaciones'];
    
        // Insertar los productos en la tabla `Detalles_Distribucion`
        for ($i = 0; $i < count($productos); $i++) {
            $detalleM->insertar([
                'Distribuciones_id_distribucion' => $id_distribucion,
                'Productos_id_producto' => $productos[$i],
                'cantidad' => $cantidades[$i],
                'unidad_medida' => $unidad_medida[$i],
                'observaciones' => $observaciones[$i]
            ]);
        }
    
        // Redirigir al listado de distribuciones
        Utils::redirect('/listaDistribuciones/1');
    }
    
    

    /**
     * Eliminar una distribución.
     */

     
     public function eliminarDistribucion($datos) {
        // Verificar si el ID de la distribución fue proporcionado
        if (!isset($datos['id'])) {
            die(" ERROR: ID de distribución no proporcionado.");
        }
    
        $id_distribucion = $datos['id'];
    
        // Conectar con la base de datos
        $con = Utils::getConnection();
        $distribucionM = new Distribucion($con);
    
        // Intentar borrar la distribución
        $resultado = $distribucionM->borrar($id_distribucion);
    
        if ($resultado) {
            // Redirigir a la lista de distribuciones
            Utils::redirect('/listaDistribuciones/1');
        } else {
            die(" ERROR: No se pudo eliminar la distribución.");
        }
    }

    public function editarDistribucion($datos) {
        $con = Utils::getConnection();
        $distribucionM = new Distribucion($con);
        $detalleM = new DetallesDistribucion($con);
        $paisM = new Pais($con);
        $productoM = new Producto($con);
    
        // Verificar si 'id' está en los datos de la petición
        if (!isset($datos['id'])) {
            die(" ERROR: ID de distribución no proporcionado.");
        }
    
        $id_distribucion = $datos['id'];
    
        // Obtener la distribución
        $distribucion = $distribucionM->cargar($id_distribucion);
        if (!$distribucion) {
            die(" ERROR: No se encontró la distribución con ID: $id_distribucion");
        }
    
        // Obtener los detalles de la distribución con la clave foránea correcta
        $detalles = $detalleM->cargarTodoDetalle($id_distribucion, 'detalles_distribucion', 'Distribuciones_id_distribucion');
    
        // Obtener la lista de países y productos
        $paises = $paisM->cargarTodoPaginado(1, 200);
        $productos = $productoM->cargarTodoPaginado(1, 200);
    
        // Pasar los datos a la vista
        $datos = compact("distribucion", "detalles", "paises", "productos");
        Utils::render("editarDistribucion", $datos);
    }

    public function mostrarDistribucion($datos) {
        $con = Utils::getConnection();
        $distribucionM = new Distribucion($con);
        $detalleM = new DetallesDistribucion($con);
    
        // Verificar si 'id' está en los datos de la petición
        if (!isset($datos['id'])) {
            die(" ERROR: ID de distribución no proporcionado.");
        }
    
        $id_distribucion = $datos['id'];
    
        // Obtener la distribución
        $distribucion = $distribucionM->cargar($id_distribucion);
        if (!$distribucion) {
            die(" ERROR: No se encontró la distribución con ID: $id_distribucion");
        }
    
        // Obtener los detalles de la distribución con la clave foránea correcta
        $detalles = $detalleM->cargarTodoDetalle($id_distribucion, 'detalles_distribucion', 'Distribuciones_id_distribucion');
    
        // Pasar los datos a la vista
        $datos = compact("distribucion", "detalles");
        Utils::render("verDistribucion", $datos);
    }
    
    
    
    
    
}
?>
