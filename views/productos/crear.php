<div class="form-card">
    <h2>➕ Agregar Nuevo Medicamento</h2>
    <form action="index.php?controlador=Producto&accion=crear" method="POST">
        <div class="form-grid">
            <div class="form-group">
                <label>Código de Barras</label>
                <input type="text" name="codigo_barras" placeholder="Ej. 750123456789">
            </div>

            <div class="form-group">
                <label>Nombre del Medicamento *</label>
                <input type="text" name="nombre" required placeholder="Ej. Amoxicilina 500mg">
            </div>

            <div class="form-group full-width">
                <label>Descripción / Presentación</label>
                <input type="text" name="descripcion" placeholder="Ej. Caja con 12 cápsulas">
            </div>

            <div class="form-group">
                <label>Precio de Compra ($) *</label>
                <input type="number" step="0.01" name="precio_compra" required value="0.00">
            </div>

            <div class="form-group">
                <label>Precio de Venta ($) *</label>
                <input type="number" step="0.01" name="precio_venta" required value="0.00">
            </div>

            <div class="form-group">
                <label>Stock Inicial *</label>
                <input type="number" name="stock_actual" required value="10">
            </div>

            <div class="form-group">
                <label>Stock Mínimo (Alerta) *</label>
                <input type="number" name="stock_minimo" required value="5">
            </div>

            <div class="form-group">
                <label>Fecha de Vencimiento</label>
                <input type="date" name="fecha_vencimiento">
            </div>
        </div>

        <div class="form-actions">
            <a href="index.php?controlador=Producto&accion=index" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary">Guardar Medicamento</button>
        </div>
    </form>
</div>

<style>
.form-card {
    background: white;
    padding: 28px;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    max-width: 700px;
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