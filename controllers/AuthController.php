<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Usuario.php';

class AuthController {
    private $db;
    private $usuarioModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->usuarioModel = new Usuario($this->db);
    }

    public function login() {
        // Si ya hay sesión iniciada, redirigir al Dashboard
        if (isset($_SESSION['id_usuario'])) {
            header('Location: index.php?controlador=Dashboard&accion=index');
            exit;
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = trim($_POST['usuario'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (!empty($usuario) && !empty($password)) {
                $datosUsuario = $this->usuarioModel->buscarPorUsuario($usuario);

                // Verificar usuario y desencriptar contraseña
                if ($datosUsuario && password_verify($password, $datosUsuario['password'])) {
                    // Guardar variables de sesión
                    $_SESSION['id_usuario'] = $datosUsuario['id_usuario'];
                    $_SESSION['nombre'] = $datosUsuario['nombre'];
                    $_SESSION['usuario'] = $datosUsuario['usuario'];
                    $_SESSION['rol'] = $datosUsuario['rol'];

                    // Redirigir al Dashboard tras login exitoso
                    header('Location: index.php?controlador=Dashboard&accion=index');
                    exit;
                } else {
                    $error = "Usuario o contraseña incorrectos.";
                }
            } else {
                $error = "Por favor, ingresa todos los campos.";
            }
        }

        // Cargar vista de Login
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function logout() {
        session_destroy();
        header('Location: index.php?controlador=Auth&accion=login');
        exit;
    }
}