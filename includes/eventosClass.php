<?php
class Eventos {
    private $conn;
    private $table = "eventos";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        return $this->conn->query($query);
    }

    public function create($titulo, $descripcion, $fecha, $hora_inicio, $hora_fin, $lugar, $categoria, $participantes, $imagen) {
        $query = "INSERT INTO " . $this->table . "
                  (titulo, descripcion, fecha, hora_inicio, hora_fin, lugar, categoria, participantes, imagen)
                  VALUES (:titulo, :descripcion, :fecha, :hora_inicio, :hora_fin, :lugar, :categoria, :participantes, :imagen)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":titulo", $titulo);
        $stmt->bindParam(":descripcion", $descripcion);
        $stmt->bindParam(":fecha", $fecha);
        $stmt->bindParam(":hora_inicio", $hora_inicio);
        $stmt->bindParam(":hora_fin", $hora_fin);
        $stmt->bindParam(":lugar", $lugar);
        $stmt->bindParam(":categoria", $categoria);
        $stmt->bindParam(":participantes", $participantes);
        $stmt->bindParam(":imagen", $imagen);

        return $stmt->execute();
    }

    public function update($id, $titulo, $descripcion, $fecha, $hora_inicio, $hora_fin, $lugar, $categoria, $participantes, $imagen) {
        $query = "UPDATE " . $this->table . " SET
                  titulo = :titulo, descripcion = :descripcion, fecha = :fecha, hora_inicio = :hora_inicio,
                  hora_fin = :hora_fin, lugar = :lugar, categoria = :categoria, participantes = :participantes, imagen = :imagen
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":titulo", $titulo);
        $stmt->bindParam(":descripcion", $descripcion);
        $stmt->bindParam(":fecha", $fecha);
        $stmt->bindParam(":hora_inicio", $hora_inicio);
        $stmt->bindParam(":hora_fin", $hora_fin);
        $stmt->bindParam(":lugar", $lugar);
        $stmt->bindParam(":categoria", $categoria);
        $stmt->bindParam(":participantes", $participantes);
        $stmt->bindParam(":imagen", $imagen);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function obtenerEventoPorId($id) {
    $query = "SELECT * FROM eventos WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

}
?>