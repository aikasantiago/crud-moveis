<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Pedido') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($errors->any())
                    <div id="error-box" class="mt-4 mb-4 text-red-500 rounded-lg text-center font-semibold">
                        <ul class="">
                            @foreach ($errors->all() as $error)
                            <li>Todos os campos são obrigatórios!</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form class="max-w-sm mx-auto" action="{{ route('pedidos.update', $pedido->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Cliente Nome -->
                        <div class="mb-5">
                            <label for="cliente_nome" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome do Cliente</label>
                            <input type="text" name="cliente_nome" id="cliente_nome" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ old('cliente_nome', $pedido->cliente_nome) }}" required required="true">
                        </div>

                        <!-- Status -->
                        <div class="mb-5">
                            <label for="status" class="block mb-2 text-sm font-medium">Status</label>
                            <select name="status" id="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required required="true">
                                <option value="pendente" {{ old('status', $pedido->status) == 'pendente' ? 'selected' : '' }}>Pendente</option>
                                <option value="pago" {{ old('status', $pedido->status) == 'pago' ? 'selected' : '' }}>Pago</option>
                                <option value="cancelado" {{ old('status', $pedido->status) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </div>


                        <!-- Botão de Submissão -->
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Atualizar Pedido
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            document.getElementById('crud-modal').classList.remove('hidden');
            document.getElementById('modal-overlay').classList.remove('hidden');
        });
    </script>
    @endif
</x-app-layout>