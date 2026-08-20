<?php
class medicamento {
    private $conn;
    private $table_name = "medicamentos";

    public $id;
    public $nombre;
    public $laboratorio;
    public $precio;
    public $stock;
    public $fecha_vencimiento;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function listar() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " (nombre, laboratorio, precio, stock, fecha_vencimiento) 
                  VALUES (:nombre, :laboratorio, :precio, :stock, :fecha_vencimiento)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":laboratorio", $this->laboratorio);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":stock", $this->stock);
        $stmt->bindParam(":fecha_vencimiento", $this->fecha_vencimiento);

        return $stmt->execute();
    }
}