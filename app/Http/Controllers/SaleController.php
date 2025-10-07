<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Sale::with('product');

        // Filtro por producto
        if (request('product_search')) {
            $query->whereHas('product', function($q) {
                $q->where('nombre', 'like', '%' . request('product_search') . '%');
            });
        }

        // Filtro por cliente
        if (request('client_search')) {
            $query->where('cliente', 'like', '%' . request('client_search') . '%');
        }

        // Filtro por fecha desde
        if (request('date_from')) {
            $query->where('fecha', '>=', request('date_from'));
        }

        // Filtro por fecha hasta (si se agrega después)
        if (request('date_to')) {
            $query->where('fecha', '<=', request('date_to'));
        }

        $sales = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();
        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('sales.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'cantidad' => 'required|integer|min:1',
            'cliente' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->cantidad) {
            return back()->withErrors(['cantidad' => 'Stock insuficiente.']);
        }

        $precio_venta = $product->precio * $request->cantidad;

        Sale::create([
            'product_id' => $request->product_id,
            'cantidad' => $request->cantidad,
            'precio_venta' => $precio_venta,
            'fecha' => now()->toDateString(),
            'cliente' => $request->cliente,
        ]);

        $product->decrement('stock', $request->cantidad);

        return redirect()->route('sales.index')->with('success', 'Venta registrada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sale = Sale::findOrFail($id);
        $products = Product::all();
        return view('sales.edit', compact('sale', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'cantidad' => 'required|integer|min:1',
            'cliente' => 'nullable|string|max:255',
        ]);

        $sale = Sale::findOrFail($id);
        $product = Product::findOrFail($request->product_id);

        // Calcular la diferencia de stock
        $diferenciaStock = $request->cantidad - $sale->cantidad;

        // Verificar si hay suficiente stock si aumentamos la cantidad
        if ($diferenciaStock > 0 && $product->stock < $diferenciaStock) {
            return back()->withErrors(['cantidad' => 'Stock insuficiente para la nueva cantidad.']);
        }

        $precio_venta = $product->precio * $request->cantidad;

        // Ajustar el stock del producto
        if ($diferenciaStock > 0) {
            // Si aumentamos la cantidad, decrementamos más stock
            $product->decrement('stock', $diferenciaStock);
        } elseif ($diferenciaStock < 0) {
            // Si disminuimos la cantidad, incrementamos el stock
            $product->increment('stock', abs($diferenciaStock));
        }

        $sale->update([
            'product_id' => $request->product_id,
            'cantidad' => $request->cantidad,
            'precio_venta' => $precio_venta,
            'cliente' => $request->cliente,
        ]);

        return redirect()->route('sales.index')->with('success', 'Venta actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sale = Sale::findOrFail($id);

        // Devolver el stock al producto
        $sale->product->increment('stock', $sale->cantidad);

        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Venta eliminada exitosamente.');
    }

    public function generatePDF()
    {
        $sales = Sale::with('product')->orderBy('created_at', 'desc')->get();

        $totalVentas = $sales->count();
        $totalIngresos = $sales->sum('precio_venta');
        $productosVendidos = $sales->sum('cantidad');

        $pdf = Pdf::loadView('sales.pdf', compact('sales', 'totalVentas', 'totalIngresos', 'productosVendidos'));

        return $pdf->download('reporte-ventas-' . date('Y-m-d') . '.pdf');
    }
}
