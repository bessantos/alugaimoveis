<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Minhas Reservas</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4">

        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full bg-white rounded-lg shadow text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Casa</th>
                    <th class="px-4 py-3 text-left">Endereço</th>
                    <th class="px-4 py-3 text-left">Check-in</th>
                    <th class="px-4 py-3 text-left">Check-out</th>
                    <th class="px-4 py-3 text-left">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservas as $reserva)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $reserva->casa->titulo }}</td>
                        <td class="px-4 py-3">{{ $reserva->casa->endereco }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($reserva->check_in)->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($reserva->check_out)->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('reservas.destroy', $reserva->id) }}"
                               onclick="return confirm('Cancelar esta reserva?')"
                               class="text-red-500 hover:underline">Cancelar</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-400">
                            Você ainda não tem reservas.
                            <a href="{{ route('home') }}" class="text-indigo-600 hover:underline">Buscar casas</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $reservas->links() }}</div>
    </div>
</x-app-layout>