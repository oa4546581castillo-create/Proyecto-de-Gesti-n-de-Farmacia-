<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema de Farmacia</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }
        .login-card {
            background: #ffffff;
            width: 100%;
            max-width: 400px;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .login-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 25px 30px -5px rgba(0, 0, 0, 0.4);
        }
        .brand-header {
            text-align: center;
            margin-bottom: 25px;
        }
        .brand-header h2 {
            color: #0284c7;
            font-size: 1.8rem;
            margin-bottom: 6px;
        }
        .brand-header p {
            color: #64748b;
            font-size: 0.95rem;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #334155;
            font-size: 0.9rem;
        }
        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            outline: none;
            transition: all 0.25s ease;
            box-sizing: border-box;
        }
        .form-group input:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.15);
        }
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #0284c7;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s ease;
        }
        .btn-submit:hover {
            background: #0369a1;
        }
        .btn-submit:active {
            transform: scale(0.98);
        }
        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #fecaca;
            font-size: 0.9rem;
            animation: shake 0.3s ease-in-out;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="brand-header">
        <h2>Farmacia POS</h2>
        <p>Ingresa tus credenciales para acceder</p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert-error">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="index.php?controlador=Auth&accion=login" method="POST">
        <div class="form-group">
            <label for="usuario">Usuario</label>
            <input type="text" id="usuario" name="usuario" required placeholder="Ej. admin" autocomplete="off">
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required placeholder="••••••••">
        </div>

        <button type="submit" class="btn-submit">Iniciar Sesión</button>
    </form>
</div>

</body>
</html>