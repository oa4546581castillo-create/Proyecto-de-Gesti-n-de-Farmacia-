<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Venta.php';

class VentaController {
    private $db;
    private $ventaModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->ventaModel = new Venta($this->db);
    }

    // Cargar la pantalla principal del POS
    public function pos() {
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/ventas/pos.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    // Endpoint AJAX para buscar medicamentos en tiempo real
    public function buscarProducto() {
        $q = trim($_GET['q'] ?? '');
        $productos = [];
        if (!empty($q)) {
            $productos = $this->ventaModel->buscarProductos($q);
        }
        header('Content-Type: application/json');
        echo json_encode($productos);
        exit;
    }

    // Endpoint AJAX para procesar la compra
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            $id_usuario = $_SESSION['id_usuario'] ?? 1;
            $id_cliente = !empty($data['id_cliente']) ? $data['id_cliente'] : null;
            $total = $data['total'] ?? 0;
            $detalles = $data['detalles'] ?? [];

            if (empty($detalles)) {
                header('Content-Type: application/json');
                echo json_encode(['status' => false, 'mensaje' => 'El carrito está vacío']);
                exit;
            }

            $resultado = $this->ventaModel->registrarVenta($id_usuario, $id_cliente, $total, $detalles);
            
            header('Content-Type: application/json');
            echo json_encode($resultado);
            exit;
        }
    }

    // Muestra la pantalla del historial con filtros de fecha
    public function historial() {
        $fechaInicio = $_GET['fecha_inicio'] ?? date('Y-m-01');
        $fechaFin = $_GET['fecha_fin'] ?? date('Y-m-d');

        $ventas = $this->ventaModel->obtenerHistorial($fechaInicio, $fechaFin);

        $totalIngresos = array_sum(array_column($ventas, 'total'));

        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/ventas/historial.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    // Endpoint AJAX para cargar los medicamentos de una venta en el modal
    public function obtenerDetalle() {
        $id_venta = $_GET['id'] ?? null;
        if ($id_venta) {
            $detalles = $this->ventaModel->obtenerDetalleVenta($id_venta);
            header('Content-Type: application/json');
            echo json_encode($detalles);
            exit;
        }
    }
}