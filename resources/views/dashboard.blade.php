<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Dashboard</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <p class="text-3xl font-bold text-indigo-600">{{ $totalCasas }}</p>
                <p class="text-gray-500 mt-1">Minhas Casas</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <p class="text-3xl font-bold text-green-600">{{ $totalReservas }}</p>
                <p class="text-gray-500 mt-1">Minhas Reservas</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <p class="text-3xl font-bold text-yellow-600">{{ $reservasPendentes }}</p>
                <p class="text-gray-500 mt-1">Reservas Futuras</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold text-gray-700 mb-4">
                Reservas por mês ({{ now()->year }})
            </h3>
            <canvas id="grafico" height="100"
                data-meses="{{ implode(',', $meses) }}"
                data-quantidades="{{ implode(',', $quantidades) }}">
            </canvas>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const canvas = document.getElementById('grafico');

                const mesesRaw = canvas.getAttribute('data-meses');
                const quantidadesRaw = canvas.getAttribute('data-quantidades');

                const meses = mesesRaw ? mesesRaw.split(',') : [];
                const quantidades = quantidadesRaw ? quantidadesRaw.split(',').map(Number) : [];

                new Chart(canvas, {
                    type: 'bar',
                    data: {
                        labels: meses,
                        datasets: [{
                            label: 'Reservas',
                            data: quantidades,
                            backgroundColor: '#6366f1',
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            });
        </script>

    </div>
</x-app-layout>