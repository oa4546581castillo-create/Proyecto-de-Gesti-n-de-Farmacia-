<?php
class Producto {
    private $conn;
    private $table = "productos";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function listarTodos() {
        $query = "SELECT p.*, pr.nombre_proveedor 
                  FROM " . $this->table . " p 
                  LEFT JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor 
                  ORDER BY p.id_producto DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function crear($datos) {
        $query = "INSERT INTO " . $this->table . " 
                  (codigo_barras, nombre, descripcion, precio_compra, precio_venta, stock_actual, stock_minimo, fecha_vencimiento, id_proveedor) 
                  VALUES (:codigo, :nombre, :descripcion, :precio_compra, :precio_venta, :stock_actual, :stock_minimo, :fecha_vencimiento, :id_proveedor)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($datos);
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_producto = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}