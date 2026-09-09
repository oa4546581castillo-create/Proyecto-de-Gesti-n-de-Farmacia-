<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Venta #<?= $venta['id_venta'] ?></title>
    <style>
        /* Configuramos la página web para que mida exactamente 80mm de ancho */
        body {
            width: 78mm; /* Ajuste térmico estándar */
            margin: 0 auto;
            padding: 10px;
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .tabla { width: 100%; border-collapse: collapse; margin: 10px 0; }
        .tabla th, .tabla td { 
            text-align: left; 
            font-size: 11px; 
            padding: 3px 0;
            border-bottom: 1px dashed #ccc;
        }
        .total { font-weight: bold; font-size: 14px; text-align: right; margin-top: 10px; }
        
        /* Oculta el botón de imprimir cuando ya está saliendo el papel en la máquina */
        @media print {
            .btn-imprimir { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<!-- El onload="window.print()" hace que al abrir esta página, salte la ventana de imprimir sola -->
<body onload="window.print();">

    <div class="text-center">
        <h2 style="margin-bottom: 2px;">FARMACIA SYS</h2>
        <p style="margin-top: 0; font-size: 11px;">
            RUC: 0614-120599-101-2<br>
            Calle Principal San Antonio del Monte #123<br>
            Tel: +503 6152-6746
        </p>
        <hr style="border: 1px dashed #000;">
        <p style="margin: 5px 0;">
            <strong>Ticket N°:</strong> #<?= str_pad($venta['id_venta'], 6, '0', STR_PAD_LEFT) ?><br>
            <strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($venta['fecha'])) ?>
        </p>
        <hr style="border: 1px dashed #000;">
    </div>

    <table class="tabla">
        <thead>
            <tr>
                <th>Cant</th>
                <th>Producto</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $totalCalculado = 0;
            if(!empty($detalles)){
                foreach ($detalles as $item): 
                    $nombre = $item['nombre_producto'] ?? $item['producto'] ?? $item['nombre'] ?? 'Producto';
                    $cant = $item['cantidad'] ?? 1;
                    $precio = $item['precio_unitario'] ?? $item['precio'] ?? 0;
                    $subtotal = $item['subtotal'] ?? ($cant * $precio);
                    $totalCalculado += $subtotal;
            ?>
            <tr>
                <td><?= $cant ?></td>
                <td><?= substr($nombre, 0, 16) ?></td>
                <td class="text-right">$<?= number_format($subtotal, 2) ?></td>
            </tr>
            <?php 
                endforeach; 
            } else {
                echo "<tr><td colspan='3' class='text-center'>Sin detalles</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <hr style="border: 1px dashed #000;">
    <div class="total">
        TOTAL: $<?= number_format(isset($venta['total']) && $venta['total'] > 0 ? $venta['total'] : $totalCalculado, 2) ?>
    </div>

    <div class="text-center" style="margin-top: 15px; font-size: 11px;">
        <p>¡Gracias por su compra!<br>Conserve su ticket para cambios.</p>
    </div>

    <!-- Botón por si el usuario canceló la impresión y quiere volver a darle -->
    <div class="text-center btn-imprimir" style="margin-top: 20px;">
        <button onclick="window.print()" style="padding: 10px 15px; cursor: pointer; background: #0284c7; color: white; border: none; border-radius: 5px;">
            🖨️ Imprimir Ticket
        </button>
    </div>

</body>
</html>