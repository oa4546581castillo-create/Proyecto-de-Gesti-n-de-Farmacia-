<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema de Farmacia</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        .login-box {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { width: 100%; padding: 12px; background: #0284c7; color: white; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer; }
        .btn-submit:hover { background: #0369a1; }
        .alert-error { background: #fef2f2; color: #dc2626; padding: 10px; border-radius: 4px; margin-bottom: 15px; border: 1px solid #fca5a5; }
    </style>
</head>
<body style="background-color: #f4f6f9;">

<div class="login-box">
    <h2 style="text-align: center; color: #0284c7; margin-bottom: 20px;">Farmacia POS</h2>
    <p style="text-align: center; color: #666; margin-bottom: 25px;">Ingresa tus credenciales para acceder</p>

    <?php if (!empty($error)): ?>
        <div class="alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="index.php?controlador=Auth&accion=login" method="POST">
        <div class="form-group">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required placeholder="Ej. admin">
        </div>

        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required placeholder="••••••••">
        </div>

        <button type="submit" class="btn-submit">Iniciar Sesión</button>
    </form>
</div>

</body>
</html>