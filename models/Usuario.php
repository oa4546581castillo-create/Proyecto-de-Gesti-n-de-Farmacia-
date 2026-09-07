<?php
class Usuario {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método requerido por AuthController para el Inicio de Sesión (Login)
    public function buscarPorUsuario($usuario) {
        $query = "SELECT * FROM usuarios WHERE email = :usuario OR nombre = :usuario LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener todos los usuarios para la tabla de administración
    public function listar() {
        $query = "SELECT id_usuario, nombre, email, rol, fecha_registro FROM usuarios ORDER BY id_usuario DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un usuario por su ID
    public function obtenerPorId($id) {
        $query = "SELECT id_usuario, nombre, email, rol FROM usuarios WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Registrar un nuevo usuario con contraseña encriptada (Bcrypt)
    public function crear($datos) {
        $query = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (:nombre, :email, :password, :rol)";
        $stmt = $this->conn->prepare($query);
        
        $passwordHash = password_hash($datos['password'], PASSWORD_BCRYPT);

        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':email', $datos['email']);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':rol', $datos['rol']);

        return $stmt->execute();
    }

    // Actualizar datos de un usuario
    public function actualizar($id, $datos) {
        if (!empty($datos['password'])) {
            $query = "UPDATE usuarios SET nombre = :nombre, email = :email, password = :password, rol = :rol WHERE id_usuario = :id";
            $passwordHash = password_hash($datos['password'], PASSWORD_BCRYPT);
        } else {
            $query = "UPDATE usuarios SET nombre = :nombre, email = :email, rol = :rol WHERE id_usuario = :id";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':email', $datos['email']);
        $stmt->bindParam(':rol', $datos['rol']);
        $stmt->bindParam(':id', $id);

        if (!empty($datos['password'])) {
            $stmt->bindParam(':password', $passwordHash);
        }

        return $stmt->execute();
    }

    // Eliminar un usuario por ID
    public function eliminar($id) {
        $query = "DELETE FROM usuarios WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}