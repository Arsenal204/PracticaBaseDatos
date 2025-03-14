<?php
namespace App\Model;

use PDO;
use PDOException;

class DetallesDistribucion extends Model
{
    protected $table = "Detalles_Distribucion";

    /**
     * Obtener los productos distribuidos en una distribución específica.
     */
    public function cargarProductosPorDistribucion($id_distribucion)
    {
        try {
            $sql = "SELECT p.id_producto, p.nombre_producto, p.tipo, dd.cantidad
                    FROM Detalles_Distribucion dd
                    JOIN Productos p ON dd.id_producto = p.id_producto
                    WHERE dd.id_distribucion = :id_distribucion";

            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':id_distribucion', $id_distribucion, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log(" ERROR en cargarProductosPorDistribucion(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Insertar un nuevo detalle de distribución.
     */
    public function insertar($datos)
{
    try {
        $sql = "INSERT INTO detalles_distribucion (Distribuciones_id_distribucion, Productos_id_producto, cantidad, unidad_medida, observaciones) 
                VALUES (:Distribuciones_id_distribucion, :Productos_id_producto, :cantidad, :unidad_medida, :observaciones)";
        

        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':id_distribucion', $datos['id_distribucion'], PDO::PARAM_INT);
        $stmt->bindParam(':id_producto', $datos['id_producto'], PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $datos['cantidad'], PDO::PARAM_INT);

        return $stmt->execute();
    } catch (PDOException $e) {
        error_log(" ERROR en insertar detalle de distribución: " . $e->getMessage());
        return false;
    }
}


    /**
     * Eliminar todos los detalles de una distribución específica.
     */
    public function borrarPorDistribucion($id_distribucion)
    {
        try {
            $sql = "DELETE FROM Detalles_Distribucion WHERE id_distribucion = :id_distribucion";

            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':id_distribucion', $id_distribucion, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log(" ERROR en borrarPorDistribucion(): " . $e->getMessage());
            return false;
        }
    }
}



?>
