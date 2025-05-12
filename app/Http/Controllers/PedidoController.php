<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Movel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PedidoController extends Controller
{
    public function index()
    {
        // Busca os pedidos com itens e móveis relacionados
        $pedidos = Pedido::with('itens.movel')->get();

        $movels = Movel::all();  // Adiciona a variável $movels com todos os móveis

        return view('pedidos.index', compact('pedidos', 'movels'));  // Passa $pedidos e $movels para a view
    }


    public function create()
    {
        $movels = Movel::all();
        return view('pedidos.create', compact('movels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_nome' => 'required|string|max:255',
            'itens' => 'required|array|min:1',
            'itens.*.movel_id' => 'required|exists:movels,id',
            'itens.*.quantidade' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // Criação do pedido
            $pedido = Pedido::create([
                'cliente_nome' => $request->cliente_nome,
                'data' => $request->data ?? now(),
                'status' => $request->status,
                'total' => 0
            ]);

            $total = 0;

            // Iterar sobre os itens e adicioná-los ao pedido
            foreach ($request->itens as $item) {
                $movel = Movel::findOrFail($item['movel_id']);
                $subtotal = $movel->preco * $item['quantidade'];
                $total += $subtotal;


                PedidoItem::create([
                    'pedido_id' => $pedido->id,
                    'movel_id' => $movel->id,
                    'quantidade' => $item['quantidade'],
                    'preco_unitario' => $movel->preco
                ]);
            }

            // Atualizar o total do pedido
            $pedido->update(['total' => $total]);

            DB::commit();

            return redirect()->route('pedidos.index')->with('message', 'Pedido criado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('message', 'Erro ao criar pedido. Detalhes: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();

        return redirect()->route('pedidos.index')->with('message', 'Pedido deletado com sucesso!');
    }

    public function edit($id)
    {
        $pedido = Pedido::with('itens')->findOrFail($id);

        // converter string em objeto Carbon
        $pedido->data = Carbon::parse($pedido->data);

        $movels = Movel::all();

        return view('pedidos.edit', compact('pedido', 'movels'));
    }
    public function update(Request $request, Pedido $pedido)
{
    $request->validate([
        'cliente_nome' => 'required|string',
        'status' => 'required|string',
    ]);

    $pedido->update([
        'cliente_nome' => $request->cliente_nome,
        'status' => $request->status,
    ]);

    return redirect()->route('pedidos.index')->with('message', 'Pedido alterado com sucesso!');;
}
}