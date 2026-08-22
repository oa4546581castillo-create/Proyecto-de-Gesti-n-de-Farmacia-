<div class="welcome-banner">
    <h1>¡Bienvenido/a, <?= htmlspecialchars($_SESSION['nombre'] ?? 'Usuario') ?>! 👋</h1>
    <p>Resumen general y métricas del estado de la farmacia en tiempo real.</p>
</div>

<div class="cards-grid">
    <!-- Tarjeta 1: Ventas del día -->
    <div class="card card-blue">
        <div class="card-icon">💵</div>
        <div class="card-info">
            <h3>Ventas de Hoy</h3>
            <p class="card-value">$<?= number_format($ventasHoy, 2) ?></p>
        </div>
    </div>

    <!-- Tarjeta 2: Stock bajo -->
    <div class="card card-red">
        <div class="card-icon">⚠️</div>
        <div class="card-info">
            <h3>Stock Bajo</h3>
            <p class="card-value"><?= $stockBajo ?> <span class="card-unit">productos</span></p>
        </div>
    </div>

    <!-- Tarjeta 3: Próximos a vencer -->
    <div class="card card-orange">
        <div class="card-icon">⏳</div>
        <div class="card-info">
            <h3>Próximos a Vencer</h3>
            <p class="card-value"><?= $porVencer ?> <span class="card-unit">medicamentos</span></p>
        </div>
    </div>
</div>

<style>
.welcome-banner {
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e2e8f0;
}
.welcome-banner h1 {
    color: #0f172a;
    font-size: 1.8rem;
    margin-bottom: 5px;
}
.welcome-banner p {
    color: #64748b;
    margin: 0;
}
.cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 20px;
}
.card {
    background: #ffffff;
    border-radius: 12px;
    padding: 24px;
    display: flex;
    align-items: center;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}
.card-icon {
    font-size: 2.2rem;
    margin-right: 20px;
    padding: 12px;
    border-radius: 10px;
    background: #f8fafc;
}
.card-info h3 {
    font-size: 0.85rem;
    color: #64748b;
    margin: 0 0 6px 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.card-value {
    font-size: 1.8rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
}
.card-unit {
    font-size: 0.9rem;
    font-weight: 400;
    color: #64748b;
}
.card-blue { border-left: 6px solid #0284c7; }
.card-red { border-left: 6px solid #ef4444; }
.card-orange { border-left: 6px solid #f59e0b; }
</style>