<x-app-layout>
    <div class="py-8 max-w-4xl mx-auto px-4">

        @if($casa->imagem)
            <img src="{{ asset('storage/' . $casa->imagem) }}"
                 class="w-full h-72 object-cover rounded-lg mb-6">
        @endif

        <h1 class="text-3xl font-bold">{{ $casa->titulo }}</h1>
        <p class="text-gray-500 mt-1">📍 {{ $casa->endereco }}</p>
        <p class="text-indigo-600 text-2xl font-semibold mt-2">
            R$ {{ number_format($casa->preco, 2, ',', '.') }} / noite
        </p>
        <p class="text-gray-700 mt-4">{{ $casa->descricao }}</p>
        <p class="text-sm text-gray-400 mt-2">
            Anunciado por: {{ $casa->user->name }}
        </p>

        @auth
            <a href="{{ route('reservas.create', $casa->id) }}"
               class="mt-6 inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-semibold">
                Reservar esta casa
            </a>
        @else
            <a href="{{ route('login') }}"
               class="mt-6 inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">
                Faça login para reservar
            </a>
        @endauth
    </div>
</x-app-layout>