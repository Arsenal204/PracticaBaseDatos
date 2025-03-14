<?php 
namespace App\Model;

use PDO;
use PDOException; 
use App\utils\Utils;

class Model
{

    //Conexion que usaremos para todas las acciones
    protected $con;

    protected $table;

    //Todos los entrenadores usan la misma bd
    public static $nombreBD = "paisesnecesitados";

    function __construct($con)
    {
        //asignamos la conexion activa
        if ($con != null && $this->con==null) $this->con = $con;
    }

    /**
     * Funcion para contar el total de registros de una tabla
     * @return int Total de registros
     */
    public function contarTotalRegistros() {
        $sql = "SELECT COUNT(*) as total FROM $this->table";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $resultado['total'];
    }

    /**
     * Funcion para cargar todos los campos de un elemento por su id
     * @param int $id Identificador del elemento
     * @return array Elemento cargado
     */
    function cargar($id)
    {
        try {

            //Query que saca todos los datos por su id
            $sql = "select * from $this->table where id".$this->table." = :id";

            $stmt = $this->con->prepare($sql);

            //Asignamos la forma de devolver los datos
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $resultado = $stmt->execute();

            //Si ha ido bien devolvemos los datos
            if ($resultado) return $stmt->fetch();
        } catch (PDOException $e) {
            echo 'Hubo un problema al consultar el registro: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Funcion para cargar los ids de un elemento
     * @return array Elemento cargado con los ids
     */
    function cargarIds($tabla)
    {
        try {

            //query que saca los ids
            $sql = "select id".$this->table.", id".$tabla." from $this->table";

            $stmt = $this->con->prepare($sql);

            //Asignamos la forma de devolver los datos
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $resultado = $stmt->execute();

            //Si ha ido bien devolvemos los datos
            if ($resultado) return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo 'Hubo un problema al obtener el registro: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Funcion que carga todos los datos de una tabla de forma paginada
     * @param int $num_pag Numero de la pagina
     * @param int $elem_pag Elementos por pagina
     * @return array Elementos cargados con todos los datos de la tabla en esa pagina
     */
    function cargarTodoPaginado($num_pag, $elem_pag)
    {

        try {

            //query que muestra de forma paginada los datos
            $sql = "select * from $this->table limit :elem_pag offset :offset";

            $stmt = $this->con->prepare($sql);

            //Asignamos la forma de devolver los datos
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            //Le asignamos los parametros, calculando el offset
            $stmt->bindParam(':elem_pag', $elem_pag, PDO::PARAM_INT);
            $offset = ($elem_pag * ($num_pag - 1));
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

            $resultado = $stmt->execute();

            //Si ha ido bien devolvemos los datos
            if ($resultado) return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo 'Hubo un problema al obtener los registros: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Funcion que carga todos los datos de una tabla relacionada con la entidad principal
     * @param int $id Identificador de la entidad principal
     * @param string $tabla Tabla relacionada
     * @param string $tabla2 Tabla principal
     * @return array Elementos cargados con todos los datos de la tabla en ese id
     */
    public function cargarTodoDetalle($id, $tabla, $clave_foranea)
{
    try {
        // Corrección: Se usa `Distribuciones_id_distribucion` como clave foránea correcta
        $sql = "SELECT * FROM $tabla WHERE $clave_foranea = :id";

        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log(" ERROR al obtener los registros: " . $e->getMessage());
        return false;
    }
}


    /**
     * Funcion que elimina un elemento por su id
     * @param int $id Identificador del elemento
     * @return bool Devuelve true si ha ido bien y false si ha ido mal
     */
    function borrar($id)
    {

        try {

            //Query que borra el elemento a partir de su id
            $sql = "delete from $this->table where id" . $this->table . " = ?";

            $stmt = $this->con->prepare($sql);

            $resultado = $stmt->execute([$id]);

            //Devolvemos el resultado de la ejecucion de la sentencia
            return $resultado;
        } catch (PDOException $e) {
            echo 'Hubo un problema al eliminar el registro: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Funcion que inserta un elemento en la base de datos
     * @param array $datos Elemento a insertar
     * @return bool Devuelve true si ha ido bien y false si ha ido mal
     */
    function insertar($datos)
    {
        try {

            //Empezamos construyendo la query con la sentencia INSERT INTO
            $sql = "INSERT INTO $this->table (";

            //Sacamos las claves que corresponden con los nombres de los campos
            $campos = array_keys($datos);

            //Primero añadimos los nombres de los campos que vienen como claves en el array asociativo
            for ($i = 0; $i < count($campos); $i++) {
                if ($i < count($campos) - 1)
                    $sql .= "$campos[$i],";
                else
                    $sql .= "$campos[$i]";
            }
            //Concatenamos la mitad de la sentencia
            $sql .= ") VALUES (";
            //Finalmente ponemos los parametros a la query
            for ($i = 0; $i < count($campos); $i++) {
                if ($i < count($campos) - 1)
                    $sql .= ":$campos[$i],";
                else
                    $sql .= ":$campos[$i]";
            }
            //Por ultimo cerramos el parentesis del VALUE
            $sql .= ")";

            $stmt = $this->con->prepare($sql);

            //Sacamos la query que se va a ejecutar para depurar errores
            echo $stmt->queryString;

            

            //Vamos añadiendo los valores uno a uno
            for ($i = 0; $i < count($campos); $i++) {
                //Dependiendo del tipo de dato le pongo el tipo de parametro pdo asociado
                //Usando la funcion obtenertipoparametro
                $tipo = Utils::obtenerTipoParametro($datos[$campos[$i]]);
                $stmt->bindValue(':'.$campos[$i], $datos[$campos[$i]],$tipo);
            }
            $resultado = $stmt->execute($datos);

            //Devolvemos el resultado de la ejecucion de la sentencia
            return $resultado;
        } catch (PDOException $e) {
            echo 'Hubo un problema al insertar el registro: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Funcion que modifica un elemento en la base de datos a partir de su id
     * @param array $datos Elemento a modificar y su id
     * @return bool Devuelve true si ha ido bien y false si ha ido mal
     */
    function modificar($datos)
    {
        try {

            //Empezamos construyendo la query
            $sql = "UPDATE $this->table SET ";

            //Sacamos las claves que corresponden con los nombres de los campos
            $campos = array_keys($datos);

            //Añadimos los nombres de los campos que vienen como claves en el array asociativo y los igualamos a los valores
            for ($i = 0; $i < count($campos) - 1; $i++) {
                if ($i < count($campos) - 2)
                    $sql .= "$campos[$i]=:$campos[$i],";
                else
                    $sql .= "$campos[$i]=:$campos[$i]";
            }

            //Terminamos poniendo la sentencia WHERE
            $sql .= " WHERE id" . $this->table . " =:id";

            $stmt = $this->con->prepare($sql);

            //Sacamos la query que se va a ejecutar para depurar errores
            echo $stmt->queryString;

            //Vamos añadiendo los valores uno a uno
            for ($i = 0; $i < count($campos); $i++) {
                //Dependiendo del tipo de dato le pongo el tipo de parametro pdo asociado
                //Usando la funcion obtenertipoparametro
                $tipo = Utils::obtenerTipoParametro($datos[$campos[$i]]);
                $stmt->bindValue(':'.$campos[$i], $datos[$campos[$i]],$tipo);
            }
            
            $resultado = $stmt->execute($datos);

            //Devolvemos el resultado de la ejecucion de la sentencia
            return $resultado;
        } catch (PDOException $e) {
            echo 'Hubo un problema al modificar el registro: ' . $e->getMessage();
            return false;
        }
    }
}
?>