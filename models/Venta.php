<?php
class Venta {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Buscar productos activos con stock disponible por nombre o código de barras
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

    // Registrar la venta en la base de datos dentro de una transacción
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
                // Insertar detalle
                $stmtDetalle->bindParam(':id_venta', $id_venta);
                $stmtDetalle->bindParam(':id_producto', $item['id_producto']);
                $stmtDetalle->bindParam(':cantidad', $item['cantidad']);
                $stmtDetalle->bindParam(':precio', $item['precio']);
                $stmtDetalle->bindParam(':subtotal', $item['subtotal']);
                $stmtDetalle->execute();

                // Descontar stock
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
}