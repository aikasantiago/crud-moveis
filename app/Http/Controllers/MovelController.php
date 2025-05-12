<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movel;
use App\Models\Categoria;

class MovelController extends Controller
{
    public readonly Movel $movel;

    public function __construct()
    {
        $this->movel = new Movel();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movels = Movel::with('categoria')->get();
        $categorias = Categoria::all();
        return view('movels.index', compact('movels', 'categorias'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::pluck('nome_categoria', 'id');
        return view('movels.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric',
            'categoria_id' => 'required|exists:categorias,id',
            'estoque' => 'required|integer',
        ]);

        try {
            Movel::create([
                'nome' => $request->nome,
                'preco' => $request->preco,
                'categoria_id' => $request->categoria_id,
                'estoque' => $request->estoque,
            ]);
            return redirect()->route('movels.index')->with('message', 'Móvel criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('movels.index')->with('error', 'Erro ao cadastrar o móvel.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $movel = Movel::with('categoria')->find($id);

        if (!$movel) {
            return redirect()->route('movels.index')->with('message', 'Móvel não encontrado.');
        }

        return view('movels.show', ['movel' => $movel]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $movel = Movel::findOrFail($id);
        $categorias = Categoria::all(); // lista todas as categorias
        return view('movels.edit', compact('movel', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validação
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric',
            'categoria_id' => 'required|exists:categorias,id',
            'estoque' => 'required|integer',
        ]);

        $movel = Movel::findOrFail($id);

        $movel->update([
            'nome' => $request->nome,
            'preco' => $request->preco,
            'categoria_id' => $request->categoria_id,
            'estoque' => $request->estoque,
        ]);

        return redirect()->route('movels.index')->with('message', 'Móvel atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $movel = Movel::find($id);

        if ($movel) {
            $movel->delete();
            return redirect()->route('movels.index')->with('message', 'Móvel deletado com sucesso!');
        }

        return redirect()->route('movels.index')->with('message', 'Móvel não encontrado.');
    }
}
