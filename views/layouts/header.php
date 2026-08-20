<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Farmacia</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <header class="main-header">
        <div class="logo">
            <h2>Farmacia - Control de Inventario & Ventas</h2>
        </div>
        <nav class="nav-menu">
            <a href="index.php?controlador=Producto&accion=index">Medicamentos</a>
            <a href="index.php?controlador=Venta&accion=pos">Punto de Venta (POS)</a>
            
            <?php if (isset($_SESSION['nombre'])): ?>
                <span style="margin-left: 20px; font-weight: bold; color: #e0f2fe;">
                    👤 <?= htmlspecialchars($_SESSION['nombre']) ?> (<?= $_SESSION['rol'] ?>)
                </span>
                <a href="index.php?controlador=Auth&accion=logout" style="color: #fca5a5; margin-left: 15px;">Cerrar Sesión</a>
            <?php endif; ?>
        </nav>
    </header>
    <main class="container">