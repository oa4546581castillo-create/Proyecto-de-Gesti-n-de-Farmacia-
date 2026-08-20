<h1>Gestión de Medicamentos e Inventario</h1>

<table class="data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Cód. Barras</th>
            <th>Nombre</th>
            <th>Precio Compra</th>
            <th>Precio Venta</th>
            <th>Stock Actual</th>
            <th>Stock Mínimo</th>
            <th>Vencimiento</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $p): 
                $hoy = date('Y-m-d');
                $proximoVencer = date('Y-m-d', strtotime('+30 days'));
                $alertaStock = ($p['stock_actual'] <= $p['stock_minimo']);
                $alertaVencido = ($p['fecha_vencimiento'] <= $hoy);
                $alertaProximo = ($p['fecha_vencimiento'] <= $proximoVencer && !$alertaVencido);
            ?>
            <tr class="<?= $alertaStock || $alertaVencido ? 'row-alert' : '' ?>">
                <td><?= $p['id_producto'] ?></td>
                <td><?= htmlspecialchars($p['codigo_barras'] ?? 'N/A') ?></td>
                <td><strong><?= htmlspecialchars($p['nombre']) ?></strong></td>
                <td>$<?= number_format($p['precio_compra'], 2) ?></td>
                <td>$<?= number_format($p['precio_venta'], 2) ?></td>
                <td>
                    <span class="badge <?= $alertaStock ? 'bg-danger' : 'bg-success' ?>">
                        <?= $p['stock_actual'] ?>
                    </span>
                </td>
                <td><?= $p['stock_minimo'] ?></td>
                <td><?= $p['fecha_vencimiento'] ?></td>
                <td>
                    <?php if ($alertaVencido): ?>
                        <span class="text-danger">¡VENCIDO!</span>
                    <?php elseif ($alertaProximo): ?>
                        <span class="text-warning">Próximo a vencer</span>
                    <?php elseif ($alertaStock): ?>
                        <span class="text-danger">Stock Bajo</span>
                    <?php else: ?>
                        <span class="text-success">Disponible</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="9" style="text-align:center;">No hay medicamentos registrados en el sistema.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>