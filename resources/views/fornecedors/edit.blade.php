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

                    @if ($errors->any())
                    <div id="error-box" class="mt-4 mb-4 text-red-500 rounded-lg text-center font-semibold">
                        <ul class="">
                            @foreach ($errors->all() as $error)
                            <li>Todos os campos são obrigatórios!</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form class="max-w-sm mx-auto" action="{{ route('fornecedors.update', ['fornecedor' => $fornecedor->id]) }}" method="post">
                        @csrf
                        @method('PUT')



                        <!-- Nome -->
                        <div class="mb-5">
                            <label for="nome" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome</label>
                            <input type="text" id="nome" name="nome" value="{{ old('nome', $fornecedor->nome) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Digite o nome do produto" required="true">
                        </div>

                        <!-- Email -->
                        <div class="mb-5">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" name="email" value="{{ old('email', $fornecedor->email) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="nome@org.com" required="true">
                        </div>



                        <!-- Telefone -->
                        <div class="mb-5">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telefone</label>
                            <input type="tel" id="telefone" name="telefone" value="{{ old('telefone', $fornecedor->telefone) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Digite o telefone" required="true">

                        </div>

                        <!-- Endereço -->
                        <div class="mb-5">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Endereço</label>
                            <input type="text" value="{{ old('endereco', $fornecedor->endereco) }}" name="endereco" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Digite o endereço" required="true">

                        </div>

                        <!-- Botão de Envio -->
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Salvar</button>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#telefone').mask('(00) 00000-0000');
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