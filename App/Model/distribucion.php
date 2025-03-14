<?php
namespace App\Model;
use PDO;
use PDOException;

class Distribucion extends Model {
    protected $table = 'distribuciones';

    public function __construct(PDO $con) {
        parent::__construct($con);
    }

    public function cargarPorPais($id_pais)
{
    try {
       
        $sql = "SELECT * FROM Distribuciones WHERE Pais_id_pais = :id_pais ORDER BY fecha_distribucion DESC";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':id_pais', $id_pais, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log(" ERROR SQL en cargarPorPais(): " . $e->getMessage());
        return false;
    }
}
public function insertar($datos) {
    try {
        $sql = "INSERT INTO distribuciones (Pais_id_pais, fecha_distribucion, cantidad_total, estado) 
                VALUES (:Pais_id_pais, :fecha_distribucion, :cantidad_total, :estado)";

        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':Pais_id_pais', $datos['Pais_id_pais'], PDO::PARAM_INT);
        $stmt->bindParam(':fecha_distribucion', $datos['fecha_distribucion'], PDO::PARAM_STR);
        $stmt->bindParam(':cantidad_total', $datos['cantidad_total'], PDO::PARAM_INT);
        $stmt->bindParam(':estado', $datos['estado'], PDO::PARAM_STR);

        $stmt->execute();
        
        return $this->con->lastInsertId();
    } catch (PDOException $e) {
        error_log(" ERROR SQL en insertar distribución: " . $e->getMessage());
        return false;
    }
}

public function cargar($id) {
    try {
        // Usamos `id_distribucion` en lugar de `iddistribuciones`
        $sql = "SELECT * FROM distribuciones WHERE id_distribucion = :id";

        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log(" ERROR al consultar la distribución: " . $e->getMessage());
        return false;
    }
}

public function borrar($id_distribucion) {
    try {
        // Eliminar los detalles de la distribución primero
        $sqlDetalles = "DELETE FROM detalles_distribucion WHERE Distribuciones_id_distribucion = :id_distribucion";
        $stmtDetalles = $this->con->prepare($sqlDetalles);
        $stmtDetalles->bindParam(':id_distribucion', $id_distribucion, PDO::PARAM_INT);
        $stmtDetalles->execute();

        // Ahora sí, eliminar la distribución
        $sql = "DELETE FROM distribuciones WHERE id_distribucion = :id_distribucion";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':id_distribucion', $id_distribucion, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log(" ERROR al borrar distribución: " . $e->getMessage());
        return false;
    }
}






}
?>
