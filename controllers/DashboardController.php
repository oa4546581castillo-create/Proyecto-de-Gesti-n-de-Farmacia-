<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Dashboard.php';

class DashboardController {
    private $db;
    private $dashboardModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->dashboardModel = new Dashboard($this->db);
    }

    public function index() {
        $ventasHoy = $this->dashboardModel->obtenerVentasHoy();
        $stockBajo = $this->dashboardModel->obtenerStockBajoCount();
        $porVencer = $this->dashboardModel->obtenerPorVencerCount();

        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/dashboard/index.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}