<div class="form-card">
    <h2>➕ Registrar Usuario</h2>
    <form action="index.php?controlador=Usuario&accion=crear" method="POST">
        <div class="form-grid">
            <div class="form-group full-width">
                <label>Nombre Completo *</label>
                <input type="text" name="nombre" required placeholder="Ej. Ana Martínez">
            </div>

            <div class="form-group">
                <label>Correo Electrónico *</label>
                <input type="email" name="email" required placeholder="usuario@farmacia.com">
            </div>

            <div class="form-group">
                <label>Rol del Sistema *</label>
                <select name="rol" required>
                    <option value="cajero">Cajero (Solo POS y ventas)</option>
                    <option value="farmaceutico">Farmacéutico (POS e Inventario)</option>
                    <option value="admin">Administrador (Acceso total)</option>
                </select>
            </div>

            <div class="form-group full-width">
                <label>Contraseña *</label>
                <input type="password" name="password" required placeholder="Mínimo 6 caracteres">
            </div>
        </div>

        <div class="form-actions">
            <a href="index.php?controlador=Usuario&accion=index" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary">Guardar Usuario</button>
        </div>
    </form>
</div>

<style>
.form-card { background: white; padding: 28px; border-radius: 12px; border: 1px solid #e2e8f0; max-width: 600px; margin: 0 auto; }
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.full-width { grid-column: span 2; }
.form-group label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155; }
.form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; }
.form-actions { margin-top: 24px; display: flex; justify-content: flex-end; gap: 12px; }
.btn-secondary { padding: 10px 18px; background: #e2e8f0; color: #475569; border-radius: 8px; text-decoration: none; }
</style>