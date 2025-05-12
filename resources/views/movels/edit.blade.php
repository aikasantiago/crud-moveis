<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form class="max-w-sm mx-auto" action="{{ route('movels.update', ['movel' => $movel->id]) }}" method="post">
                        @csrf
                        @method('PUT')

                        @if ($errors->any())
                        <div id="error-box" class="mt-4 mb-4 text-red-500 rounded-lg text-center font-semibold">
                            <ul class="">
                                @foreach ($errors->all() as $error)
                                <li>Todos os campos são obrigatórios!</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Nome -->
                        <div class="mb-5">
                            <label for="nome" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome</label>
                            <input type="text" id="nome" name="nome" value="{{ old('nome', $movel->nome) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Digite o nome do produto" required="true">
                        </div>

                        <!-- Categoria -->
                        <div class="mb-5">
                            <label for="categoria_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categoria</label>
                            <select id="categoria_id" name="categoria_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required required="true">
                                @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ $categoria->id == $movel->categoria_id ? 'selected' : '' }}>
                                    {{ $categoria->nome_categoria }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Preço -->
                        <div class="mb-5">
                            <label for="preco" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Preço</label>
                            <input type="number" id="preco" value="{{ old('preco', $movel->preco) }}" id="price" name="preco" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Digite o preço do produto" required step="0.01" required="true">
                        </div>

                        <!-- Quantidade -->
                        <div class="mb-5">
                            <label for="quantidade" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantidade</label>
                            <input type="number" id="quantidade" value="{{ old('estoque', $movel->estoque) }}" name="estoque" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Digite a quantidade" required="true">
                        </div>

                        <!-- Botão de Envio -->
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Salvar</button>
                    </form>
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