<?php
namespace App\Model;
use PDO;

class Producto extends Model {
    protected $table = 'productos';

    public function __construct(PDO $con) {
        parent::__construct($con);
    }

    public function obtenerPorTipo($tipo) {
        $sql = "SELECT * FROM productos WHERE tipo = :tipo";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
