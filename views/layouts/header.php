<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$rolUsuario = $_SESSION['rol'] ?? 'cajero';
$nombreUsuario = $_SESSION['nombre'] ?? 'Usuario';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Farmacia</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f8fafc; color: #1e293b; min-height: 100vh; }
        
        /* Navbar Sticky principal */
        .navbar {
            background-color: #0f172a;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 24px;
            height: 64px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            color: #38bdf8;
            font-size: 1.25rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 8px;
            align-items: center;
        }

        .nav-item { position: relative; }

        .nav-link {
            color: #94a3b8;
            text-decoration: none;
            padding: 10px 14px;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link:hover {
            color: #ffffff;
            background-color: #1e293b;
        }

        /* Desplegables (Dropdowns) */
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #1e293b;
            min-width: 200px;
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
            padding: 8px 0;
            list-style: none;
            z-index: 1100;
        }

        .nav-item:hover .dropdown-menu { display: block; }

        .dropdown-link {
            color: #cbd5e1;
            text-decoration: none;
            padding: 10px 16px;
            display: block;
            font-size: 0.85rem;
            transition: background-color 0.2s;
        }

        .dropdown-link:hover {
            background-color: #334155;
            color: #38bdf8;
        }

        /* Área de usuario */
        .user-area {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-info {
            text-align: right;
            color: #e2e8f0;
            font-size: 0.85rem;
        }

        .user-role {
            font-size: 0.75rem;
            padding: 2px 8px;
            border-radius: 10px;
            font-weight: 600;
            display: inline-block;
        }

        .role-admin { background: #fef3c7; color: #92400e; }
        .role-farmaceutico { background: #e0e7ff; color: #3730a3; }
        .role-cajero { background: #dcfce7; color: #166534; }

        .btn-logout {
            background: #ef4444;
            color: white;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .btn-logout:hover { background: #dc2626; }

        /* Contenedor principal de la app */
        .main-container {
            max-width: 1280px;
            margin: 24px auto;
            padding: 0 20px;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="index.php?controlador=Dashboard&accion=index" class="navbar-brand">
        💊 Farmacia Sys
    </a>

    <ul class="nav-menu">
        <li class="nav-item">
            <a href="index.php?controlador=Dashboard&accion=index" class="nav-link">📊 Inicio</a>
        </li>

        <!-- Módulo de Ventas (Disponible para todos los roles) -->
        <li class="nav-item">
            <a href="#" class="nav-link">🛒 Ventas ▾</a>
            <ul class="dropdown-menu">
                <li><a href="index.php?controlador=Venta&accion=pos" class="dropdown-link">💳 Punto de Venta (POS)</a></li>
                <?php if (in_array($rolUsuario, ['admin', 'farmaceutico'])): ?>
                    <li><a href="index.php?controlador=Venta&accion=historial" class="dropdown-link">📜 Historial y Reportes</a></li>
                <?php endif; ?>
            </ul>
        </li>

        <!-- Módulo de Inventario (Solo Admin y Farmacéutico) -->
        <?php if (in_array($rolUsuario, ['admin', 'farmaceutico'])): ?>
            <li class="nav-item">
                <a href="#" class="nav-link">📦 Inventario ▾</a>
                <ul class="dropdown-menu">
                    <li><a href="index.php?controlador=Producto&accion=index" class="dropdown-link">💊 Medicamentos / Productos</a></li>
                    <li><a href="index.php?controlador=Proveedor&accion=index" class="dropdown-link">🏭 Proveedores / Laboratorios</a></li>
                </ul>
            </li>
        <?php endif; ?>

        <!-- Módulo de Clientes (Todos los usuarios) -->
        <li class="nav-item">
            <a href="index.php?controlador=Cliente&accion=index" class="nav-link">👥 Clientes</a>
        </li>

        <!-- Módulo de Usuarios y Permisos (EXCLUSIVO ADMINISTRADOR) -->
        <?php if ($rolUsuario === 'admin'): ?>
            <li class="nav-item">
                <a href="index.php?controlador=Usuario&accion=index" class="nav-link">⚙️ Usuarios y Permisos</a>
            </li>
        <?php endif; ?>
    </ul>

    <!-- Info del usuario autenticado -->
    <div class="user-area">
        <div class="user-info">
            <div><strong><?= htmlspecialchars($nombreUsuario) ?></strong></div>
            <span class="user-role role-<?= htmlspecialchars($rolUsuario) ?>">
                <?= strtoupper(htmlspecialchars($rolUsuario)) ?>
            </span>
        </div>
        <a href="index.php?controlador=Auth&accion=logout" class="btn-logout">Salir</a>
    </div>
</nav>

<div class="main-container">