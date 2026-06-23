<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Casas Disponíveis
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4">

        {{-- Filtro de busca --}}
        <form method="GET" action="/" class="flex gap-3 mb-6">
            <input type="text" name="busca" value="{{ request('busca') }}"
                placeholder="Buscar por título..."
                class="border rounded px-3 py-2 w-64">
            <input type="number" name="preco_max" value="{{ request('preco_max') }}"
                placeholder="Preço máximo (R$)"
                class="border rounded px-3 py-2 w-48">
            <button type="submit"
                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Buscar
            </button>
        </form>

        {{-- Grid de casas --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($casas as $casa)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    @if($casa->imagem)
                        <img src="{{ asset('storage/' . $casa->imagem) }}"
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                            Sem imagem
                        </div>
                    @endif
                    <div class="p-4">
                        <h3 class="font-bold text-lg">{{ $casa->titulo }}</h3>
                        <p class="text-gray-500 text-sm">{{ $casa->endereco }}</p>
                        <p class="text-indigo-600 font-semibold mt-2">
                            R$ {{ number_format($casa->preco, 2, ',', '.') }} / noite
                        </p>
                        <a href="{{ route('casas.show', $casa->id) }}"
                           class="mt-3 inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">
                            Ver detalhes
                        </a>
                    </div>
                </div>
            @empty
                <p class="col-span-3 text-center text-gray-500">Nenhuma casa encontrada.</p>
            @endforelse
        </div>

        {{-- Paginação --}}
        <div class="mt-6">
            {{ $casas->links() }}
        </div>
    </div>
</x-app-layout>