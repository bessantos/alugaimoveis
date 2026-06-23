<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Editar Casa</h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow p-6">

            <form action="{{ route('casas.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $casa->id }}">

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                    <input type="text" name="titulo" value="{{ $casa->titulo }}"
                        class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                    <textarea name="descricao" rows="4"
                        class="w-full border rounded px-3 py-2">{{ $casa->descricao }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Preço por noite (R$)</label>
                    <input type="number" step="0.01" name="preco" value="{{ $casa->preco }}"
                        class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Endereço</label>
                    <input type="text" name="endereco" value="{{ $casa->endereco }}"
                        class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nova Foto (opcional)</label>
                    @if($casa->imagem)
                        <img src="{{ asset('storage/' . $casa->imagem) }}"
                             class="h-24 rounded mb-2 object-cover">
                    @endif
                    <input type="file" name="imagem" accept="image/*"
                        class="w-full border rounded px-3 py-2">
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                        Atualizar
                    </button>
                    <a href="{{ route('casas.index') }}"
                        class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>