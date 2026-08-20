<?php
class Venta {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrarVenta($idCliente, $idUsuario, $total, $detalles) {
        try {
            $this->conn->beginTransaction();

            // 1. Insertar la venta principal
            $queryVenta = "INSERT INTO ventas (id_cliente, id_usuario, total) VALUES (:cliente, :usuario, :total)";
            $stmtVenta = $this->conn->prepare($queryVenta);
            $stmtVenta->execute([
                ':cliente' => $idCliente ?: null,
                ':usuario' => $idUsuario,
                ':total'   => $total
            ]);
            $idVenta = $this->conn->lastInsertId();

            // 2. Insertar detalles y descontar stock en tiempo real
            $queryDetalle = "INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, precio_unitario, subtotal) 
                             VALUES (:id_venta, :id_producto, :cantidad, :precio, :subtotal)";
            $stmtDetalle = $this->conn->prepare($queryDetalle);

            $queryStock = "UPDATE productos SET stock_actual = stock_actual - :cantidad WHERE id_producto = :id_producto";
            $stmtStock = $this->conn->prepare($queryStock);

            foreach ($detalles as $item) {
                $stmtDetalle->execute([
                    ':id_venta'    => $idVenta,
                    ':id_producto' => $item['id_producto'],
                    ':cantidad'    => $item['cantidad'],
                    ':precio'      => $item['precio_unitario'],
                    ':subtotal'    => $item['subtotal']
                ]);

                $stmtStock->execute([
                    ':cantidad'    => $item['cantidad'],
                    ':id_producto' => $item['id_producto']
                ]);
            }

            $this->conn->commit();
            return $idVenta;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
}