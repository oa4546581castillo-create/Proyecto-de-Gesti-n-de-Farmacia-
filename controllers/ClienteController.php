<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Cliente.php';

class ClienteController {
    private $db;
    private $clienteModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->clienteModel = new Cliente($this->db);
    }

    public function index() {
        $clientes = $this->clienteModel->listar();
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/clientes/index.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre'    => trim($_POST['nombre'] ?? ''),
                'documento' => trim($_POST['documento'] ?? ''),
                'telefono'  => trim($_POST['telefono'] ?? ''),
                'email'     => trim($_POST['email'] ?? ''),
                'direccion' => trim($_POST['direccion'] ?? '')
            ];

            $this->clienteModel->crear($datos);
            header('Location: index.php?controlador=Cliente&accion=index');
            exit;
        }

        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/clientes/crear.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    public function editar() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controlador=Cliente&accion=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre'    => trim($_POST['nombre'] ?? ''),
                'documento' => trim($_POST['documento'] ?? ''),
                'telefono'  => trim($_POST['telefono'] ?? ''),
                'email'     => trim($_POST['email'] ?? ''),
                'direccion' => trim($_POST['direccion'] ?? '')
            ];

            $this->clienteModel->actualizar($id, $datos);
            header('Location: index.php?controlador=Cliente&accion=index');
            exit;
        }

        $cliente = $this->clienteModel->obtenerPorId($id);
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/clientes/editar.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    public function eliminar() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->clienteModel->eliminar($id);
        }
        header('Location: index.php?controlador=Cliente&accion=index');
        exit;
    }
}