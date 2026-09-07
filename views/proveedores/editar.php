<div class="form-card">
    <h2>✏️ Editar Proveedor</h2>
    <form action="index.php?controlador=Proveedor&accion=editar&id=<?= $proveedor['id_proveedor'] ?>" method="POST">
        <div class="form-grid">
            <div class="form-group">
                <label>Nombre de la Empresa / Laboratorio *</label>
                <input type="text" name="nombre" required value="<?= htmlspecialchars($proveedor['nombre']) ?>">
            </div>

            <div class="form-group">
                <label>Persona de Contacto</label>
                <input type="text" name="contacto" value="<?= htmlspecialchars($proveedor['contacto']) ?>">
            </div>

            <div class="form-group">
                <label>Teléfono de Contacto</label>
                <input type="text" name="telefono" value="<?= htmlspecialchars($proveedor['telefono']) ?>">
            </div>

            <div class="form-group">
                <label>Correo Electrónico</label>
                <input type="email" name="email" value="<?= htmlspecialchars($proveedor['email']) ?>">
            </div>

            <div class="form-group full-width">
                <label>Dirección Física</label>
                <input type="text" name="direccion" value="<?= htmlspecialchars($proveedor['direccion']) ?>">
            </div>
        </div>

        <div class="form-actions">
            <a href="index.php?controlador=Proveedor&accion=index" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary">Actualizar Cambios</button>
        </div>
    </form>
</div>