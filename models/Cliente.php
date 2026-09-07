<?php
class Cliente {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function listar() {
        $query = "SELECT * FROM clientes ORDER BY id_cliente DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM clientes WHERE id_cliente = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($datos) {
        $query = "INSERT INTO clientes (nombre, documento, telefono, email, direccion) 
                  VALUES (:nombre, :documento, :telefono, :email, :direccion)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($datos);
    }

    public function actualizar($id, $datos) {
        $query = "UPDATE clientes SET 
                    nombre = :nombre, 
                    documento = :documento, 
                    telefono = :telefono, 
                    email = :email, 
                    direccion = :direccion 
                  WHERE id_cliente = :id";
        $datos['id'] = $id;
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($datos);
    }

    public function eliminar($id) {
        $query = "DELETE FROM clientes WHERE id_cliente = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}