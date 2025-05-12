<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    // A instância do modelo Fornecedor
    public readonly Fornecedor $fornecedor;

    public function __construct()
    {
        // Aqui você instanciaria o modelo Fornecedor (já corrigido)
        $this->fornecedor = new Fornecedor();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Busca todos os fornecedores
        $fornecedors = Fornecedor::all();

        // Passa para a view
        return view('fornecedors', compact('fornecedors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fornecedors.create'); // Exibe o formulário para criar um novo fornecedor
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'required|string|max:15',
            'endereco' => 'required|string|max:255',
        ]);

        // Formata o telefone antes de salvar
        $telefoneFormatado = $this->formatarTelefone($request->input('telefone'));

        // Cria um novo fornecedor no banco de dados
        $created = $this->fornecedor->create([
            'nome' => $request->input('nome'),
            'email' => $request->input('email'),
            'telefone' => $telefoneFormatado,
            'endereco' => $request->input('endereco'),
        ]);

        // Verifica se o fornecedor foi criado com sucesso
        if ($created) {
            return redirect()->route('fornecedors.index')->with('message', 'Fornecedor criado com sucesso!');
        }

        return redirect()->route('fornecedors.index')->with('message', 'Erro ao criar fornecedor.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fornecedor = Fornecedor::find($id); // Busca o fornecedor pelo ID

        if (!$fornecedor) {
            return redirect()->route('fornecedors.index')->with('message', 'Fornecedor não encontrado.');
        }

        return view('fornecedors.show', ['fornecedor' => $fornecedor]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        return view('fornecedors.edit', compact('fornecedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->merge([
            'telefone' => $this->formatarTelefone($request->input('telefone')),
        ]);

        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'required|string|max:15',
            'endereco' => 'required|string|max:255',
        ]);

        $updated = $this->fornecedor->where('id', $id)->update($request->except('_token', '_method'));

        if ($updated) {
            return redirect()->route('fornecedors.index')->with('message', 'Fornecedor atualizado com sucesso!');
        }

        return redirect()->route('fornecedors.index')->with('message', 'Erro ao atualizar o fornecedor.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fornecedor = Fornecedor::find($id);

        if ($fornecedor) {
            $fornecedor->delete();
            return redirect()->route('fornecedors.index')->with('message', 'Fornecedor deletado com sucesso!');
        }

        return redirect()->route('fornecedors.index')->with('message', 'Fornecedor não encontrado.');
    }


    private function formatarTelefone($telefone)
    {

        $numeros = preg_replace('/\D/', '', $telefone);


        if (strlen($numeros) === 11) {
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $numeros);
        }


        if (strlen($numeros) === 10) {
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $numeros);
        }


        return $telefone;
    }
}
