<x-layout :title="'Product Result'">
    <h1 class="text-2xl text-center mb-8">Scanned Product</h1>

    @if($product)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-4 max-w-5xl mx-auto">
            <!-- Product Info -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Product Info</h2>
                <p><strong>Name:</strong> {{ $product['product_name'] ?? 'No name found' }}</p>
                <p><strong>Packaging:</strong> {{ $product['packaging'] ?? 'Unknown' }}</p>
                <p><strong>Labels:</strong> {{ !empty($product['labels_tags']) ? implode(', ', $product['labels_tags']) : 'None' }}</p>
                <p><strong>Origin:</strong> {{ $product['origins'] ?? 'Unknown' }}</p>
                <p><strong>Ingredients:</strong> {{ $product['ingredients_text'] ?? 'Not available' }}</p>
            </div>

            <!-- Sustainability Info -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Sustainability Score</h2>
                <ul class="list-none pl-0 text-gray-700 space-y-3 mb-4">
                    <!-- Packaging Bar -->
                    <li class="flex items-center space-x-3">
                        <span class="w-32">{{ $scores['packaging']['text'] }}</span>
                        <div class="flex-1 h-4 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-default-green transition-all duration-300 ease-in-out" style="width: {{ $scores['packaging']['percent'] }}%"></div>
                        </div>
                    </li>
                    <!-- Palm Oil Bar -->
                    <li class="flex items-center space-x-3">
                        <span class="w-32">{{ $scores['palm_oil']['text'] }}</span>
                        <div class="flex-1 h-4 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-default-green transition-all duration-300 ease-in-out" style="width: {{ $scores['palm_oil']['percent'] }}%"></div>
                        </div>
                    </li>
                    <!-- Organic Bar -->
                    <li class="flex items-center space-x-3">
                        <span class="w-32">{{ $scores['organic']['text'] }}</span>
                        <div class="flex-1 h-4 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-default-green transition-all duration-300 ease-in-out" style="width: {{ $scores['organic']['percent'] }}%"></div>
                        </div>
                    </li>
                    <!-- Origin Bar -->
                    <li class="flex items-center space-x-3">
                        <span class="w-32">{{ $scores['origin']['text'] }}</span>
                        <div class="flex-1 h-4 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-default-green transition-all duration-300 ease-in-out" style="width: {{ $scores['origin']['percent'] }}%"></div>
                        </div>
                    </li>

                </ul>
                <p id="overall-score" class="font-semibold mb-2 text-center">Overall Score: {{ $totalScore }}/10</p>
                <div class="w-full h-6 bg-gray-200 rounded-full overflow-hidden border border-black">
                    <div id="score-bar" class="h-full bg-default-green transition-all duration-300 ease-in-out" style="width: {{ $totalScore * 10 }}%"></div>
                </div>
            </div>
        </div>
    @else
        <p class="text-center text-red-600 font-bold">Product not found. Please try again.</p>
    @endif
</x-layout>