<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Venta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-gradient-to-r from-emerald-600 to-green-600 text-white rounded-lg shadow-lg mb-8">
                <div class="p-8">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <div>
                            <h1 class="text-3xl font-bold">Registrar Nueva Venta</h1>
                            <p class="text-emerald-100">Registra una venta y actualiza el inventario automáticamente</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('sales.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Product Selection -->
                        <div>
                            <label for="product_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    Producto *
                                </span>
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200" id="product_id" name="product_id" required onchange="updateProductInfo()">
                                <option value="">Seleccionar Producto</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->precio }}" data-stock="{{ $product->stock }}">
                                        {{ $product->nombre }} - Stock: {{ $product->stock }} - ${{ number_format($product->precio, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label for="cantidad" class="block text-sm font-semibold text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h16"></path>
                                    </svg>
                                    Cantidad *
                                </span>
                            </label>
                            <input type="number" min="1" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors duration-200" id="cantidad" name="cantidad" required placeholder="1" onchange="calculateTotal()">
                            @error('cantidad')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price Display -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Precio Unitario</label>
                                    <div class="text-lg font-bold text-blue-600" id="unitPrice">$0.00</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Stock Disponible</label>
                                    <div class="text-lg font-bold text-orange-600" id="availableStock">0</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Total a Pagar</label>
                                    <div class="text-xl font-bold text-green-600" id="totalPrice">$0.00</div>
                                </div>
                            </div>
                        </div>

                        <!-- Client -->
                        <div>
                            <label for="cliente" class="block text-sm font-semibold text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Cliente (Opcional)
                                </span>
                            </label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors duration-200" id="cliente" name="cliente" placeholder="Nombre del cliente">
                            @error('cliente')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-8 py-3 rounded-lg font-semibold transition-colors duration-200 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Registrar Venta
                            </button>
                            <a href="{{ route('sales.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-8 py-3 rounded-lg font-semibold transition-colors duration-200 text-center flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-6 mt-6">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-emerald-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="text-emerald-800 font-semibold mb-2">💡 Consejos para registrar ventas</h4>
                        <ul class="text-emerald-700 text-sm space-y-1">
                            <li>• Verifica que haya suficiente stock antes de vender</li>
                            <li>• El precio se calcula automáticamente basado en el producto seleccionado</li>
                            <li>• El stock se reduce automáticamente al registrar la venta</li>
                            <li>• Puedes registrar ventas sin nombre de cliente</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateProductInfo() {
            const select = document.getElementById('product_id');
            const selectedOption = select.options[select.selectedIndex];
            const price = selectedOption.getAttribute('data-price') || 0;
            const stock = selectedOption.getAttribute('data-stock') || 0;

            document.getElementById('unitPrice').textContent = '$' + parseFloat(price).toFixed(2);
            document.getElementById('availableStock').textContent = stock;
            calculateTotal();
        }

        function calculateTotal() {
            const quantity = document.getElementById('cantidad').value || 0;
            const unitPrice = document.getElementById('unitPrice').textContent.replace('$', '') || 0;
            const total = parseFloat(quantity) * parseFloat(unitPrice);

            document.getElementById('totalPrice').textContent = '$' + total.toFixed(2);
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateProductInfo();
        });
    </script>
</x-app-layout>