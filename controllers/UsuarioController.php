<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController {
    private $db;
    private $usuarioModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Restricción de Seguridad: Solo Administradores
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
            header('Location: index.php?controlador=Dashboard&accion=index');
            exit;
        }

        $database = new Database();
        $this->db = $database->getConnection();
        $this->usuarioModel = new Usuario($this->db);
    }

    public function index() {
        $usuarios = $this->usuarioModel->listar();
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/usuarios/index.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre'   => trim($_POST['nombre'] ?? ''),
                'email'    => trim($_POST['email'] ?? ''),
                'password' => $_POST['password'] ?? '',
                'rol'      => $_POST['rol'] ?? 'cajero'
            ];

            $this->usuarioModel->crear($datos);
            header('Location: index.php?controlador=Usuario&accion=index');
            exit;
        }

        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/usuarios/crear.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    public function editar() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controlador=Usuario&accion=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre'   => trim($_POST['nombre'] ?? ''),
                'email'    => trim($_POST['email'] ?? ''),
                'password' => $_POST['password'] ?? '',
                'rol'      => $_POST['rol'] ?? 'cajero'
            ];

            $this->usuarioModel->actualizar($id, $datos);
            header('Location: index.php?controlador=Usuario&accion=index');
            exit;
        }

        $usuario = $this->usuarioModel->obtenerPorId($id);
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/usuarios/editar.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    public function eliminar() {
        $id = $_GET['id'] ?? null;
        
        // Evitar que el administrador se elimine a sí mismo
        if ($id && $id != $_SESSION['id_usuario']) {
            $this->usuarioModel->eliminar($id);
        }

        header('Location: index.php?controlador=Usuario&accion=index');
        exit;
    }
}