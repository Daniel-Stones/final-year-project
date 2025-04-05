<x-layout :title="'Scan Barcode'">
    <h1 class="center-title text-2xl text-center mb-4">Scan a barcode</h1>

    <div>
        <div id="scanner-container" class="border rounded shadow-md mx-auto mb-4" style="width: 640px; height: 480px; position: relative;">
        </div>

        <div class="text-center">
            <button id="scanner-toggle" type="button" class="bordered-submit-button">Start scanning</button>
            <p class="mt-3">Result: <span id="result">None</span></p>
            <p id="barcode-found" class="text-green-600 font-bold hidden mt-2">✅ Barcode Found!</p>
        </div>
    </div>

    <style>
        canvas.drawing, canvas.drawingBuffer {
            position: absolute;
            left: 0;
            top: 0;
        }
    </style>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/quagga@0.12.1/dist/quagga.min.js"></script>
    <script src="{{ asset('js/barcode_scan.js') }}"></script>
</x-layout>
