<?php 
namespace App\Controller;

use App\Utils\Utils;
use App\Model\Pais;
use App\Model\Distribucion;

class PaisController
{
    public function listarPaises($datos)
    {
        // Nos conectamos a la BD
        $con = Utils::getConnection();
        // Creamos el modelo
        $paisM = new Pais($con);
        // Cargamos los países
        $paises = $paisM->cargarTodoPaginado($datos['pagina'], 10);
        
        $contarPaises = $paisM->contarTotalRegistros();
        $pagina = $datos['pagina'];
        $totalPaginas = ceil($contarPaises / 10);

        // Compactamos los datos que necesita la vista para luego pasárselos
        $datos = compact("paises", "pagina", "totalPaginas");
        
        // Cargamos la vista
        Utils::render('listaPaises', $datos);
    }

    public function mostrarPais($datos)
{
    $con = Utils::getConnection();
    $paisM = new Pais($con);
    $distribucionM = new Distribucion($con);

    // Verificar si 'id' está definido en la petición
    $id_pais = $datos['id'] ?? null;

    if (!$id_pais) {
        error_log(" ERROR: 'id' no está definido en la petición.");
        die(" ERROR: ID de país no proporcionado.");
    }

    // Cargar información del país
    $pais = $paisM->cargar($id_pais);

    if (!$pais) {
        die(" ERROR: País no encontrado en la base de datos.");
    }

    // Cargar distribuciones del país con la clave foránea corregida
    $distribuciones = $distribucionM->cargarPorPais($id_pais);

    // Pasar datos a la vista
    Utils::render("verPais", compact("pais", "distribuciones"));
}

public function eliminarPais($datos) {
    // Verificar si el ID del país fue proporcionado
    if (!isset($datos['id'])) {
        die(" ERROR: ID de país no proporcionado.");
    }

    $id_pais = $datos['id'];

    // Conectar con la base de datos
    $con = Utils::getConnection();
    $paisM = new Pais($con);

    // Intentar borrar el país
    $resultado = $paisM->borrar($id_pais);

    if ($resultado) {
        // Redirigir a la lista de países
        Utils::redirect('/listaPaises/1');
    } else {
        die(" ERROR: No se pudo eliminar el país.");
    }
}


    public function crearPais()
    {
        Utils::render('crearPais');
    }

    public function insertarPais()
    {
        // Guardo los datos del formulario de creación de países 
        $pais = $_POST;

        // Nos conectamos a la BD
        $con = Utils::getConnection();
        // Creamos el modelo
        $paisM = new Pais($con);
        // Insertamos el país
        $paisM->insertar($pais);

        // Redirigimos al listado de países
        Utils::redirect('/listaPaises/1');
    }

    public function editarPais($datos)
    {
        // Nos conectamos a la BD
        $con = Utils::getConnection();
        // Creamos el modelo
        $paisM = new Pais($con);
        // Cargamos los datos del país
        $pais = $paisM->cargar($datos['id']);

        // Compactamos los datos que necesita la vista
        $datos = compact("pais");

        // Cargamos la vista de edición
        Utils::render('editarPais', $datos);
    }

    public function modificarPais($datos)
{
    $con = Utils::getConnection();
    $paisM = new Pais($con);

    // Obtener los datos enviados por el formulario
    $id_pais = $datos['id'] ?? null;
    $nombre_pais = $_POST['nombre_pais'] ?? null;
    $region = $_POST['region'] ?? null;
    $estado_conflicto = $_POST['estado_conflicto'] ?? null;
    $imagen_actual = $_POST['imagen_actual'] ?? 'default.jpg';

    if (!$id_pais || !$nombre_pais || !$region || !isset($estado_conflicto)) {
        die("❌ ERROR: Faltan datos obligatorios.");
    }

    // Manejo de la imagen
    if (!empty($_FILES['imagen']['name'])) {
        $directorioDestino = __DIR__ . "/../../public/img/paises/";
        $nombreArchivo = basename($_FILES["imagen"]["name"]);
        $rutaArchivo = $directorioDestino . $nombreArchivo;

        // Mover el archivo al directorio de imágenes
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaArchivo)) {
            $imagen = $nombreArchivo;
        } else {
            die("❌ ERROR: No se pudo subir la imagen.");
        }
    } else {
        $imagen = $imagen_actual;
    }

    // Crear el array con los datos para actualizar
    $datosPais = [
        "id_pais" => $id_pais,
        "nombre_pais" => $nombre_pais,
        "region" => $region,
        "estado_conflicto" => $estado_conflicto,
        "imagen" => $imagen
    ];

    // Intentar actualizar el país
    $resultado = $paisM->modificar($datosPais);

    if (!$resultado) {
        die("❌ ERROR: No se pudo actualizar el país.");
    }

    // Redirigir al detalle del país
    Utils::redirect("/paises/$id_pais");
}

    }


?>
