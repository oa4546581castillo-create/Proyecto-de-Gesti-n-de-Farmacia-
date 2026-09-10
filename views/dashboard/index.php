<!-- Cargar librería de Gráficos (Chart.js) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="welcome-banner">
    <h1>¡Bienvenido/a, <?= htmlspecialchars($_SESSION['nombre'] ?? 'Usuario') ?>! 👋</h1>
    <p>Resumen general y métricas del estado de la farmacia en tiempo real.</p>
</div>

<!-- Contenedor de Gráficos -->
<div class="charts-grid">
    <!-- Gráfico 1: Ventas del Día -->
    <div class="chart-card">
        <div class="chart-header">
            <div>
                <h3>💵 Ventas de Hoy</h3>
                <p>Ingresos generados en la jornada</p>
            </div>
            <div class="chart-badge badge-blue">
                $<?= number_format($ventasHoy, 2) ?>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="chartVentas"></canvas>
        </div>
    </div>

    <!-- Gráfico 2: Alertas de Inventario -->
    <div class="chart-card">
        <div class="chart-header">
            <div>
                <h3>⚠️ Estado del Inventario</h3>
                <p>Proporción de alertas de stock y vencimiento</p>
            </div>
            <div class="chart-badge badge-orange">
                <?= $stockBajo + $porVencer ?> Alertas
            </div>
        </div>
        <div class="chart-container">
            <canvas id="chartAlertas"></canvas>
        </div>
    </div>
</div>

<!-- Widget del Asistente IA -->
<div class="ia-card">
    <div class="ia-header">
        <div class="ia-title-group">
            <span class="ia-icon">🤖</span>
            <div>
                <h3>Asistente IA de la Farmacia</h3>
                <p>Consulta métricas, productos con stock bajo o ventas en tiempo real</p>
            </div>
        </div>
    </div>
    <div class="ia-body">
        <div class="ia-input-wrapper">
            <input type="text" id="iaPregunta" placeholder="Ej: ¿Qué medicamentos están agotándose?" onkeypress="validarEnterIA(event)">
            <button type="button" id="btnPreguntarIA" onclick="enviarConsultaIA()">Consultar</button>
        </div>
        <div id="iaRespuesta" class="ia-response-card" style="display: none;">
            <p id="iaTextoRespuesta"></p>
        </div>
    </div>
</div>

<style>
/* Banner de Bienvenida */
.welcome-banner {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 24px 28px;
    margin-bottom: 28px;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03);
    position: relative;
    overflow: hidden;
}

.welcome-banner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 6px;
    height: 100%;
    background: linear-gradient(180deg, #0284c7 0%, #3b82f6 100%);
}

.welcome-banner h1 {
    color: #0f172a;
    font-size: 1.85rem;
    font-weight: 700;
    margin: 0 0 6px 0;
    letter-spacing: -0.02em;
}

.welcome-banner p {
    color: #64748b;
    font-size: 0.98rem;
    margin: 0;
}

/* Grid de Gráficos */
.charts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
    gap: 24px;
}

/* Tarjeta del Gráfico */
.chart-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 24px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    display: flex;
    flex-direction: column;
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
}

.chart-header h3 {
    font-size: 1.1rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.chart-header p {
    font-size: 0.85rem;
    color: #64748b;
    margin: 0;
}

/* Badges / Etiquetas destacadas */
.chart-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.95rem;
    font-weight: 700;
}

.badge-blue {
    background: #e0f2fe;
    color: #0369a1;
}

.badge-orange {
    background: #fef3c7;
    color: #b45309;
}

/* Contenedor responsivo del Canvas */
.chart-container {
    position: relative;
    height: 240px;
    width: 100%;
}

/* Estilos de la Tarjeta Asistente IA */
.ia-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 24px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    margin-top: 24px;
}

.ia-title-group {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
}

.ia-icon {
    font-size: 1.8rem;
}

.ia-title-group h3 {
    font-size: 1.1rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 2px 0;
}

.ia-title-group p {
    font-size: 0.85rem;
    color: #64748b;
    margin: 0;
}

.ia-input-wrapper {
    display: flex;
    gap: 10px;
}

.ia-input-wrapper input {
    flex: 1;
    padding: 12px 16px;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    font-size: 0.95rem;
    outline: none;
    transition: border-color 0.2s;
}

.ia-input-wrapper input:focus {
    border-color: #0284c7;
}

.ia-input-wrapper button {
    background: #0284c7;
    color: #ffffff;
    border: none;
    padding: 12px 24px;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
}

.ia-input-wrapper button:hover {
    background: #0369a1;
}

.ia-input-wrapper button:disabled {
    background: #94a3b8;
    cursor: not-allowed;
}

.ia-response-card {
    margin-top: 16px;
    padding: 14px 18px;
    background-color: #f0f9ff;
    border-left: 4px solid #0284c7;
    border-radius: 8px;
}

.ia-response-card p {
    margin: 0;
    color: #0c4a6e;
    font-size: 0.95rem;
    line-height: 1.5;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Gráfico de Barras: Ventas del Día
    const ctxVentas = document.getElementById('chartVentas').getContext('2d');
    new Chart(ctxVentas, {
        type: 'bar',
        data: {
            labels: ['Monto Total ($)'],
            datasets: [{
                label: 'Ventas de Hoy',
                data: [<?= (float)$ventasHoy ?>],
                backgroundColor: 'rgba(2, 132, 199, 0.85)',
                borderColor: '#0284c7',
                borderWidth: 2,
                borderRadius: 8,
                barThickness: 50
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        callback: function(value) { return '$' + value; }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // 2. Gráfico de Dona: Stock Bajo vs. Próximos a Vencer
    const ctxAlertas = document.getElementById('chartAlertas').getContext('2d');
    new Chart(ctxAlertas, {
        type: 'doughnut',
        data: {
            labels: ['Stock Bajo', 'Próximos a Vencer'],
            datasets: [{
                data: [<?= (int)$stockBajo ?>, <?= (int)$porVencer ?>],
                backgroundColor: ['#ef4444', '#f59e0b'],
                hoverOffset: 6,
                borderWidth: 3,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: { size: 12, weight: '500' },
                        usePointStyle: true
                    }
                }
            },
            cutout: '65%'
        }
    });
});

// Funciones del Asistente IA
function validarEnterIA(event) {
    if (event.key === 'Enter') {
        enviarConsultaIA();
    }
}

function enviarConsultaIA() {
    const input = document.getElementById('iaPregunta');
    const btn = document.getElementById('btnPreguntarIA');
    const responseBox = document.getElementById('iaRespuesta');
    const textResponse = document.getElementById('iaTextoRespuesta');
    const pregunta = input.value.trim();

    if (!pregunta) return;

    btn.disabled = true;
    btn.textContent = 'Pensando...';
    responseBox.style.display = 'block';
    textResponse.textContent = 'Consultando la base de datos...';

    fetch('index.php?controlador=Dashboard&accion=consultarAsistente', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ pregunta: pregunta })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            textResponse.textContent = data.respuesta;
        } else {
            textResponse.textContent = '⚠️ ' + (data.error || 'Ocurrió un error al procesar la respuesta.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        textResponse.textContent = '⚠️ Error al conectar con el servidor.';
    })
    .finally(() => {
        btn.disabled = false;
        btn.textContent = 'Consultar';
    });
}
</script>