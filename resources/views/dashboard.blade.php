<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Estatísticas rápidas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow text-center">
                    <h4 class="text-sm text-gray-500 dark:text-gray-400">Total de Móveis</h4>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $totalMoveis }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow text-center">
                    <h4 class="text-sm text-gray-500 dark:text-gray-400">Pedidos Pendentes</h4>
                    <p class="text-2xl font-bold text-yellow-500">{{ $pedidosPendentes }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow text-center">
                    <h4 class="text-sm text-gray-500 dark:text-gray-400">Categorias</h4>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $categorias }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow text-center">
                    <h4 class="text-sm text-gray-500 dark:text-gray-400">Fornecedores</h4>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $fornecedores }}</p>
                </div>
            </div>
            

            <!-- Cards principais -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card - Móveis -->
                <a href="{{ route('movels.index') }}" class="transition transform hover:scale-105">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center">
                        <div class="flex justify-center mb-3">
                            <img src="https://img.icons8.com/ios-filled/100/ffffff/sofa.png" class="w-12 h-12" alt="Móveis">
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Móveis</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Gerencie os móveis cadastrados.</p>
                    </div>
                </a>

                <!-- Card - Fornecedores -->
                <a href="{{ route('fornecedors.index') }}" class="transition transform hover:scale-105">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center">
                        <div class="flex justify-center mb-3">
                            <img src="https://img.icons8.com/ios-filled/100/ffffff/delivery.png" class="w-12 h-12" alt="Fornecedores">
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Fornecedores</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Controle e cadastre fornecedores.</p>
                    </div>
                </a>

                <!-- Card - Categorias -->
                <a href="{{ route('categorias.index') }}" class="transition transform hover:scale-105">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center">
                        <div class="flex justify-center mb-3">
                            <img src="https://img.icons8.com/ios-filled/100/ffffff/layers.png" class="w-12 h-12" alt="Categorias">
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Categorias</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Organize os móveis por categoria.</p>
                    </div>
                </a>

                <!-- Card - Pedidos -->
                <a href="{{ route('pedidos.index') }}" class="transition transform hover:scale-105">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center">
                        <div class="flex justify-center mb-3">
                            <img src="https://img.icons8.com/ios-filled/100/ffffff/shopping-cart.png" class="w-12 h-12" alt="Pedidos">
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Pedidos e Vendas</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Acompanhe seus pedidos e vendas.</p>
                    </div>
                </a>



                
            </div>

            
        </div>
    
        
    </div>

    

    @push('scripts')
    <!-- Gráfico Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['1ª sem', '2ª sem', '3ª sem', '4ª sem'],
                datasets: [{
                    label: 'Vendas',
                    data: [12, 19, 3, 5],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: document.documentElement.classList.contains('dark') ? '#fff' : '#000'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: document.documentElement.classList.contains('dark') ? '#ccc' : '#000'
                        }
                    },
                    y: {
                        ticks: {
                            color: document.documentElement.classList.contains('dark') ? '#ccc' : '#000'
                        }
                    }
                }
            }
        });
    </script>

    <!-- Toggle tema claro/escuro -->
    <script>
        document.getElementById('toggleTheme').addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
        });
    </script>

    <!-- Lucide Icons (se ainda estiver usando em outros lugares) -->
    <script type="module">
        import { createIcons } from 'https://unpkg.com/lucide@latest';
        createIcons();
    </script>
    @endpush
</x-app-layout>
