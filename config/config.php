<?php
// Ajusta BASE_PATH si cambias el nombre de la carpeta en htdocs
define('BASE_PATH', '/farmacia');
define('BASE_DIR', dirname(__DIR__));

define('DB_HOST', 'localhost');
define('DB_NAME', 'farmacia');
define('DB_USER', 'root');
define('DB_PASS', '');

define('APP_NAME', 'Sistema de Farmacia');
define('IVA', 0.16);              // Impuesto aplicado en ventas
define('DIAS_VENCIMIENTO', 90);   // Umbral de "próximos a vencer"