@extends('layouts.app')

@section('title', 'QR Reader & Generator - GameGrid')

@section('content')
    <div class="page-shell">
        <div class="container-custom">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card p-4 mb-4">
                        <h1 class="mb-3">QR Code Reader</h1>
                        <p class="text-muted">Scan a product QR code to open its detail page. If your browser supports QR scanning, the camera feed will be used automatically.</p>

                        <div class="ratio ratio-16x9 bg-dark rounded overflow-hidden mb-3">
                            <video id="qrVideo" autoplay playsinline class="w-100 h-100"></video>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" id="qrResult" class="form-control" placeholder="Scanned value will appear here">
                            <button class="btn btn-primary" id="openQrBtn" type="button">Open</button>
                        </div>

                        <div id="qrStatus" class="alert alert-info">Camera not started yet.</div>
                    </div>

                    <div class="card p-4 mb-4">
                        <h2 class="mb-3">QR Code Generator</h2>
                        <p class="text-muted mb-4">These QR codes point to your real product pages, so you can show them from your phone and open the product on any device.</p>

                        <div class="row g-4">
                            @foreach($products as $product)
                                @php
                                    $qrTarget = route('products.show.slug', $product->slug);
                                    $qrImage = 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=' . urlencode($qrTarget);
                                @endphp
                                <div class="col-md-6">
                                    <div class="border rounded p-3 h-100 text-center">
                                        <img src="{{ $qrImage }}" alt="QR for {{ $product->name }}" class="img-fluid mb-3" style="max-width: 220px;">
                                        <h5 class="mb-1">{{ $product->name }}</h5>
                                        <p class="text-muted mb-2">{{ $product->category->name }}</p>
                                        <div class="small text-break mb-3">{{ $qrTarget }}</div>
                                        <a href="{{ $qrTarget }}" class="btn btn-outline-primary btn-sm" target="_blank">Open Product</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
    <script>
        (function () {
            const video = document.getElementById('qrVideo');
            const result = document.getElementById('qrResult');
            const status = document.getElementById('qrStatus');
            const openButton = document.getElementById('openQrBtn');
            const canvas = document.createElement('canvas');
            const canvasContext = canvas.getContext('2d', { willReadFrequently: true });
            let detectedValue = null;

            openButton.addEventListener('click', function () {
                const value = result.value.trim();
                if (!value) return;
                window.location.href = value.startsWith('http') ? value : '/products/' + value;
            });

            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                status.textContent = 'Camera scanning is not supported in this browser.';
                return;
            }

            navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
                .then(function (stream) {
                    video.srcObject = stream;
                    status.textContent = 'Point the camera at a QR code.';

                    const onDetected = function (value) {
                        if (!value || detectedValue === value) {
                            return;
                        }

                        detectedValue = value;
                        result.value = value;
                        status.textContent = 'QR code detected.';
                    };

                    if ('BarcodeDetector' in window) {
                        const detector = new BarcodeDetector({ formats: ['qr_code'] });
                        const scan = async () => {
                            try {
                                const barcodes = await detector.detect(video);
                                if (barcodes.length > 0) {
                                    onDetected(barcodes[0].rawValue);
                                }
                            } catch (error) {
                                status.textContent = 'QR scan failed: ' + error.message;
                            }
                            requestAnimationFrame(scan);
                        };
                        requestAnimationFrame(scan);
                    } else {
                        status.textContent = 'Using compatibility scanner...';

                        const scanWithJsQr = function () {
                            if (video.readyState === video.HAVE_ENOUGH_DATA && canvasContext) {
                                canvas.width = video.videoWidth;
                                canvas.height = video.videoHeight;
                                canvasContext.drawImage(video, 0, 0, canvas.width, canvas.height);

                                const imageData = canvasContext.getImageData(0, 0, canvas.width, canvas.height);
                                const code = window.jsQR ? window.jsQR(imageData.data, imageData.width, imageData.height) : null;

                                if (code && code.data) {
                                    onDetected(code.data);
                                }
                            }

                            requestAnimationFrame(scanWithJsQr);
                        };

                        requestAnimationFrame(scanWithJsQr);
                    }
                })
                .catch(function () {
                    status.textContent = 'Camera access was denied or unavailable.';
                });
        })();
    </script>
@endsection