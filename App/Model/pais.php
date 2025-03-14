<?php
namespace App\Model;

use PDO;
use PDOException;

class Pais extends Model {
    protected $table = 'pais';

    public function __construct(PDO $con) {
        parent::__construct($con); 
    }


    public function cargar($id)
{
    try {
        $sql = "SELECT * FROM Pais WHERE id_pais = :id_pais";  
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':id_pais', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $resultado = $stmt->fetch();

        if (!$resultado) {
            error_log(" ERROR: No se encontró el país con ID $id en la base de datos.");
        }

        return $resultado;
    } catch (PDOException $e) {
        error_log(" ERROR SQL en cargar(): " . $e->getMessage());
        return false;
    }

}

public function borrar($id_pais) {
    try {
        // Eliminar las distribuciones asociadas a este país
        $sqlDistribuciones = "DELETE FROM distribuciones WHERE Pais_id_pais = :id_pais";
        $stmtDistribuciones = $this->con->prepare($sqlDistribuciones);
        $stmtDistribuciones->bindParam(':id_pais', $id_pais, PDO::PARAM_INT);
        $stmtDistribuciones->execute();

        // Eliminar la relación del país con los usuarios
        $sqlUsuarios = "DELETE FROM usuario_has_pais WHERE Pais_id_pais = :id_pais";
        $stmtUsuarios = $this->con->prepare($sqlUsuarios);
        $stmtUsuarios->bindParam(':id_pais', $id_pais, PDO::PARAM_INT);
        $stmtUsuarios->execute();

        $sql = "DELETE FROM pais WHERE id_pais = :id_pais";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':id_pais', $id_pais, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log(" ERROR al borrar país: " . $e->getMessage());
        return false;
    }
}


public function modificar($datos)
{
    try {
        $sql = "UPDATE Pais SET nombre_pais = :nombre_pais, region = :region, 
                estado_conflicto = :estado_conflicto, imagen = :imagen WHERE id_pais = :id_pais";

        $stmt = $this->con->prepare($sql);

        $stmt->bindParam(':nombre_pais', $datos['nombre_pais'], PDO::PARAM_STR);
        $stmt->bindParam(':region', $datos['region'], PDO::PARAM_STR);
        $stmt->bindParam(':estado_conflicto', $datos['estado_conflicto'], PDO::PARAM_INT);
        $stmt->bindParam(':imagen', $datos['imagen'], PDO::PARAM_STR);
        $stmt->bindParam(':id_pais', $datos['id_pais'], PDO::PARAM_INT);

        $resultado = $stmt->execute();

        if ($resultado) {
            error_log(" País con ID {$datos['id_pais']} actualizado correctamente.");
        } else {
            error_log(" ERROR: No se pudo actualizar el país con ID {$datos['id_pais']}.");
        }

        return $resultado;
    } catch (PDOException $e) {
        error_log(" ERROR SQL en modificar(): " . $e->getMessage());
        return false;
    }
}






    }

?>
