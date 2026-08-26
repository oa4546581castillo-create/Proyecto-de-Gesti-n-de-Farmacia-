<?php
class Producto {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function listar() {
        $query = "SELECT * FROM productos ORDER BY id_producto DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM productos WHERE id_producto = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($datos) {
        $query = "INSERT INTO productos (codigo_barras, nombre, descripcion, precio_compra, precio_venta, stock_actual, stock_minimo, fecha_vencimiento) 
                  VALUES (:codigo_barras, :nombre, :descripcion, :precio_compra, :precio_venta, :stock_actual, :stock_minimo, :fecha_vencimiento)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($datos);
    }

    public function actualizar($id, $datos) {
        $query = "UPDATE productos SET 
                    codigo_barras = :codigo_barras, 
                    nombre = :nombre, 
                    descripcion = :descripcion, 
                    precio_compra = :precio_compra, 
                    precio_venta = :precio_venta, 
                    stock_actual = :stock_actual, 
                    stock_minimo = :stock_minimo, 
                    fecha_vencimiento = :fecha_vencimiento 
                  WHERE id_producto = :id";
        $datos['id'] = $id;
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($datos);
    }

    public function eliminar($id) {
        $query = "DELETE FROM productos WHERE id_producto = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}