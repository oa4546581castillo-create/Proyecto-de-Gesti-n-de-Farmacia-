<div class="report-header">
    <h2>📜 Historial y Reportes de Ventas</h2>
</div>

<!-- Filtros de fecha y resumen -->
<div class="report-grid">
    <div class="filter-card">
        <form action="index.php" method="GET" class="filter-form">
            <input type="hidden" name="controlador" value="Venta">
            <input type="hidden" name="accion" value="historial">

            <div class="form-group">
                <label>Desde:</label>
                <input type="date" name="fecha_inicio" value="<?= htmlspecialchars($fechaInicio) ?>" required>
            </div>

            <div class="form-group">
                <label>Hasta:</label>
                <input type="date" name="fecha_fin" value="<?= htmlspecialchars($fechaFin) ?>" required>
            </div>

            <button type="submit" class="btn-filter">🔍 Filtrar</button>
        </form>
    </div>

    <div class="metrics-summary">
        <div class="metric-box">
            <small>Total Recaudado</small>
            <strong>$<?= number_format($totalIngresos, 2) ?></strong>
        </div>
        <div class="metric-box">
            <small>Transacciones</small>
            <strong><?= count($ventas) ?></strong>
        </div>
    </div>
</div>

<!-- Tabla de Historial -->
<div class="table-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Folio</th>
                <th>Fecha y Hora</th>
                <th>Cajero</th>
                <th>Cliente</th>
                <th>Total ($)</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($ventas)): ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: #94a3b8;">No se registraron ventas en este rango de fechas.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($ventas as $v): ?>
                    <tr>
                        <td><code>#<?= str_pad($v['id_venta'], 5, '0', STR_PAD_LEFT) ?></code></td>
                        <td><?= date('d/m/Y H:i A', strtotime($v['fecha_venta'])) ?></td>
                        <td><?= htmlspecialchars($v['cajero']) ?></td>
                        <td><?= htmlspecialchars($v['cliente']) ?></td>
                        <td><strong>$<?= number_format($v['total'], 2) ?></strong></td>
                        <td>
                            <button class="btn-sm btn-detail" onclick="verDetalle(<?= $v['id_venta'] ?>)">👁️ Ver Detalle</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal de Detalle de Venta -->
<div id="modal-detalle" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Desglose de la Venta <span id="modal-folio"></span></h3>
            <button onclick="cerrarModal()" class="btn-close">&times;</button>
        </div>
        <div class="modal-body">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio U.</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody id="modal-table-body">
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.report-header { margin-bottom: 20px; }
.report-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}
.filter-card, .metrics-summary {
    background: white;
    padding: 20px;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
}
.filter-form {
    display: flex;
    gap: 15px;
    align-items: flex-end;
}
.filter-form .form-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
}
.filter-form input[type="date"] {
    padding: 8px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
}
.btn-filter {
    background: #0284c7;
    color: white;
    border: none;
    padding: 9px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
}
.metrics-summary {
    display: flex;
    justify-content: space-around;
    align-items: center;
}
.metric-box { text-align: center; }
.metric-box small { color: #64748b; font-size: 0.85rem; display: block; }
.metric-box strong { font-size: 1.4rem; color: #0f172a; }
.table-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
}
.data-table { width: 100%; border-collapse: collapse; }
.data-table th, .data-table td { padding: 12px 16px; text-align: left; border-bottom: 1px solid #e2e8f0; }
.data-table th { background: #f8fafc; color: #475569; font-size: 0.85rem; }
.btn-detail { background: #f0f9ff; color: #0284c7; border: 1px solid #bae6fd; cursor: pointer; }

/* Modal */
.modal {
    display: none;
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(15, 23, 42, 0.5);
    z-index: 2000;
    align-items: center;
    justify-content: center;
}
.modal-content {
    background: white;
    border-radius: 12px;
    width: 90%;
    max-width: 600px;
    padding: 20px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}
.modal-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px; }
.btn-close { background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #64748b; }
</style>

<script>
function verDetalle(idVenta) {
    document.getElementById('modal-folio').innerText = '#' + String(idVenta).padStart(5, '0');
    
    fetch(`index.php?controlador=Venta&accion=obtenerDetalle&id=${idVenta}`)
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('modal-table-body');
            tbody.innerHTML = '';
            
            data.forEach(item => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${item.producto}</td>
                    <td>$${parseFloat(item.precio_unitario).toFixed(2)}</td>
                    <td>${item.cantidad}</td>
                    <td><strong>$${parseFloat(item.subtotal).toFixed(2)}</strong></td>
                `;
                tbody.appendChild(tr);
            });

            document.getElementById('modal-detalle').style.display = 'flex';
        });
}

function cerrarModal() {
    document.getElementById('modal-detalle').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('modal-detalle');
    if (event.target === modal) {
        cerrarModal();
    }
}
</script>