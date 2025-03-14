<?php

namespace App\utils;

use PDO;
use PDOException;


class Utils
{

    static function getConnection()
    {
        //Conexion a la BD

        
        //Cargamos las variables del fichero .env
        $dsn=$_ENV['DSN'];
        $user=$_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];

        try {

            $con = new PDO($dsn, $user, $password);

            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            //Si ha habido un fallo al conectarse a BD
            //Salta una excepcion, con getMEssage sacamos la descripcion del error
            echo 'Falló la conexión: ' . $e->getMessage();
        }

        return $con;
    }

    static function obtenerTipoParametro($variable)
    {
        // Obtener el tipo de la variable
        $tipo = gettype($variable);

        // Mapear el tipo de PHP al tipo de PDO
        switch ($tipo) {
            case 'boolean':
                return PDO::PARAM_BOOL;
            case 'integer':
                return PDO::PARAM_INT;
            case 'double': // 'double' es el tipo que PHP usa para números flotantes
            case 'float':
                return PDO::PARAM_STR; // Se maneja como un string
            case 'string':
                return PDO::PARAM_STR;
            case 'array':
            case 'object':
                return PDO::PARAM_STR; // PDO no soporta array u object como tipos directos
            case 'NULL':
                return PDO::PARAM_NULL;
            default:
                return PDO::PARAM_STR; // Tipo por defecto en caso de tipo desconocido
        }
    }

    static function render($view, $data = [])
    {
        //Extract recibe un array asociativo con nombres de variables como las clasves y sus valores y sus valores
        extract($data);
        require_once  "./view/$view.php";
    }

    static function redirect($url)
    {
        header("Location: $url");
        exit();
    }
}
?>