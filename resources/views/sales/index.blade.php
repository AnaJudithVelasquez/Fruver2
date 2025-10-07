<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ventas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg shadow-lg mb-8">
                <div class="p-8">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold mb-2">🛒 Historial de Ventas</h1>
                            <p class="text-green-100">{{ $sales->count() }} ventas registradas</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('sales.pdf') }}" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-200 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Generar PDF
                            </a>
                            <a href="{{ route('sales.create') }}" class="bg-white text-green-600 px-6 py-3 rounded-lg font-semibold hover:bg-green-50 transition-colors duration-200 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Nueva Venta
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filtros
                </h3>
                <form method="GET" action="{{ route('sales.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="product_search" class="block text-sm font-medium text-gray-700 mb-1">Producto</label>
                        <input type="text" name="product_search" id="product_search" value="{{ request('product_search') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Buscar por producto">
                    </div>
                    <div>
                        <label for="client_search" class="block text-sm font-medium text-gray-700 mb-1">Cliente</label>
                        <input type="text" name="client_search" id="client_search" value="{{ request('client_search') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Buscar por cliente">
                    </div>
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Fecha desde</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Filtrar
                        </button>
                        <a href="{{ route('sales.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            <!-- Sales Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($sales as $sale)
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-200">
                        <div class="p-6">
                            <!-- Header -->
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $sale->product->nombre }}</h3>
                                    <p class="text-sm text-gray-500">Venta #{{ $sale->id }}</p>
                                </div>
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                    {{ \Carbon\Carbon::parse($sale->fecha)->format('d/m/Y') }}
                                </span>
                            </div>

                            <!-- Sale Details -->
                            <div class="space-y-3 mb-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Cantidad:</span>
                                    <span class="font-semibold text-blue-600">{{ $sale->cantidad }} unidades</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Precio unitario:</span>
                                    <span class="font-semibold">${{ number_format($sale->product->precio, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                                    <span class="text-gray-800 font-semibold">Total:</span>
                                    <span class="text-2xl font-bold text-green-600">${{ number_format($sale->precio_venta, 2) }}</span>
                                </div>
                            </div>

                            <!-- Client Info -->
                            @if($sale->cliente)
                                <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span class="text-sm text-gray-700">{{ $sale->cliente }}</span>
                                    </div>
                                </div>
                            @endif

                            <!-- Actions -->
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Completada
                                </span>
                                <div class="flex space-x-2">
                                    @if(in_array(auth()->user()->role->name, ['SuperAdministrador', 'Administrador']))
                                        <a href="{{ route('sales.edit', $sale) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-xs transition-colors duration-200 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Editar
                                        </a>
                                        <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="inline">
    @csrf
    @method('DELETE')
    <button type="button" 
        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs transition-colors duration-200 flex items-center"
        onclick="confirmarEliminacion(event, this)">
        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
        </svg>
        Eliminar
    </button>
</form>

                                    @endif
                                </div>
                            </div>
                            <div class="mt-2 text-xs text-gray-500 text-right">
                                {{ \Carbon\Carbon::parse($sale->created_at)->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($sales->isEmpty())
                <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                    <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No hay ventas registradas</h3>
                    <p class="text-gray-500 mb-4">Comienza registrando tu primera venta</p>
                    <a href="{{ route('sales.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-200 inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Registrar Primera Venta
                    </a>
                </div>
            @endif

            <!-- Summary Card -->
            @if($sales->count() > 0)
                <div class="bg-white rounded-xl shadow-lg p-6 mt-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">📊 Resumen de Ventas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $sales->count() }}</div>
                            <div class="text-sm text-gray-600">Total Ventas</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $sales->sum('cantidad') }}</div>
                            <div class="text-sm text-gray-600">Productos Vendidos</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">${{ number_format($sales->sum('precio_venta'), 2) }}</div>
                            <div class="text-sm text-gray-600">Ingresos Totales</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-orange-600">${{ $sales->count() > 0 ? number_format($sales->sum('precio_venta') / $sales->count(), 2) : '0.00' }}</div>
                            <div class="text-sm text-gray-600">Promedio por Venta</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmarEliminacion(event, boton) {
    event.preventDefault();
    const form = boton.closest('form'); // Encuentra el formulario más cercano

    Swal.fire({
        title: '¿Eliminar venta?',
        text: "Esta acción no se puede deshacer. El stock será devuelto al producto.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit(); // Envía el formulario si confirma
        }
    });
}
</script>


</x-app-layout>