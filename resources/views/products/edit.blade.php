<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-green-700 leading-tight flex items-center gap-2">
            🥑 {{ __('Editar Producto') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-green-50 to-white">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-green-100">
                <div class="p-8">
                    <h3 class="text-xl font-semibold text-green-700 mb-6 border-b pb-3">
                        🛒 Actualizar información del producto
                    </h3>

                    <form action="{{ route('products.update', $product) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="nombre" class="block text-sm font-medium text-green-700 mb-2">
                                Nombre del producto
                            </label>
                            <input type="text" id="nombre" name="nombre"
                                   class="w-full border border-green-200 rounded-lg p-3 focus:ring-2 focus:ring-green-400 focus:border-green-400"
                                   value="{{ $product->nombre }}" required>
                        </div>

                        <div>
                            <label for="descripcion" class="block text-sm font-medium text-green-700 mb-2">
                                Descripción
                            </label>
                            <textarea id="descripcion" name="descripcion" rows="3"
                                      class="w-full border border-green-200 rounded-lg p-3 focus:ring-2 focus:ring-green-400 focus:border-green-400">{{ $product->descripcion }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="precio" class="block text-sm font-medium text-green-700 mb-2">
                                    Precio ($)
                                </label>
                                <input type="number" step="0.01" id="precio" name="precio"
                                       class="w-full border border-green-200 rounded-lg p-3 focus:ring-2 focus:ring-green-400 focus:border-green-400"
                                       value="{{ $product->precio }}" required>
                            </div>

                            <div>
                                <label for="stock" class="block text-sm font-medium text-green-700 mb-2">
                                    Cantidad en Stock
                                </label>
                                <input type="number" id="stock" name="stock"
                                       class="w-full border border-green-200 rounded-lg p-3 focus:ring-2 focus:ring-green-400 focus:border-green-400"
                                       value="{{ $product->stock }}" required>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 pt-6 border-t border-green-100">
                            <a href="{{ route('products.index') }}"
                               class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                                Cancelar
                            </a>
                            <button type="submit"
        class="px-5 py-2 rounded-lg bg-green-600 text-green-50 hover:bg-green-700 transition shadow-md">
    💾 Actualizar Producto
</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
