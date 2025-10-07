<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas - {{ date('d/m/Y') }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #2563eb;
            margin: 0;
            font-size: 28px;
        }
        .header p {
            color: #666;
            margin: 5px 0;
            font-size: 14px;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
            background: #f8fafc;
            padding: 20px;
            border-radius: 8px;
        }
        .stat-item {
            text-align: center;
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
        }
        .stat-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #2563eb;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .total-row {
            background-color: #dbeafe !important;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
        }
        .product-name {
            font-weight: bold;
            color: #1f2937;
        }
        .price {
            color: #059669;
            font-weight: bold;
        }
        .date {
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏪 Reporte de Ventas</h1>
        <p>Fruver App - Sistema de Gestión</p>
        <p>Generado el: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="stats">
        <div class="stat-item">
            <div class="stat-value">{{ $totalVentas }}</div>
            <div class="stat-label">Total Ventas</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ $productosVendidos }}</div>
            <div class="stat-label">Productos Vendidos</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">${{ number_format($totalIngresos, 2) }}</div>
            <div class="stat-label">Ingresos Totales</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">${{ $totalVentas > 0 ? number_format($totalIngresos / $totalVentas, 2) : '0.00' }}</div>
            <div class="stat-label">Promedio por Venta</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID Venta</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
                <th>Cliente</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>#{{ $sale->id }}</td>
                <td class="product-name">{{ $sale->product->nombre }}</td>
                <td>{{ $sale->cantidad }}</td>
                <td class="price">${{ number_format($sale->product->precio, 2) }}</td>
                <td class="price">${{ number_format($sale->precio_venta, 2) }}</td>
                <td>{{ $sale->cliente ?: 'N/A' }}</td>
                <td class="date">{{ \Carbon\Carbon::parse($sale->fecha)->format('d/m/Y') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="4" style="text-align: right; font-size: 16px;">TOTALES:</td>
                <td class="price" style="font-size: 16px;">${{ number_format($totalIngresos, 2) }}</td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Reporte generado automáticamente por el sistema Fruver App</p>
        <p>Fecha de generación: {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>