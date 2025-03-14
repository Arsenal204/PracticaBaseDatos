<?php
namespace App\Model;
use PDO;

class Reporte extends Model {
    protected $table = 'reportes';

    public function __construct(PDO $con) {
        parent::__construct($con);
    }

    public function obtenerPorUsuario($id_usuario) {
        $sql = "SELECT * FROM reportes WHERE id_usuario = :id_usuario";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
