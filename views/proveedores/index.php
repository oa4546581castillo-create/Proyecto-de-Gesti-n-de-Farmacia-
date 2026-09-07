<div class="module-header">
    <h2>🏭 Directorio de Proveedores y Laboratorios</h2>
    <a href="index.php?controlador=Proveedor&accion=crear" class="btn-primary">+ Registrar Proveedor</a>
</div>

<div class="table-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Empresa / Laboratorio</th>
                <th>Persona de Contacto</th>
                <th>Teléfono</th>
                <th>Correo Electrónico</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($proveedores)): ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: #94a3b8;">No hay proveedores registrados.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($proveedores as $p): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($p['nombre']) ?></strong></td>
                        <td><?= htmlspecialchars($p['contacto'] ?: 'N/A') ?></td>
                        <td><?= htmlspecialchars($p['telefono'] ?: 'N/A') ?></td>
                        <td><?= htmlspecialchars($p['email'] ?: 'N/A') ?></td>
                        <td><?= htmlspecialchars($p['direccion'] ?: 'N/A') ?></td>
                        <td class="action-buttons">
                            <a href="index.php?controlador=Proveedor&accion=editar&id=<?= $p['id_proveedor'] ?>" class="btn-sm btn-edit">✏️ Editar</a>
                            <a href="index.php?controlador=Proveedor&accion=eliminar&id=<?= $p['id_proveedor'] ?>" class="btn-sm btn-delete" onclick="return confirm('¿Deseas eliminar este proveedor?')">🗑️</a>
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
.btn-sm {
    padding: 6px 10px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.85rem;
}
.btn-edit { background: #f0f9ff; color: #0284c7; }
.btn-delete { background: #fef2f2; color: #ef4444; }
</style>