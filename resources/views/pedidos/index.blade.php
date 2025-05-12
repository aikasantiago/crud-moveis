<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pedidos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session()->has('message'))
                    <div id="message-box" class="mb-4 p-4 text-green-700 bg-green-100 border border-green-300 rounded-lg shadow-md relative">
                        <svg class="inline w-5 h-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ session()->get('message') }}</span>
                        <button id="close-message" class="absolute top-2 right-2 text-green-500 hover:text-green-700">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <script>
                        document.getElementById('close-message')?.addEventListener('click', () => {
                            document.getElementById('message-box')?.classList.add('hidden');
                        });
                    </script>
                    @endif

                    <div class="flex justify-end mb-4">
                        <button id="open-modal" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5">
                            Adicionar novo pedido
                        </button>
                    </div>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">ID</th>
                                    <th scope="col" class="px-6 py-3">Cliente</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Produto</th>
                                    <th scope="col" class="px-6 py-3">Quantidade</th>
                                    <th scope="col" class="px-6 py-3">Total</th>
                                    <th scope="col" class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pedidos as $pedido)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4">{{ $pedido->id }}</td>
                                    <td class="px-6 py-4">{{ $pedido->cliente_nome }}</td>
                                    <td class="px-6 py-4 capitalize">
                                        {{ $pedido->status }}
                                    </td>

                                    {{-- Produto --}}
                                    <td class="px-6 py-4">
                                        <ul class="space-y-1">
                                            @foreach ($pedido->itens as $item)
                                            <li>{{ $item->movel->nome ?? 'Produto não encontrado' }}</li>
                                            @endforeach
                                        </ul>
                                    </td>

                                    {{-- Quantidade --}}
                                    <td class="px-6 py-4">
                                        <ul class="space-y-1">
                                            @foreach ($pedido->itens as $item)
                                            <li>{{ $item->quantidade }}</li>
                                            @endforeach
                                        </ul>
                                    </td>

                                    <td class="px-6 py-4">R$ {{ number_format($pedido->total, 2, ',', '.') }}</td>

                                    <td class="px-2 py-4 text-right">
                                        <div class="flex space-x-2 justify-end">
                                            <a href="{{ route('pedidos.edit', $pedido->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-4">Editar</a>
                                            <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" id="delete-form-{{ $pedido->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="font-medium text-red-600 mr-8 dark:text-red-500 hover:underline" id="delete-btn-{{ $pedido->id }}" data-modal-target="popup-modal" data-modal-toggle="popup-modal">
                                                    Deletar
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal Deletar -->
    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-3 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Fechar</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Tem certeza que quer deletar este pedido?</h3>
                    <button data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Sim, eu tenho.
                    </button>
                    <button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Não, cancele
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Script para exclusão-->
    <script>
        // Script para mostrar o modal de deletar
        document.querySelectorAll('[data-modal-target="popup-modal"]').forEach(button => {
            button.addEventListener('click', (e) => {
                // Impedir o envio do formulário ao clicar no botão
                e.preventDefault();

                // Obter o id do móvel do botão de deletar
                const deleteButtonId = e.target.id.replace('delete-btn-', '');
                const form = document.getElementById(`delete-form-${deleteButtonId}`);

                // Mostrar o modal de confirmação de exclusão
                document.getElementById('popup-modal').classList.remove('hidden');
                document.getElementById('modal-overlay').classList.remove('hidden');

                // Configurar o botão de confirmação dentro do modal para submeter o formulário de deleção
                const confirmDeleteButton = document.querySelector('#popup-modal .text-white.bg-red-600');
                confirmDeleteButton.addEventListener('click', () => {
                    form.submit(); // Submete o formulário de exclusão
                });
            });
        });

        document.querySelector('#popup-modal').addEventListener('click', (e) => {
            if (e.target.id === 'popup-modal') {
                document.getElementById('popup-modal').classList.add('hidden');
                document.getElementById('modal-overlay').classList.add('hidden');
            }
        });

        document.querySelectorAll('[data-modal-hide="popup-modal"]').forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('popup-modal').classList.add('hidden');
                document.getElementById('modal-overlay').classList.add('hidden');
            });
        });
    </script>



    <div id="modal-overlay" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 z-40"></div>
    <div id="crud-modal" class="hidden fixed inset-0 flex justify-center items-center z-50">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Criar novo pedido
                    </h3>
                    <button id="close-modal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Fechar</span>
                    </button>
                </div>

                @if ($errors->any())
                <div id="error-box" class="mt-4 text-red-500 rounded-lg text-center font-semibold">
                    <ul class="">
                        @foreach ($errors->all() as $error)
                        <li>Todos os campos são obrigatórios!</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form class="p-4 md:p-5" action="{{ route('pedidos.store') }}" method="POST">
                    @csrf
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="cliente_nome" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cliente</label>
                            <input type="text" name="cliente_nome" id="cliente_nome" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required required="true" placeholder="Nome do cliente">
                        </div>
                        <div class="col-span-2">
                            <label for="produto_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Produto</label>
                            <select name="itens[0][movel_id]" id="produto_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required required="true">
                                @foreach ($movels as $movel)
                                <option value="{{ $movel->id }}">{{ $movel->nome }} - R$ {{ number_format($movel->preco, 2, ',', '.') }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="quantidade" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantidade</label>
                            <input type="number" name="itens[0][quantidade]" id="quantidade" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required required="true" placeholder="Quantidade solicitada">
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label for="data" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Data</label>
                            <input type="date" name="data" id="data"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="true" required>
                        </div>
                        <div class="col-span-2">
                            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <select name="status" id="status" required="true" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option value="pendente">Pendente</option>
                                <option value="pago">Pago</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>



                        <div class="col-span-2 flex justify-center">
                            <button type="submit"
                                class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Adicionar novo pedido
                            </button>
                        </div>

                </form>

            </div>
        </div>
    </div>
    <!-- Script Modal Adicionar -->
    <script>
        document.getElementById('open-modal').addEventListener('click', () => {
            document.getElementById('crud-modal').classList.remove('hidden');
            document.getElementById('modal-overlay').classList.remove('hidden');
        });

        document.getElementById('close-modal').addEventListener('click', () => {
            document.getElementById('crud-modal').classList.add('hidden');
            document.getElementById('modal-overlay').classList.add('hidden');
        });

        document.getElementById('modal-overlay').addEventListener('click', () => {
            document.getElementById('crud-modal').classList.add('hidden');
            document.getElementById('modal-overlay').classList.add('hidden');
        });
    </script>


    @if ($errors->any())
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            document.getElementById('crud-modal').classList.remove('hidden');
            document.getElementById('modal-overlay').classList.remove('hidden');
        });
    </script>
    @endif


</x-app-layout>