<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Móveis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">


                    @if (session()->has('message'))
                    <div id="message-box" class="mb-4 p-4 text-green-700 bg-green-100 border border-green-300 rounded-lg shadow-md relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ session()->get('message') }}</span>
                        <button id="close-message" class="absolute top-2 right-2 text-green-500 hover:text-green-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

                    <!-- Botão Adicionar -->
                    <div class="flex justify-end mb-4">
                        <button id="open-modal" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                            Adicionar novo móvel
                        </button>
                    </div>

                    <!-- Tabela -->
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Id
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nome
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Quantidade
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Categoria
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Preço
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="sr-only">Editar</span>
                                        <span class="sr-only">Deletar</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($movels as $movel)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $movel->id }}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $movel->nome }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $movel->estoque }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $movel->categoria->nome_categoria }}
                                    </td>
                                    <td class="px-6 py-4">
                                        R$ {{ number_format($movel->preco, 2, ',', '.') }}
                                    </td>
                                    <td class="px-2 py-4 text-right">
                                        <div class="flex space-x-2 justify-end">
                                            <a href="{{ route('movels.edit', $movel->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-4">Editar</a>
                                            <form class="inline" action="{{ route('movels.destroy', [$movel->id]) }}" method="post" id="delete-form-{{ $movel->id }}">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="button" class="font-medium text-red-600 mr-8 dark:text-red-500 hover:underline" id="delete-btn-{{ $movel->id }}" data-modal-target="popup-modal" data-modal-toggle="popup-modal">
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



    <!-- Modal Adicionar -->
    <div id="modal-overlay" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 z-40"></div>
    <div id="crud-modal" class="hidden fixed inset-0 flex justify-center items-center z-50">
        <div class="relative p-4 w-full max-w-md max-h-full">

            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Criar novo móvel
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

                <form class="p-4 md:p-5" action="{{ route('movels.store') }}" method="post">
                    @csrf
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome</label>
                            <input type="text" name="nome" id="nome" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Digite o nome do móvel" required="true">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Preço</label>
                            <input type="number" name="preco" id="price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="$2999" required="true">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categoria</label>

                            <select name="categoria_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="true">
                                <option value="" selected disabled>Selecione uma categoria</option>
                                @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nome_categoria }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantidade</label>
                            <input type="number" name="estoque" id="quantity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Digite a quantidade no estoque" required="true">
                        </div>
                    </div>
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Adicionar novo móvel
                    </button>
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
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Tem certeza que quer deletar este móvel?</h3>
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

    @if ($errors->any())
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            document.getElementById('crud-modal').classList.remove('hidden');
            document.getElementById('modal-overlay').classList.remove('hidden');
        });
    </script>
    @endif





</x-app-layout>