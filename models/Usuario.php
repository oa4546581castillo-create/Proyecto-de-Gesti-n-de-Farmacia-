<?php
class Usuario {
    private $conn;
    private $table = "usuarios";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Buscar un usuario activo por su nombre de usuario
    public function buscarPorUsuario($usuario) {
        $query = "SELECT * FROM " . $this->table . " WHERE usuario = :usuario AND estado = 1 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':usuario' => $usuario]);
        return $stmt->fetch();
    }
}