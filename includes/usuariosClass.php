<?php
class Usuario {
    private $conn;
    private $table = "usuarios";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($usuario, $clave) {
        $query = "SELECT * FROM " . $this->table . " WHERE usuario = :usuario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":usuario", $usuario);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($clave, $row['clave'])) {
                return ["status" => "ok", "user" => $row['usuario']];
            }
        }
        return ["status" => "error", "message" => "Credenciales incorrectas"];
    }

    public function create($usuario, $clave) {
        $query = "INSERT INTO " . $this->table . " (usuario, clave)
                  VALUES (:usuario, :clave)";
        $stmt = $this->conn->prepare($query);

        // Hash la clave antes de guardar
        $hashedPassword = password_hash($clave, PASSWORD_DEFAULT);

        $stmt->bindParam(":usuario", $usuario);
        $stmt->bindParam(":clave", $hashedPassword);
        return $stmt->execute();
    }

    public function update($id, $usuario, $clave) {
        $query = "UPDATE " . $this->table . " SET usuario = :usuario, clave = :clave WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Hash la nueva clave
        $hashedPassword = password_hash($clave, PASSWORD_DEFAULT);

        $stmt->bindParam(":usuario", $usuario);
        $stmt->bindParam(":clave", $hashedPassword);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }
}
?>