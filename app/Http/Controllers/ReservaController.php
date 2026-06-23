<?php

namespace App\Http\Controllers;

use App\Models\Casa;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    // Listar reservas do usuário logado
    public function index()
    {
        $reservas = Reserva::with('casa')
            ->where('user_id', Auth::id())
            ->orderBy('check_in')
            ->paginate(10);

        return view('reservas.index', compact('reservas'));
    }

    // Formulário para reservar uma casa
    public function create($casa_id)
    {
        $casa = Casa::findOrFail($casa_id);
        return view('reservas.create', compact('casa'));
    }

    // Salvar reserva
    public function store(Request $request)
    {
        $request->validate([
            'casa_id'   => 'required|exists:casas,id',
            'check_in'  => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        Reserva::create([
            'user_id'   => Auth::id(),
            'casa_id'   => $request->casa_id,
            'check_in'  => $request->check_in,
            'check_out' => $request->check_out,
        ]);

        return redirect('/reservas')->with('success', 'Reserva realizada com sucesso!');
    }

    // Cancelar reserva
    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->delete();
        return redirect('/reservas')->with('success', 'Reserva cancelada.');
    }

    // Gerenciamento admin (todas as reservas)
    public function adminIndex()
    {
        $reservas = Reserva::with(['user', 'casa'])->orderBy('check_in')->paginate(15);
        return view('reservas.admin', compact('reservas'));
    }
}