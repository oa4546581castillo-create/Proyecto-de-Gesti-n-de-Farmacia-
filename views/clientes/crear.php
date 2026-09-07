<div class="form-card">
    <h2>👤 Nuevo Cliente</h2>
    <form action="index.php?controlador=Cliente&accion=crear" method="POST">
        <div class="form-grid">
            <div class="form-group">
                <label>Nombre Completo *</label>
                <input type="text" name="nombre" required placeholder="Ej. Juan Pérez">
            </div>

            <div class="form-group">
                <label>Identificación / Documento</label>
                <input type="text" name="documento" placeholder="Ej. 12345678-9">
            </div>

            <div class="form-group">
                <label>Teléfono</label>
                <input type="text" name="telefono" placeholder="Ej. 555-0192">
            </div>

            <div class="form-group">
                <label>Correo Electrónico</label>
                <input type="email" name="email" placeholder="cliente@correo.com">
            </div>

            <div class="form-group full-width">
                <label>Dirección</label>
                <input type="text" name="direccion" placeholder="Ej. Av. Principal #123">
            </div>
        </div>

        <div class="form-actions">
            <a href="index.php?controlador=Cliente&accion=index" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary">Guardar Cliente</button>
        </div>
    </form>
</div>

<style>
.form-card {
    background: white;
    padding: 28px;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    max-width: 650px;
    margin: 0 auto;
}
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.full-width { grid-column: span 2; }
.form-group label {
    display: block;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 6px;
    color: #334155;
}
.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    box-sizing: border-box;
}
.form-actions {
    margin-top: 24px;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}
.btn-secondary {
    padding: 10px 18px;
    background: #e2e8f0;
    color: #475569;
    border-radius: 8px;
    text-decoration: none;
}
</style>