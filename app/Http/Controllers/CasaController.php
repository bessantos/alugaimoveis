<?php

namespace App\Http\Controllers;

use App\Models\Casa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CasaController extends Controller
{
    // Listagem pública de casas (área pública)
    public function publicIndex(Request $request)
    {
        $query = Casa::with('user');

        // Filtro por título
        if ($request->busca) {
            $query->where('titulo', 'like', '%' . $request->busca . '%');
        }

        // Filtro por preço máximo
        if ($request->preco_max) {
            $query->where('preco', '<=', $request->preco_max);
        }

        $casas = $query->paginate(9);
        return view('casas.publico', compact('casas'));
    }

    // Detalhe de uma casa (área pública)
    public function show($id)
    {
        $casa = Casa::with('user')->findOrFail($id);
        return view('casas.show', compact('casa'));
    }

    // Listagem das casas do usuário logado (área admin)
    public function index()
    {
        $casas = Casa::where('user_id', Auth::id())->paginate(10);
        return view('casas.index', compact('casas'));
    }

    // Formulário de criação
    public function create()
    {
        return view('casas.create');
    }

    // Salvar nova casa
    public function store(Request $request)
    {
        $request->validate([
            'titulo'   => 'required|min:3|max:100',
            'preco'    => 'required|numeric|gt:0',
            'endereco' => 'required',
            'imagem'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('imagem')) {
            $imagePath = $request->file('imagem')->store('casas', 'public');
        }

        try {
            Casa::create([
                'titulo'    => $request->titulo,
                'descricao' => $request->descricao,
                'preco'     => $request->preco,
                'endereco'  => $request->endereco,
                'imagem'    => $imagePath,
                'user_id'   => Auth::id(),
            ]);
            return redirect('/casas')->with('success', 'Casa cadastrada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao salvar casa', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Não foi possível salvar a casa.')->withInput();
        }
    }

    // Formulário de edição
    public function edit($id)
    {
        $casa = Casa::findOrFail($id);

        // Garante que só o dono pode editar
        if ($casa->user_id !== Auth::id()) {
            return redirect('/casas')->with('error', 'Acesso negado.');
        }

        return view('casas.edit', compact('casa'));
    }

    // Atualizar casa
    public function update(Request $request)
    {
        $request->validate([
            'titulo'   => 'required|min:3|max:100',
            'preco'    => 'required|numeric|gt:0',
            'endereco' => 'required',
            'imagem'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $casa = Casa::findOrFail($request->id);
        $imagePath = $casa->imagem;

        if ($request->hasFile('imagem')) {
            $imagePath = $request->file('imagem')->store('casas', 'public');
        }

        $casa->update([
            'titulo'    => $request->titulo,
            'descricao' => $request->descricao,
            'preco'     => $request->preco,
            'endereco'  => $request->endereco,
            'imagem'    => $imagePath,
        ]);

        return redirect('/casas')->with('success', 'Casa atualizada com sucesso!');
    }

    // Excluir casa
    public function destroy($id)
    {
        $casa = Casa::findOrFail($id);
        $casa->delete();
        return redirect('/casas')->with('success', 'Casa excluída com sucesso!');
    }
}