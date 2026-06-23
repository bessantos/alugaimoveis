<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Reservar Casa</h2>
    </x-slot>

    <div class="py-8 max-w-xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow p-6">

            <h3 class="text-lg font-bold mb-1">{{ $casa->titulo }}</h3>
            <p class="text-gray-500 mb-4">{{ $casa->endereco }}</p>
            <p class="text-indigo-600 font-semibold mb-6">
                R$ {{ number_format($casa->preco, 2, ',', '.') }} / noite
            </p>

            @if($errors->any())
                <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('reservas.store') }}" method="POST">
                @csrf
                <input type="hidden" name="casa_id" value="{{ $casa->id }}">

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Check-in</label>
                    <input type="date" name="check_in" value="{{ old('check_in') }}"
                        class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Check-out</label>
                    <input type="date" name="check_out" value="{{ old('check_out') }}"
                        class="w-full border rounded px-3 py-2" required>
                </div>

                <button type="submit"
                    class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 font-semibold">
                    Confirmar Reserva
                </button>
            </form>
        </div>
    </div>
</x-app-layout>