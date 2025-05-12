<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovelController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PedidoController;


Route::get('/', function () {
    return view('auth.login');
});

use App\Models\Movel;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Categoria;
use App\Models\Fornecedor;

Route::get('/dashboard', function () {
    $totalMoveis = Movel::count();
    $pedidosPendentes = Pedido::where('status', 'pendente')->count();
    $categorias = Categoria::count();
    $fornecedores = Fornecedor::count();

    return view('dashboard', compact('totalMoveis', 'pedidosPendentes', 'categorias', 'fornecedores'));
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Móveis
    Route::get('/movels', [MovelController::class, 'index'])->name('movels.index');
    Route::get('/movels/create', [MovelController::class, 'create'])->name('movels.create');
    Route::post('/movels', [MovelController::class, 'store'])->name('movels.store');
    Route::get('movels/{id}/edit', [MovelController::class, 'edit'])->name('movels.edit');
    Route::get('/movels/{movel}', [MovelController::class, 'show'])->name('movels.show');
    Route::put('/movels/{movel}', [MovelController::class, 'update'])->name('movels.update');
    Route::delete('/movels/{movel}', [MovelController::class, 'destroy'])->name('movels.destroy');


    // Fornecedores
    Route::get('/fornecedors', [FornecedorController::class, 'index'])->name('fornecedors.index');
    Route::get('/fornecedors/create', [FornecedorController::class, 'create'])->name('fornecedors.create');
    Route::post('/fornecedors', [FornecedorController::class, 'store'])->name('fornecedors.store');
    Route::get('fornecedors/{id}/edit', [FornecedorController::class, 'edit'])->name('fornecedors.edit');
    Route::get('/fornecedors/{fornecedor}', [FornecedorController::class, 'show'])->name('fornecedors.show');
    Route::put('/fornecedors/{fornecedor}', [FornecedorController::class, 'update'])->name('fornecedors.update');
    Route::delete('/fornecedors/{fornecedor}', [FornecedorController::class, 'destroy'])->name('fornecedors.destroy');

    // Categoria
    Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
    Route::get('/categorias/create', [CategoriaController::class, 'create'])->name('categorias.create');
    Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::get('categorias/{id}/edit', [CategoriaController::class, 'edit'])->name('categorias.edit');
    Route::get('/categorias/{categoria}', [CategoriaController::class, 'show'])->name('categorias.show');
    Route::put('/categorias/{categoria}', [CategoriaController::class, 'update'])->name('categorias.update');
    Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');

    //Pedidos
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/create', [PedidoController::class, 'create'])->name('pedidos.create');
    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
    Route::get('pedidos/{id}/edit', [PedidoController::class, 'edit'])->name('pedidos.edit');
    Route::get('/pedidos/{pedido}', [PedidoController::class, 'show'])->name('pedidos.show');
    Route::put('/pedidos/{pedido}', [PedidoController::class, 'update'])->name('pedidos.update');
    Route::delete('/pedidos/{pedido}', [PedidoController::class, 'destroy'])->name('pedidos.destroy');

});

require __DIR__.'/auth.php';
