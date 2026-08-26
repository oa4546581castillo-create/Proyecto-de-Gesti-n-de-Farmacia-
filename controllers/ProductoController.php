<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Producto.php';

class ProductoController {
    private $db;
    private $productoModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->productoModel = new Producto($this->db);
    }

    public function index() {
        $productos = $this->productoModel->listar();
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/productos/index.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'codigo_barras' => trim($_POST['codigo_barras'] ?? ''),
                'nombre'        => trim($_POST['nombre'] ?? ''),
                'descripcion'   => trim($_POST['descripcion'] ?? ''),
                'precio_compra' => $_POST['precio_compra'] ?? 0,
                'precio_venta'  => $_POST['precio_venta'] ?? 0,
                'stock_actual'  => $_POST['stock_actual'] ?? 0,
                'stock_minimo'  => $_POST['stock_minimo'] ?? 0,
                'fecha_vencimiento' => !empty($_POST['fecha_vencimiento']) ? $_POST['fecha_vencimiento'] : null
            ];

            $this->productoModel->crear($datos);
            header('Location: index.php?controlador=Producto&accion=index');
            exit;
        }

        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/productos/crear.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    public function editar() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controlador=Producto&accion=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'codigo_barras' => trim($_POST['codigo_barras'] ?? ''),
                'nombre'        => trim($_POST['nombre'] ?? ''),
                'descripcion'   => trim($_POST['descripcion'] ?? ''),
                'precio_compra' => $_POST['precio_compra'] ?? 0,
                'precio_venta'  => $_POST['precio_venta'] ?? 0,
                'stock_actual'  => $_POST['stock_actual'] ?? 0,
                'stock_minimo'  => $_POST['stock_minimo'] ?? 0,
                'fecha_vencimiento' => !empty($_POST['fecha_vencimiento']) ? $_POST['fecha_vencimiento'] : null
            ];

            $this->productoModel->actualizar($id, $datos);
            header('Location: index.php?controlador=Producto&accion=index');
            exit;
        }

        $producto = $this->productoModel->obtenerPorId($id);
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/productos/editar.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    public function eliminar() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->productoModel->eliminar($id);
        }
        header('Location: index.php?controlador=Producto&accion=index');
        exit;
    }
}