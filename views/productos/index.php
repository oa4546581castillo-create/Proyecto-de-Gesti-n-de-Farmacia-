<div class="module-header">
    <h2>📦 Catálogo de Medicamentos</h2>
    <a href="index.php?controlador=Producto&accion=crear" class="btn-primary">+ Nuevo Medicamento</a>
</div>

<div class="table-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>P. Compra</th>
                <th>P. Venta</th>
                <th>Stock</th>
                <th>Vencimiento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($productos)): ?>
                <tr>
                    <td colspan="7" style="text-align: center; color: #94a3b8;">No hay medicamentos registrados.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($productos as $p): ?>
                    <tr>
                        <td><code><?= htmlspecialchars($p['codigo_barras'] ?: 'N/A') ?></code></td>
                        <td>
                            <strong><?= htmlspecialchars($p['nombre']) ?></strong>
                            <?php if (!empty($p['descripcion'])): ?>
                                <br><small style="color: #64748b;"><?= htmlspecialchars($p['descripcion']) ?></small>
                            <?php endif; ?>
                        </td>
                        <td>$<?= number_format($p['precio_compra'], 2) ?></td>
                        <td><strong>$<?= number_format($p['precio_venta'], 2) ?></strong></td>
                        <td>
                            <?php if ($p['stock_actual'] <= $p['stock_minimo']): ?>
                                <span class="badge badge-danger"><?= $p['stock_actual'] ?> (Bajo)</span>
                            <?php else: ?>
                                <span class="badge badge-success"><?= $p['stock_actual'] ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?= $p['fecha_vencimiento'] ? date('d/m/Y', strtotime($p['fecha_vencimiento'])) : 'Sin fecha' ?></td>
                        <td class="action-buttons">
                            <a href="index.php?controlador=Producto&accion=editar&id=<?= $p['id_producto'] ?>" class="btn-sm btn-edit">✏️ Editar</a>
                            <a href="index.php?controlador=Producto&accion=eliminar&id=<?= $p['id_producto'] ?>" class="btn-sm btn-delete" onclick="return confirm('¿Eliminar este producto?')">🗑️</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<style>
.module-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.btn-primary {
    background: #0284c7;
    color: white;
    padding: 10px 18px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
}
.table-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
}
.data-table {
    width: 100%;
    border-collapse: collapse;
}
.data-table th, .data-table td {
    padding: 14px;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
}
.data-table th {
    background: #f8fafc;
    color: #475569;
    font-size: 0.85rem;
    text-transform: uppercase;
}
.badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
}
.badge-success { background: #dcfce7; color: #166534; }
.badge-danger { background: #fee2e2; color: #991b1b; }
.btn-sm {
    padding: 6px 10px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.85rem;
}
.btn-edit { background: #f0f9ff; color: #0284c7; }
.btn-delete { background: #fef2f2; color: #ef4444; }
</style>