<div class="form-card">
    <h2>✏️ Editar Cliente</h2>
    <form action="index.php?controlador=Cliente&accion=editar&id=<?= $cliente['id_cliente'] ?>" method="POST">
        <div class="form-grid">
            <div class="form-group">
                <label>Nombre Completo *</label>
                <input type="text" name="nombre" required value="<?= htmlspecialchars($cliente['nombre']) ?>">
            </div>

            <div class="form-group">
                <label>Identificación / Documento</label>
                <input type="text" name="documento" value="<?= htmlspecialchars($cliente['documento']) ?>">
            </div>

            <div class="form-group">
                <label>Teléfono</label>
                <input type="text" name="telefono" value="<?= htmlspecialchars($cliente['telefono']) ?>">
            </div>

            <div class="form-group">
                <label>Correo Electrónico</label>
                <input type="email" name="email" value="<?= htmlspecialchars($cliente['email']) ?>">
            </div>

            <div class="form-group full-width">
                <label>Dirección</label>
                <input type="text" name="direccion" value="<?= htmlspecialchars($cliente['direccion']) ?>">
            </div>
        </div>

        <div class="form-actions">
            <a href="index.php?controlador=Cliente&accion=index" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary">Actualizar Datos</button>
        </div>
    </form>
</div>