<div class="form-card">
    <h2>✏️ Editar Medicamento</h2>
    <form action="index.php?controlador=Producto&accion=editar&id=<?= $producto['id_producto'] ?>" method="POST">
        <div class="form-grid">
            <div class="form-group">
                <label>Código de Barras</label>
                <input type="text" name="codigo_barras" value="<?= htmlspecialchars($producto['codigo_barras']) ?>">
            </div>

            <div class="form-group">
                <label>Nombre del Medicamento *</label>
                <input type="text" name="nombre" required value="<?= htmlspecialchars($producto['nombre']) ?>">
            </div>

            <div class="form-group full-width">
                <label>Descripción / Presentación</label>
                <input type="text" name="descripcion" value="<?= htmlspecialchars($producto['descripcion']) ?>">
            </div>

            <div class="form-group">
                <label>Precio de Compra ($) *</label>
                <input type="number" step="0.01" name="precio_compra" required value="<?= $producto['precio_compra'] ?>">
            </div>

            <div class="form-group">
                <label>Precio de Venta ($) *</label>
                <input type="number" step="0.01" name="precio_venta" required value="<?= $producto['precio_venta'] ?>">
            </div>

            <div class="form-group">
                <label>Stock Actual *</label>
                <input type="number" name="stock_actual" required value="<?= $producto['stock_actual'] ?>">
            </div>

            <div class="form-group">
                <label>Stock Mínimo (Alerta) *</label>
                <input type="number" name="stock_minimo" required value="<?= $producto['stock_minimo'] ?>">
            </div>

            <div class="form-group">
                <label>Fecha de Vencimiento</label>
                <input type="date" name="fecha_vencimiento" value="<?= $producto['fecha_vencimiento'] ?>">
            </div>
        </div>

        <div class="form-actions">
            <a href="index.php?controlador=Producto&accion=index" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary">Actualizar Cambios</button>
        </div>
    </form>
</div>