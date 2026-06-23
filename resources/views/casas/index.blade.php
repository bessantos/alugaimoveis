<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Minhas Casas</h2>
            <a href="{{ route('casas.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">
                + Nova Casa
            </a>
        </div>
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
                    <th class="px-4 py-3 text-left">Título</th>
                    <th class="px-4 py-3 text-left">Endereço</th>
                    <th class="px-4 py-3 text-left">Preço/noite</th>
                    <th class="px-4 py-3 text-left">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($casas as $casa)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $casa->titulo }}</td>
                        <td class="px-4 py-3">{{ $casa->endereco }}</td>
                        <td class="px-4 py-3">R$ {{ number_format($casa->preco, 2, ',', '.') }}</td>
                        <td class="px-4 py-3 flex gap-2">
                            <a href="{{ route('casas.edit', $casa->id) }}"
                               class="text-indigo-600 hover:underline">Editar</a>
                            <a href="{{ route('casas.destroy', $casa->id) }}"
                               onclick="return confirm('Excluir esta casa?')"
                               class="text-red-500 hover:underline">Excluir</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-400">
                            Você ainda não cadastrou nenhuma casa.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $casas->links() }}</div>
    </div>
</x-app-layout>