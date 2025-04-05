document.addEventListener('DOMContentLoaded', function () {
    let scannerIsRunning = false;

    const toggleButton = document.getElementById('scanner-toggle');
    if (!toggleButton) {
        console.error('Scanner toggle button not found in DOM');
        return;
    }

    toggleButton.addEventListener('click', function () {
        if (scannerIsRunning) {
            stopScanner();
        } else {
            startScanner();
        }
    });

    function startScanner() {
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector('#scanner-container'),
                constraints: { width: 640, height: 480, facingMode: "environment" }
            },
            decoder: {
                readers: ["ean_reader"]
            },
            locate: true,
            locator: { patchSize: "medium", halfSample: true },
            numOfWorkers: navigator.hardwareConcurrency || 4,
            frequency: 10
        }, function (err) {
            if (err) {
                console.error(err);
                alert("Error initializing scanner: " + err);
                return;
            }
            console.log("Scanner started");
            Quagga.start();
            scannerIsRunning = true;
            document.getElementById('scanner-toggle').textContent = "Stop scanning";
        });

        Quagga.onDetected(function (result) {
            const code = result.codeResult.code;
            console.log("Barcode detected:", code);
            document.getElementById('result').textContent = code;
            stopScanner();
        });
    }

    function stopScanner() {
        if (scannerIsRunning) {
            Quagga.stop();
            scannerIsRunning = false;
            document.getElementById('scanner-toggle').textContent = "Start scanning";

            // Clear canvas overlays
            const overlayCanvas = document.querySelector('#scanner-container canvas');
            if (overlayCanvas) {
                const ctx = overlayCanvas.getContext('2d');
                ctx.clearRect(0, 0, overlayCanvas.width, overlayCanvas.height);
            }

            console.log("Scanner stopped");
        }
    }
});