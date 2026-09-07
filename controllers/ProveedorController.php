<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Proveedor.php';

class ProveedorController {
    private $db;
    private $proveedorModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->proveedorModel = new Proveedor($this->db);
    }

    public function index() {
        $proveedores = $this->proveedorModel->listar();
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/proveedores/index.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre'    => trim($_POST['nombre'] ?? ''),
                'contacto'  => trim($_POST['contacto'] ?? ''),
                'telefono'  => trim($_POST['telefono'] ?? ''),
                'email'     => trim($_POST['email'] ?? ''),
                'direccion' => trim($_POST['direccion'] ?? '')
            ];

            $this->proveedorModel->crear($datos);
            header('Location: index.php?controlador=Proveedor&accion=index');
            exit;
        }

        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/proveedores/crear.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    public function editar() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controlador=Proveedor&accion=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre'    => trim($_POST['nombre'] ?? ''),
                'contacto'  => trim($_POST['contacto'] ?? ''),
                'telefono'  => trim($_POST['telefono'] ?? ''),
                'email'     => trim($_POST['email'] ?? ''),
                'direccion' => trim($_POST['direccion'] ?? '')
            ];

            $this->proveedorModel->actualizar($id, $datos);
            header('Location: index.php?controlador=Proveedor&accion=index');
            exit;
        }

        $proveedor = $this->proveedorModel->obtenerPorId($id);
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/proveedores/editar.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    public function eliminar() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->proveedorModel->eliminar($id);
        }
        header('Location: index.php?controlador=Proveedor&accion=index');
        exit;
    }
}