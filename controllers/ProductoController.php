<?php
require_once '../config/database.php';
require_once '../models/Producto.php';

class ProductoController {
    private $db;
    private $productoModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->productoModel = new Producto($this->db);
    }

    public function index() {
        $productos = $this->productoModel->listarTodos();
        require_once '../views/layouts/header.php';
        require_once '../views/productos/index.php';
        require_once '../views/layouts/footer.php';
    }
}