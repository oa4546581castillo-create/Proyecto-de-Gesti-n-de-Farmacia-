<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema de Farmacia</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; }
        
        body {
            background-color: #0b0f19;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow: hidden;
            position: relative;
        }

        /* --- Fondo Interactivo con Orbes Animados --- */
        .bg-glow {
            position: absolute;
            width: 350px;
            height: 350px;
            border-radius: 50%;
            filter: blur(90px);
            opacity: 0.4;
            animation: floatGlow 10s infinite alternate ease-in-out;
            z-index: 1;
        }

        .glow-1 { background: #0284c7; top: 10%; left: 15%; }
        .glow-2 { background: #0d9488; bottom: 10%; right: 15%; animation-delay: -5s; }

        @keyframes floatGlow {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(40px, 30px) scale(1.15); }
        }

        /* --- Tarjeta Glassmorphism --- */
        .login-card {
            position: relative;
            z-index: 10;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 420px;
            animation: cardAppear 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes cardAppear {
            from { opacity: 0; transform: translateY(20px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .login-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .brand-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #0284c7, #0f766e);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            box-shadow: 0 8px 16px -4px rgba(2, 132, 199, 0.4);
            font-size: 1.8rem;
        }

        .login-header h1 {
            font-size: 1.6rem;
            color: #f8fafc;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .login-header p {
            font-size: 0.85rem;
            color: #94a3b8;
            margin-top: 4px;
        }

        /* --- Formularios e Inputs --- */
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: #cbd5e1;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: #64748b;
            transition: color 0.2s ease;
            pointer-events: none;
        }

        .form-control {
            width: 100%;
            padding: 12px 14px 12px 42px;
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            font-size: 0.95rem;
            color: #f8fafc;
            transition: all 0.25s ease;
        }

        .form-control:focus {
            outline: none;
            background: rgba(30, 41, 59, 0.9);
            border-color: #38bdf8;
            box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.15);
        }

        .form-control:focus + .input-icon,
        .input-wrapper:focus-within .input-icon {
            color: #38bdf8;
        }

        /* --- Botón Toggle Password --- */
        .btn-toggle-pw {
            position: absolute;
            right: 12px;
            background: transparent;
            border: none;
            color: #64748b;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: color 0.2s, background 0.2s;
        }

        .btn-toggle-pw:hover {
            color: #38bdf8;
            background: rgba(255, 255, 255, 0.05);
        }

        /* --- Indicador de Caps Lock --- */
        .caps-warning {
            display: none;
            align-items: center;
            gap: 6px;
            font-size: 0.75rem;
            color: #fbbf24;
            margin-top: 6px;
        }

        /* --- Alertas de Error Animadas --- */
        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            padding: 12px;
            border-radius: 10px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            text-align: center;
            animation: shake 0.4s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
        }

        /* --- Botón Submit con Estado de Carga --- */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #0284c7, #0369a1);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(2, 132, 199, 0.45);
            background: linear-gradient(135deg, #0369a1, #0284c7);
        }

        .btn-submit:active {
            transform: translateY(1px);
        }

        .spinner {
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
            display: none;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<!-- Fondo Interactivo -->
<div class="bg-glow glow-1"></div>
<div class="bg-glow glow-2"></div>

<div class="login-card">
    <div class="login-header">
        <div class="brand-icon">💊</div>
        <h1>Farmacia Sys</h1>
        <p>Ingresa tus credenciales para acceder</p>
    </div>

    <?php if (isset($error) && !empty($error)): ?>
        <div class="alert-error">
            ⚠️ <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form id="loginForm" action="index.php?controlador=Auth&accion=login" method="POST">
        <!-- Usuario -->
        <div class="form-group">
            <label for="usuario">Usuario</label>
            <div class="input-wrapper">
                <input type="text" id="usuario" name="usuario" class="form-control" required placeholder="admin@farmacia.com" autocomplete="username">
                <svg class="input-icon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
        </div>

        <!-- Contraseña -->
        <div class="form-group">
            <label for="password">Contraseña</label>
            <div class="input-wrapper">
                <input type="password" id="password" name="password" class="form-control" style="padding-right: 42px;" required placeholder="••••••••" autocomplete="current-password">
                <svg class="input-icon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <button type="button" id="togglePassword" class="btn-toggle-pw" title="Mostrar/Ocultar Contraseña">
                    <svg id="eyeIcon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            <div id="capsWarning" class="caps-warning">
                ⚠️ Bloq Mayús (Caps Lock) está activado
            </div>
        </div>

        <!-- Botón de Ingreso -->
        <button type="submit" id="btnSubmit" class="btn-submit">
            <span id="btnText">Ingresar al Sistema</span>
            <div id="btnSpinner" class="spinner"></div>
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const passwordInput = document.getElementById('password');
    const togglePasswordBtn = document.getElementById('togglePassword');
    const eyeIcon = document.getElementById('eyeIcon');
    const capsWarning = document.getElementById('capsWarning');
    const loginForm = document.getElementById('loginForm');
    const btnSubmit = document.getElementById('btnSubmit');
    const btnText = document.getElementById('btnText');
    const btnSpinner = document.getElementById('btnSpinner');

    // 1. Alternar Visibilidad de Contraseña con SVG
    togglePasswordBtn.addEventListener('click', () => {
        const isPassword = passwordInput.getAttribute('type') === 'password';
        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
        
        if (isPassword) {
            // Ícono de Ojo Tachado (Ocultar)
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.01 10.01 0 012.122-.063c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-1.93-1.93a3 3 0 01-4.243-4.243"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/>
            `;
        } else {
            // Ícono de Ojo Normal (Mostrar)
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
        }
    });

    // 2. Detección en vivo de Bloq Mayús (Caps Lock)
    window.addEventListener('keyup', (e) => {
        if (e.getModifierState && e.getModifierState('CapsLock')) {
            capsWarning.style.display = 'flex';
        } else {
            capsWarning.style.display = 'none';
        }
    });

    // 3. Estado de Carga (Loading Spinner) al Enviar Formulario
    loginForm.addEventListener('submit', () => {
        btnSubmit.disabled = true;
        btnSubmit.style.opacity = '0.85';
        btnSubmit.style.cursor = 'wait';
        btnText.textContent = 'Verificando...';
        btnSpinner.style.display = 'block';
    });
});
</script>

</body>
</html>