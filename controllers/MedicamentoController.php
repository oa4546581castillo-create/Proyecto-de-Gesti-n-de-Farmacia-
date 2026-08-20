<?php
require_once 'config/database.php';
require_once 'models/Medicamento.php';

class MedicamentoController {
    private $db;
    private $medicamento;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->medicamento = new Medicamento($this->db);
    }

    public function index() {
        $stmt = $this->medicamento->listar();
        $medicamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once 'views/medicamentos/index.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->medicamento->nombre = $_POST['nombre'];
            $this->medicamento->laboratorio = $_POST['laboratorio'];
            $this->medicamento->precio = $_POST['precio'];
            $this->medicamento->stock = $_POST['stock'];
            $this->medicamento->fecha_vencimiento = $_POST['fecha_vencimiento'];

            if ($this->medicamento->crear()) {
                header("Location: index.php?controlador=Medicamento&accion=index");
            }
        }
    }
}