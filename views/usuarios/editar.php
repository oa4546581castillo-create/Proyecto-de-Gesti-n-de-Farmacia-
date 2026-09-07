<div class="form-card">
    <h2>✏️ Editar Usuario</h2>
    <form action="index.php?controlador=Usuario&accion=editar&id=<?= $usuario['id_usuario'] ?>" method="POST">
        <div class="form-grid">
            <div class="form-group full-width">
                <label>Nombre Completo *</label>
                <input type="text" name="nombre" required value="<?= htmlspecialchars($usuario['nombre']) ?>">
            </div>

            <div class="form-group">
                <label>Correo Electrónico *</label>
                <input type="email" name="email" required value="<?= htmlspecialchars($usuario['email']) ?>">
            </div>

            <div class="form-group">
                <label>Rol del Sistema *</label>
                <select name="rol" required>
                    <option value="cajero" <?= $usuario['rol'] === 'cajero' ? 'selected' : '' ?>>Cajero</option>
                    <option value="farmaceutico" <?= $usuario['rol'] === 'farmaceutico' ? 'selected' : '' ?>>Farmacéutico</option>
                    <option value="admin" <?= $usuario['rol'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
                </select>
            </div>

            <div class="form-group full-width">
                <label>Nueva Contraseña (Dejar en blanco para conservar la actual)</label>
                <input type="password" name="password" placeholder="••••••••">
            </div>
        </div>

        <div class="form-actions">
            <a href="index.php?controlador=Usuario&accion=index" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary">Actualizar Usuario</button>
        </div>
    </form>
</div>