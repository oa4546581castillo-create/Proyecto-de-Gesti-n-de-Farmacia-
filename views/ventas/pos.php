<div class="pos-container">
    <!-- Panel Izquierdo: Buscador y selección de productos -->
    <div class="pos-search-panel">
        <h2>🔍 Buscar Medicamento</h2>
        <input type="text" id="buscar-producto" placeholder="Escribe el nombre o código de barras..." autocomplete="off">
        <div id="resultados-busqueda" class="results-list"></div>
    </div>

    <!-- Panel Derecho: Carrito de compras y cobro -->
    <div class="pos-cart-panel">
        <h2>🛒 Carrito de Compras</h2>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cant.</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="carrito-body">
                <tr>
                    <td colspan="5" style="text-align: center; color: #94a3b8;">No hay productos agregados</td>
                </tr>
            </tbody>
        </table>

        <div class="cart-summary">
            <div class="summary-total">
                <span>TOTAL:</span>
                <strong id="total-pagar">$0.00</strong>
            </div>

            <button id="btn-finalizar-venta" class="btn-checkout" onclick="procesarVenta()">Completar Venta</button>
        </div>
    </div>
</div>

<style>
.pos-container {
    display: grid;
    grid-template-columns: 1fr 1.5fr;
    gap: 25px;
    margin-top: 10px;
}
.pos-search-panel, .pos-cart-panel {
    background: #ffffff;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
}
.pos-search-panel h2, .pos-cart-panel h2 {
    font-size: 1.2rem;
    color: #0f172a;
    margin-top: 0;
    margin-bottom: 15px;
}
#buscar-producto {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
    box-sizing: border-box;
    outline: none;
}
#buscar-producto:focus {
    border-color: #0284c7;
}
.results-list {
    margin-top: 15px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    max-height: 400px;
    overflow-y: auto;
}
.product-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.2s;
}
.product-item:hover {
    background: #f0f9ff;
    border-color: #38bdf8;
}
.cart-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}
.cart-table th, .cart-table td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
    font-size: 0.95rem;
}
.cart-table input[type="number"] {
    width: 60px;
    padding: 5px;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    text-align: center;
}
.cart-summary {
    background: #f8fafc;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}
.summary-total {
    display: flex;
    justify-content: space-between;
    font-size: 1.4rem;
    font-weight: bold;
    color: #0f172a;
    margin-bottom: 15px;
}
.btn-checkout {
    width: 100%;
    padding: 14px;
    background: #10b981;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.2s;
}
.btn-checkout:hover {
    background: #059669;
}
.btn-remove {
    background: #ef4444;
    color: white;
    border: none;
    padding: 4px 8px;
    border-radius: 4px;
    cursor: pointer;
}
</style>

<script>
let carrito = [];

// Búsqueda en tiempo real mediante teclado
document.getElementById('buscar-producto').addEventListener('input', function(e) {
    const q = e.target.value.trim();
    const contenedor = document.getElementById('resultados-busqueda');

    if (q.length === 0) {
        contenedor.innerHTML = '';
        return;
    }

    fetch(`index.php?controlador=Venta&accion=buscarProducto&q=${encodeURIComponent(q)}`)
        .then(res => res.json())
        .then(data => {
            contenedor.innerHTML = '';
            if (data.length === 0) {
                contenedor.innerHTML = '<div style="color: #64748b; padding: 10px;">No se encontraron productos.</div>';
                return;
            }
            data.forEach(p => {
                const item = document.createElement('div');
                item.className = 'product-item';
                item.innerHTML = `
                    <div>
                        <strong>${p.nombre}</strong><br>
                        <small style="color:#64748b;">Stock: ${p.stock_actual}</small>
                    </div>
                    <div>
                        <strong>$${parseFloat(p.precio_venta).toFixed(2)}</strong>
                    </div>
                `;
                item.onclick = () => agregarAlCarrito(p);
                contenedor.appendChild(item);
            });
        });
});

function agregarAlCarrito(producto) {
    const existe = carrito.find(item => item.id_producto === producto.id_producto);
    if (existe) {
        if (existe.cantidad < producto.stock_actual) {
            existe.cantidad++;
            existe.subtotal = existe.cantidad * existe.precio;
        } else {
            alert('Has alcanzado el límite del stock disponible.');
        }
    } else {
        carrito.push({
            id_producto: producto.id_producto,
            nombre: producto.nombre,
            precio: parseFloat(producto.precio_venta),
            cantidad: 1,
            stock: producto.stock_actual,
            subtotal: parseFloat(producto.precio_venta)
        });
    }
    renderizarCarrito();
}

function cambiarCantidad(id_producto, nuevaCantidad) {
    const item = carrito.find(i => i.id_producto === id_producto);
    if (item) {
        let cant = parseInt(nuevaCantidad);
        if (cant <= 0) {
            eliminarDelCarrito(id_producto);
            return;
        }
        if (cant > item.stock) {
            alert('La cantidad supera el stock disponible.');
            item.cantidad = item.stock;
        } else {
            item.cantidad = cant;
        }
        item.subtotal = item.cantidad * item.precio;
    }
    renderizarCarrito();
}

function eliminarDelCarrito(id_producto) {
    carrito = carrito.filter(item => item.id_producto !== id_producto);
    renderizarCarrito();
}

function renderizarCarrito() {
    const tbody = document.getElementById('carrito-body');
    tbody.innerHTML = '';

    if (carrito.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" style="text-align: center; color: #94a3b8;">No hay productos agregados</td></tr>';
        document.getElementById('total-pagar').innerText = '$0.00';
        return;
    }

    let total = 0;
    carrito.forEach(item => {
        total += item.subtotal;
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${item.nombre}</td>
            <td>$${item.precio.toFixed(2)}</td>
            <td>
                <input type="number" value="${item.cantidad}" min="1" max="${item.stock}" 
                       onchange="cambiarCantidad(${item.id_producto}, this.value)">
            </td>
            <td>$${item.subtotal.toFixed(2)}</td>
            <td><button class="btn-remove" onclick="eliminarDelCarrito(${item.id_producto})">✕</button></td>
        `;
        tbody.appendChild(tr);
    });

    document.getElementById('total-pagar').innerText = `$${total.toFixed(2)}`;
}

function procesarVenta() {
    if (carrito.length === 0) {
        alert('Agrega al menos un producto al carrito para realizar la venta.');
        return;
    }

    const totalCalculado = carrito.reduce((sum, item) => sum + item.subtotal, 0);

    const payload = {
        id_cliente: null,
        total: totalCalculado,
        detalles: carrito
    };

    fetch('index.php?controlador=Venta&accion=guardar', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status) {
            alert('¡Venta realizada con éxito!');
            carrito = [];
            renderizarCarrito();
            document.getElementById('buscar-producto').value = '';
            document.getElementById('resultados-busqueda').innerHTML = '';
        } else {
            alert('Error al registrar la venta: ' + (data.mensaje || 'Error desconocido'));
        }
    });
}
</script>