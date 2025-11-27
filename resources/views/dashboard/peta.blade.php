@extends('layouts.app')

@section('title', 'Peta Sebaran Pendaftar')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Peta Sebaran Pendaftar</h2>
        <div class="text-sm text-gray-600">
            Total: {{ $pendaftar->count() }} pendaftar dengan lokasi
        </div>
    </div>
    
    <!-- Statistik per Jurusan -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        @php
        $perJurusan = $pendaftar->groupBy('jurusan.nama');
        $colors = ['blue', 'green', 'red', 'purple', 'yellow', 'pink'];
        @endphp
        @foreach($perJurusan as $jurusan => $data)
        <div class="bg-{{ $colors[$loop->index % count($colors)] }}-50 border border-{{ $colors[$loop->index % count($colors)] }}-200 rounded p-3 text-center">
            <div class="text-{{ $colors[$loop->index % count($colors)] }}-600 font-bold text-lg">{{ $data->count() }}</div>
            <div class="text-{{ $colors[$loop->index % count($colors)] }}-600 text-xs">{{ $jurusan }}</div>
        </div>
        @endforeach
    </div>
    
    <!-- Kontrol Peta -->
    <div class="mb-4 flex flex-wrap gap-2">
        <button onclick="resetView()" class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
            Reset View
        </button>
        <button onclick="toggleMarkers()" class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">
            Toggle Markers
        </button>
        <span class="text-sm text-gray-600 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"/>
            </svg>
            Klik dan geser untuk navigasi
        </span>
    </div>
    
    <!-- Peta -->
    <div class="mb-4">
        <div id="map" style="height: 500px; width: 100%;" class="rounded border shadow-lg"></div>
    </div>
    
    <!-- Legend -->
    <div class="bg-gray-50 p-4 rounded">
        <h4 class="font-bold mb-2">Keterangan:</h4>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-sm">
            @foreach($perJurusan as $jurusan => $data)
            <div class="flex items-center">
                <div class="w-4 h-4 rounded-full bg-{{ $colors[$loop->index % count($colors)] }}-500 mr-2"></div>
                <span>{{ $jurusan }} ({{ $data->count() }})</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// Inisialisasi peta dengan opsi interaksi lengkap
var map = L.map('map', {
    center: [-2.5489, 118.0149], // Indonesia sebagai center
    zoom: 5,
    dragging: true,
    touchZoom: true,
    doubleClickZoom: true,
    scrollWheelZoom: true,
    boxZoom: true,
    keyboard: true,
    zoomControl: true
});

// Tambahkan tile layer dengan opsi yang lebih baik
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors',
    maxZoom: 18,
    minZoom: 3
}).addTo(map);

// Data pendaftar
var pendaftarData = @json($pendaftar);

// Warna untuk setiap jurusan
var jurusanColors = {
    @foreach($perJurusan as $jurusan => $data)
    '{{ $jurusan }}': '{{ $colors[$loop->index % count($colors)] }}',
    @endforeach
};

// Tambahkan marker untuk setiap pendaftar
pendaftarData.forEach(function(pendaftar) {
    if (pendaftar.data_siswa && pendaftar.data_siswa.lat && pendaftar.data_siswa.lng) {
        var lat = parseFloat(pendaftar.data_siswa.lat);
        var lng = parseFloat(pendaftar.data_siswa.lng);
        var jurusan = pendaftar.jurusan.nama;
        var color = jurusanColors[jurusan] || 'gray';
        
        // Buat custom icon berdasarkan jurusan
        var customIcon = L.divIcon({
            className: 'custom-marker',
            html: `<div style="background-color: var(--tw-${color}-500, #6b7280); width: 12px; height: 12px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>`,
            iconSize: [16, 16],
            iconAnchor: [8, 8]
        });
        
        // Tambahkan marker
        var marker = L.marker([lat, lng], { icon: customIcon }).addTo(map);
        
        // Simpan marker untuk kontrol
        allMarkers.push(marker);
        
        // Popup info yang lebih interaktif
        marker.bindPopup(`
            <div class="text-sm p-2">
                <div class="font-bold text-lg text-blue-600">${pendaftar.data_siswa.nama}</div>
                <div class="text-gray-600 mb-1">📋 ${pendaftar.no_pendaftaran}</div>
                <div class="text-green-600 mb-1">🎓 ${jurusan}</div>
                <div class="text-purple-600 mb-1">🏙️ ${pendaftar.data_siswa.kota || 'Tidak diketahui'}</div>
                <div class="text-gray-500 mb-2">📍 ${pendaftar.data_siswa.alamat}</div>
                <div class="text-xs text-gray-400">Lat: ${lat.toFixed(4)}, Lng: ${lng.toFixed(4)}</div>
            </div>
        `, {
            maxWidth: 250,
            className: 'custom-popup'
        });
    }
});

// Fit map ke semua marker dengan kontrol yang lebih baik
if (pendaftarData.length > 0) {
    var group = new L.featureGroup();
    pendaftarData.forEach(function(pendaftar) {
        if (pendaftar.data_siswa && pendaftar.data_siswa.lat && pendaftar.data_siswa.lng) {
            group.addLayer(L.marker([pendaftar.data_siswa.lat, pendaftar.data_siswa.lng]));
        }
    });
    
    if (group.getLayers().length > 0) {
        // Fit bounds dengan padding dan max zoom
        map.fitBounds(group.getBounds(), {
            padding: [20, 20],
            maxZoom: 12
        });
    }
}

// Tambahkan kontrol fullscreen (opsional)
map.addControl(new L.Control.Zoom({
    position: 'topright'
}));

// Variabel untuk kontrol markers
var allMarkers = [];
var markersVisible = true;

// Fungsi untuk reset view
function resetView() {
    if (pendaftarData.length > 0) {
        var group = new L.featureGroup(allMarkers);
        map.fitBounds(group.getBounds(), {
            padding: [20, 20],
            maxZoom: 12
        });
    } else {
        map.setView([-2.5489, 118.0149], 5);
    }
}

// Fungsi untuk toggle markers
function toggleMarkers() {
    if (markersVisible) {
        allMarkers.forEach(function(marker) {
            map.removeLayer(marker);
        });
        markersVisible = false;
        document.querySelector('button[onclick="toggleMarkers()"]').textContent = 'Show Markers';
    } else {
        allMarkers.forEach(function(marker) {
            map.addLayer(marker);
        });
        markersVisible = true;
        document.querySelector('button[onclick="toggleMarkers()"]').textContent = 'Hide Markers';
    }
}
</script>

<style>
.custom-marker {
    background: transparent !important;
    border: none !important;
}

/* Pastikan peta bisa diinteraksi */
#map {
    cursor: grab;
}

#map:active {
    cursor: grabbing;
}

/* Style untuk kontrol peta */
.leaflet-control-zoom {
    border: none !important;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2) !important;
}

.leaflet-control-zoom a {
    background-color: white !important;
    color: #333 !important;
    border: none !important;
    width: 35px !important;
    height: 35px !important;
    line-height: 35px !important;
    font-size: 18px !important;
    font-weight: bold !important;
}

.leaflet-control-zoom a:hover {
    background-color: #f0f0f0 !important;
}

/* Responsive map */
@media (max-width: 768px) {
    #map {
        height: 400px !important;
    }
}

/* Custom popup styling */
.custom-popup .leaflet-popup-content-wrapper {
    border-radius: 8px !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
}

.custom-popup .leaflet-popup-content {
    margin: 0 !important;
    padding: 0 !important;
}

.custom-popup .leaflet-popup-tip {
    background: white !important;
}
</style>
@endsection