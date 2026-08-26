<?php
class Venta {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Buscar productos activos con stock disponible por nombre o código de barras (POS)
    public function buscarProductos($criterio) {
        $query = "SELECT id_producto, nombre, precio_venta, stock_actual 
                  FROM productos 
                  WHERE (nombre LIKE :crit OR codigo_barras LIKE :crit) 
                    AND stock_actual > 0 
                  LIMIT 10";
        $stmt = $this->conn->prepare($query);
        $param = "%" . $criterio . "%";
        $stmt->bindParam(':crit', $param);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Registrar la venta en la base de datos dentro de una transacción (POS)
    public function registrarVenta($id_usuario, $id_cliente, $total, $detalles) {
        try {
            $this->conn->beginTransaction();

            // 1. Insertar encabezado de venta
            $queryVenta = "INSERT INTO ventas (id_usuario, id_cliente, total, fecha_venta) 
                           VALUES (:id_usuario, :id_cliente, :total, NOW())";
            $stmtVenta = $this->conn->prepare($queryVenta);
            $stmtVenta->bindParam(':id_usuario', $id_usuario);
            $stmtVenta->bindParam(':id_cliente', $id_cliente);
            $stmtVenta->bindParam(':total', $total);
            $stmtVenta->execute();

            $id_venta = $this->conn->lastInsertId();

            // 2. Preprar consultas para el detalle y la actualización de stock
            $queryDetalle = "INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, precio_unitario, subtotal) 
                             VALUES (:id_venta, :id_producto, :cantidad, :precio, :subtotal)";
            $stmtDetalle = $this->conn->prepare($queryDetalle);

            $queryStock = "UPDATE productos SET stock_actual = stock_actual - :cantidad WHERE id_producto = :id_producto";
            $stmtStock = $this->conn->prepare($queryStock);

            // 3. Iterar cada producto vendido
            foreach ($detalles as $item) {
                $stmtDetalle->bindParam(':id_venta', $id_venta);
                $stmtDetalle->bindParam(':id_producto', $item['id_producto']);
                $stmtDetalle->bindParam(':cantidad', $item['cantidad']);
                $stmtDetalle->bindParam(':precio', $item['precio']);
                $stmtDetalle->bindParam(':subtotal', $item['subtotal']);
                $stmtDetalle->execute();

                $stmtStock->bindParam(':cantidad', $item['cantidad']);
                $stmtStock->bindParam(':id_producto', $item['id_producto']);
                $stmtStock->execute();
            }

            $this->conn->commit();
            return ['status' => true, 'id_venta' => $id_venta];

        } catch (Exception $e) {
            $this->conn->rollBack();
            return ['status' => false, 'mensaje' => $e->getMessage()];
        }
    }

    // Obtener el historial de ventas con filtros de fecha opcionales (HISTORIAL)
    public function obtenerHistorial($fechaInicio = null, $fechaFin = null) {
        $sql = "SELECT v.id_venta, v.total, v.fecha_venta, 
                       u.nombre AS cajero, 
                       COALESCE(c.nombre, 'Cliente General') AS cliente
                FROM ventas v
                INNER JOIN usuarios u ON v.id_usuario = u.id_usuario
                LEFT JOIN clientes c ON v.id_cliente = c.id_cliente";

        if ($fechaInicio && $fechaFin) {
            $sql .= " WHERE DATE(v.fecha_venta) BETWEEN :fecha_inicio AND :fecha_fin";
        }

        $sql .= " ORDER BY v.fecha_venta DESC";

        $stmt = $this->conn->prepare($sql);

        if ($fechaInicio && $fechaFin) {
            $stmt->bindParam(':fecha_inicio', $fechaInicio);
            $stmt->bindParam(':fecha_fin', $fechaFin);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener los productos comprados en una venta específica (HISTORIAL)
    public function obtenerDetalleVenta($id_venta) {
        $sql = "SELECT dv.cantidad, dv.precio_unitario, dv.subtotal, p.nombre AS producto
                FROM detalle_ventas dv
                INNER JOIN productos p ON dv.id_producto = p.id_producto
                WHERE dv.id_venta = :id_venta";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_venta', $id_venta);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}