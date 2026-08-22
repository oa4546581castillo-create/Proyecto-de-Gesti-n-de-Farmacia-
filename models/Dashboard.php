<?php
class Dashboard {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Calcular el total vendido durante el día actual
    public function obtenerVentasHoy() {
        $query = "SELECT IFNULL(SUM(total), 0) AS total_hoy FROM ventas WHERE DATE(fecha_venta) = CURDATE()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $resultado = $stmt->fetch();
        return $resultado['total_hoy'];
    }

    // Contar productos donde el stock actual sea menor o igual al stock mínimo
    public function obtenerStockBajoCount() {
        $query = "SELECT COUNT(*) AS total FROM productos WHERE stock_actual <= stock_minimo";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $resultado = $stmt->fetch();
        return $resultado['total'];
    }

    // Contar medicamentos que vencen en los próximos 30 días (o ya vencidos)
    public function obtenerPorVencerCount() {
        $query = "SELECT COUNT(*) AS total FROM productos 
                  WHERE fecha_vencimiento <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $resultado = $stmt->fetch();
        return $resultado['total'];
    }
}