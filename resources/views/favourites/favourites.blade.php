<x-layout title="Favourites">
    <h1 class="center-title">Favourites</h1>

        @foreach($favourites as $favourite)
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4">
                    <a href="{{ url('result?barcode=' . $favourite->barcode) }}">
                        {{ $favourite->barcode }}
                    </a>
                </h2>
            </div>
        @endforeach
</x-layout>