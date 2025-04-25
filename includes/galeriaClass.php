<?php
class Galeria {
    private $conn;
    private $table = "galeria";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        return $this->conn->query($query);
    }

    public function create($titulo, $categoria, $archivo) {
        $query = "INSERT INTO " . $this->table . " (titulo, categoria, archivo)
                  VALUES (:titulo, :categoria, :archivo)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":titulo", $titulo);
        $stmt->bindParam(":categoria", $categoria);
        $stmt->bindParam(":archivo", $archivo);
        return $stmt->execute();
    }

    public function update($id, $titulo, $categoria, $archivo) {
        $query = "UPDATE " . $this->table . " SET titulo = :titulo, categoria = :categoria, archivo = :archivo
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":titulo", $titulo);
        $stmt->bindParam(":categoria", $categoria);
        $stmt->bindParam(":archivo", $archivo);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>