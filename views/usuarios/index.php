<div class="module-header">
    <h2>👥 Control de Usuarios y Roles</h2>
    <a href="index.php?controlador=Usuario&accion=crear" class="btn-primary">+ Nuevo Usuario</a>
</div>

<div class="table-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo Electrónico</th>
                <th>Rol</th>
                <th>Fecha Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><code>#<?= $u['id_usuario'] ?></code></td>
                    <td><strong><?= htmlspecialchars($u['nombre']) ?></strong></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td>
                        <?php if ($u['rol'] === 'admin'): ?>
                            <span class="badge badge-admin">Administrador</span>
                        <?php elseif ($u['rol'] === 'farmaceutico'): ?>
                            <span class="badge badge-pharma">Farmacéutico</span>
                        <?php else: ?>
                            <span class="badge badge-cashier">Cajero</span>
                        <?php endif; ?>
                    </td>
                    <td><?= date('d/m/Y', strtotime($u['fecha_registro'])) ?></td>
                    <td class="action-buttons">
                        <a href="index.php?controlador=Usuario&accion=editar&id=<?= $u['id_usuario'] ?>" class="btn-sm btn-edit">✏️ Editar</a>
                        <?php if ($u['id_usuario'] != $_SESSION['id_usuario']): ?>
                            <a href="index.php?controlador=Usuario&accion=eliminar&id=<?= $u['id_usuario'] ?>" class="btn-sm btn-delete" onclick="return confirm('¿Eliminar este usuario?')">🗑️</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
.module-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.btn-primary { background: #0284c7; color: white; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: 600; }
.table-card { background: white; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
.data-table { width: 100%; border-collapse: collapse; }
.data-table th, .data-table td { padding: 14px; text-align: left; border-bottom: 1px solid #e2e8f0; }
.data-table th { background: #f8fafc; color: #475569; font-size: 0.85rem; text-transform: uppercase; }
.badge { padding: 4px 10px; border-radius: 12px; font-size: 0.8rem; font-weight: 600; }
.badge-admin { background: #fef3c7; color: #92400e; }
.badge-pharma { background: #e0e7ff; color: #3730a3; }
.badge-cashier { background: #dcfce7; color: #166534; }
.btn-sm { padding: 6px 10px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; }
.btn-edit { background: #f0f9ff; color: #0284c7; }
.btn-delete { background: #fef2f2; color: #ef4444; }
</style>