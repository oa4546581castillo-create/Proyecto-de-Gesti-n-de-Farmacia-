<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Dashboard.php';
require_once __DIR__ . '/../service/GeminiService.php'; // Incluimos el servicio de Gemini

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

    // Endpoint AJAX para atender consultas del asistente
    public function consultarAsistente() {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);
        $preguntaUsuario = trim($input['pregunta'] ?? '');

        if (empty($preguntaUsuario)) {
            echo json_encode(['status' => false, 'error' => 'Por favor escribe una pregunta.']);
            return;
        }

        try {
            // Consultar datos reales del sistema
            $stmtProductos = $this->db->query("SELECT COUNT(*) FROM productos");
            $totalProductos = $stmtProductos ? $stmtProductos->fetchColumn() : 0;

            $ventasHoy = $this->dashboardModel->obtenerVentasHoy();

            $stmtStockBajo = $this->db->query("SELECT nombre, stock_actual FROM productos WHERE stock_actual <= stock_minimo");
            $prodsStockBajo = $stmtStockBajo ? $stmtStockBajo->fetchAll(PDO::FETCH_ASSOC) : [];

            $listaBajoStock = [];
            foreach ($prodsStockBajo as $p) {
                $listaBajoStock[] = $p['nombre'] . " (" . $p['stock_actual'] . " unids)";
            }
            $textoStockBajo = !empty($listaBajoStock) ? implode(', ', $listaBajoStock) : 'Ninguno';

            // Definir el prompt con contexto dinámico de la base de datos
            $promptContextualizado = "
                Eres el asistente virtual inteligente de la farmacia.
                El estado en tiempo real de la base de datos es:
                - Productos registrados en total: {$totalProductos}
                - Ventas acumuladas de hoy: \${$ventasHoy}
                - Medicamentos con stock bajo o agotándose: {$textoStockBajo}

                El usuario consulta: \"{$preguntaUsuario}\"

                Instrucciones: Responde de forma clara, directa y amable en máximo 3 oraciones usando los datos del sistema cuando sea necesario.
            ";

            // Enviar la consulta a Gemini API
            $gemini = new GeminiService();
            $resultado = $gemini->consultarAI($promptContextualizado);

            echo json_encode($resultado);

        } catch (Exception $e) {
            echo json_encode(['status' => false, 'error' => 'Error al procesar la solicitud: ' . $e->getMessage()]);
        }
    }
}