<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Farmacia</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background-color: #f8fafc;
        }

        /* Barra de navegación principal */
        .main-header {
            background-color: #0f172a;
            color: #ffffff;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .brand-logo a {
            color: #38bdf8;
            font-size: 1.3rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: color 0.2s ease;
        }

        .brand-logo a:hover {
            color: #7dd3fc;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 20px 18px;
            color: #cbd5e1;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .nav-link:hover, .nav-item:hover > .nav-link {
            color: #ffffff;
            background-color: #1e293b;
        }

        /* Menús Desplegables (Dropdowns) */
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #ffffff;
            min-width: 250px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            border-radius: 0 0 10px 10px;
            overflow: hidden;
            list-style: none;
            margin: 0;
            padding: 8px 0;
            z-index: 1001;
            border: 1px solid #e2e8f0;
            animation: fadeIn 0.2s ease-in-out;
        }

        .nav-item:hover .dropdown-menu {
            display: block;
        }

        .dropdown-item a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            color: #334155;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .dropdown-item a:hover {
            background-color: #f0f9ff;
            color: #0284c7;
        }

        /* Sección de usuario en el encabezado */
        .user-section {
            display: flex;
            align-items: center;
            gap: 15px;
            background: #1e293b;
            padding: 8px 16px;
            border-radius: 20px;
            border: 1px solid #334155;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.88rem;
            color: #e2e8f0;
        }

        .user-role {
            font-size: 0.75rem;
            background: #0284c7;
            color: #ffffff;
            padding: 2px 8px;
            border-radius: 10px;
            text-transform: capitalize;
        }

        .btn-logout {
            color: #f87171;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
            background: rgba(239, 68, 68, 0.1);
            transition: background 0.2s ease;
        }

        .btn-logout:hover {
            background: rgba(239, 68, 68, 0.25);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
    </style>
</head>
<body>

    <header class="main-header">
        <!-- Logo con acceso directo al Dashboard -->
        <div class="brand-logo">
            <a href="index.php?controlador=Dashboard&accion=index">
                💊 Farmacia POS
            </a>
        </div>

        <!-- Menú de navegación principal con desplegables -->
        <ul class="nav-menu">
            <!-- Inicio / Dashboard -->
            <li class="nav-item">
                <a href="index.php?controlador=Dashboard&accion=index" class="nav-link">📊 Inicio</a>
            </li>

            <!-- Ventas -->
            <li class="nav-item">
                <a href="#" class="nav-link">🛒 Ventas ▾</a>
                <ul class="dropdown-menu">
                    <li class="dropdown-item">
                        <a href="index.php?controlador=Venta&accion=pos">💻 Punto de Venta (POS)</a>
                    </li>
                    <li class="dropdown-item">
                        <a href="index.php?controlador=Venta&accion=historial">📜 Historial y Reportes</a>
                    </li>
                </ul>
            </li>

            <!-- Inventario -->
            <li class="nav-item">
                <a href="#" class="nav-link">📦 Inventario ▾</a>
                <ul class="dropdown-menu">
                    <li class="dropdown-item">
                        <a href="index.php?controlador=Producto&accion=index">💊 Medicamentos</a>
                    </li>
                    <li class="dropdown-item">
                        <a href="index.php?controlador=Proveedor&accion=index">🚛 Proveedores</a>
                    </li>
                </ul>
            </li>

            <!-- Administración / CRUDs -->
            <li class="nav-item">
                <a href="#" class="nav-link">⚙️ Gestión ▾</a>
                <ul class="dropdown-menu">
                    <li class="dropdown-item">
                        <a href="index.php?controlador=Cliente&accion=index">👥 Clientes</a>
                    </li>
                    <li class="dropdown-item">
                        <a href="index.php?controlador=Usuario&accion=index">🔐 Usuarios y Permisos</a>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- Información de Usuario -->
        <?php if (isset($_SESSION['nombre'])): ?>
            <div class="user-section">
                <span class="user-name">👤 <?= htmlspecialchars($_SESSION['nombre']) ?></span>
                <span class="user-role"><?= htmlspecialchars($_SESSION['rol'] ?? 'Cajero') ?></span>
                <a href="index.php?controlador=Auth&accion=logout" class="btn-logout" title="Cerrar Sesión">Salir</a>
            </div>
        <?php endif; ?>
    </header>

    <main class="container">