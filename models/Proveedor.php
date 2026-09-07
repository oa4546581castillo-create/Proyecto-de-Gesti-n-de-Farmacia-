<?php
class Proveedor {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function listar() {
        $query = "SELECT * FROM proveedores ORDER BY id_proveedor DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM proveedores WHERE id_proveedor = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($datos) {
        $query = "INSERT INTO proveedores (nombre, contacto, telefono, email, direccion) 
                  VALUES (:nombre, :contacto, :telefono, :email, :direccion)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($datos);
    }

    public function actualizar($id, $datos) {
        $query = "UPDATE proveedores SET 
                    nombre = :nombre, 
                    contacto = :contacto, 
                    telefono = :telefono, 
                    email = :email, 
                    direccion = :direccion 
                  WHERE id_proveedor = :id";
        $datos['id'] = $id;
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($datos);
    }

    public function eliminar($id) {
        $query = "DELETE FROM proveedores WHERE id_proveedor = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}