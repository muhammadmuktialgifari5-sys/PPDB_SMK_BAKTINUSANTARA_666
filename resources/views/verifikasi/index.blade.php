@extends('layouts.app')

@section('title', 'Verifikasi Administrasi')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Verifikasi Administrasi</h2>
        <div class="text-sm text-gray-600">
            Total: {{ $pendaftar->total() }} pendaftar
            @if(request('gelombang'))
            <span class="ml-2 px-2 py-1 bg-purple-100 text-purple-800 rounded text-xs">Gelombang {{ request('gelombang') }}</span>
            @endif
        </div>
    </div>
    
    <!-- Statistik Singkat -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        @php
        $stats = [
            'SUBMIT' => ['label' => 'Menunggu', 'color' => 'yellow'],
            'PAID' => ['label' => 'Sudah Bayar', 'color' => 'blue'],
            'ADM_PASS' => ['label' => 'Lulus', 'color' => 'green'],
            'ADM_REJECT' => ['label' => 'Ditolak', 'color' => 'red'],
            'PAYMENT_VERIFIED' => ['label' => 'Verified', 'color' => 'purple']
        ];
        @endphp
        @foreach($stats as $status => $info)
        <div class="bg-{{ $info['color'] }}-50 border border-{{ $info['color'] }}-200 rounded p-3 text-center">
            <div class="text-{{ $info['color'] }}-600 font-bold text-lg">{{ $allPendaftar->where('status', $status)->count() }}</div>
            <div class="text-{{ $info['color'] }}-600 text-xs">{{ $info['label'] }}</div>
        </div>
        @endforeach
    </div>
    
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
    @endif
    
    <!-- Filter Form -->
    <form method="GET" class="mb-6 p-4 bg-gray-50 rounded">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="">Semua Status</option>
                    <option value="SUBMIT" {{ request('status') == 'SUBMIT' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="PAID" {{ request('status') == 'PAID' ? 'selected' : '' }}>Sudah Bayar</option>
                    <option value="ADM_PASS" {{ request('status') == 'ADM_PASS' ? 'selected' : '' }}>Lulus Verifikasi</option>
                    <option value="ADM_REJECT" {{ request('status') == 'ADM_REJECT' ? 'selected' : '' }}>Ditolak</option>
                    <option value="PAYMENT_VERIFIED" {{ request('status') == 'PAYMENT_VERIFIED' ? 'selected' : '' }}>Pembayaran Terverifikasi</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gelombang</label>
                <select name="gelombang" class="w-full border rounded px-3 py-2">
                    <option value="">Semua Gelombang</option>
                    @foreach($gelombang as $g)
                    <option value="{{ $g->id }}" {{ request('gelombang') == $g->id ? 'selected' : '' }}>{{ $g->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                <select name="jurusan_id" class="w-full border rounded px-3 py-2">
                    <option value="">Semua Jurusan</option>
                    @foreach($jurusan as $j)
                    <option value="{{ $j->id }}" {{ request('jurusan_id') == $j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama/NIK/No. Pendaftaran" class="w-full border rounded px-3 py-2">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Filter
                </button>
                <a href="{{ route('verifikasi.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Reset
                </a>
            </div>
        </div>
    </form>
    
    <!-- Bulk Actions -->
    <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded" id="bulkActions" style="display: none;">
        <form id="bulkForm" method="POST" action="{{ route('verifikasi.bulk') }}">
            @csrf
            <div class="flex items-center gap-4">
                <span class="text-sm font-medium">Aksi untuk <span id="selectedCount">0</span> pendaftar terpilih:</span>
                <select name="status" class="border rounded px-3 py-1" required>
                    <option value="">Pilih Status</option>
                    <option value="ADM_PASS">Lulus Verifikasi</option>
                    <option value="ADM_REJECT">Tolak</option>
                </select>
                <input type="text" name="catatan" placeholder="Catatan (opsional)" class="border rounded px-3 py-1">
                <button type="submit" class="bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700">
                    Verifikasi Terpilih
                </button>
                <button type="button" onclick="clearSelection()" class="bg-gray-500 text-white px-4 py-1 rounded hover:bg-gray-600">
                    Batal
                </button>
            </div>
        </form>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full border text-sm">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border p-2 w-12">
                        <input type="checkbox" id="selectAll" onchange="toggleAll()">
                    </th>
                    <th class="border p-2">No. Reg</th>
                    <th class="border p-2">Nama Siswa</th>
                    <th class="border p-2">Jurusan</th>
                    <th class="border p-2">Pembayaran</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendaftar as $p)
                <tr>
                    <td class="border p-2 text-center">
                        @if(in_array($p->status, ['SUBMIT', 'PAID']))
                        <input type="checkbox" name="pendaftar_ids[]" value="{{ $p->id }}" class="pendaftar-checkbox" onchange="updateSelection()">
                        @endif
                    </td>
                    <td class="border p-2 font-mono text-sm">{{ $p->no_pendaftaran }}</td>
                    <td class="border p-2">
                        <div class="flex items-center gap-2">
                            @if($p->dataSiswa && $p->dataSiswa->foto)
                            <img src="{{ asset('storage/' . $p->dataSiswa->foto) }}" alt="{{ $p->dataSiswa->nama }}" class="w-8 h-8 rounded-full object-cover">
                            @else
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            @endif
                            <div>
                                <div class="font-medium">{{ $p->dataSiswa->nama ?? 'Belum diisi' }}</div>
                                <div class="text-gray-500 text-xs">{{ $p->dataSiswa->nik ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="border p-2">
                        <div class="font-medium text-sm">{{ $p->jurusan->nama ?? '-' }}</div>
                        <div class="text-gray-500 text-xs">{{ $p->gelombang->nama ?? '-' }}</div>
                    </td>
                    <td class="border p-2">
                        @if($p->pembayaran)
                        <div class="space-y-1">
                            <div class="text-green-600 font-medium">Rp {{ number_format($p->pembayaran->nominal ?? $p->pembayaran->jumlah ?? 0, 0, ',', '.') }}</div>
                            <div class="text-gray-600 text-xs">{{ $p->pembayaran->metode_pembayaran ?? 'Transfer Bank' }}</div>
                            <div class="text-gray-600 text-xs">{{ $p->pembayaran->tanggal_bayar ?? $p->pembayaran->created_at->format('d/m/Y') }}</div>
                            <div class="text-xs">
                                @if($p->pembayaran->status == 'VERIFIED')
                                <span class="text-green-600 font-semibold">✅ Terverifikasi</span>
                                @elseif($p->pembayaran->status == 'REJECTED')
                                <span class="text-red-600 font-semibold">❌ Ditolak</span>
                                @else
                                <span class="text-yellow-600 font-semibold">⏳ Menunggu Verifikasi</span>
                                @endif
                            </div>
                            @if($p->pembayaran->bukti_bayar)
                            <a href="{{ Storage::url($p->pembayaran->bukti_bayar) }}" target="_blank" class="text-blue-600 text-xs underline">📄 Lihat Bukti</a>
                            @endif
                        </div>
                        @else
                        <span class="text-red-500 text-xs">Belum bayar</span>
                        @endif
                    </td>
                    <td class="border p-2">
                        @php
                        $statusColors = [
                            'SUBMIT' => 'bg-yellow-100 text-yellow-800',
                            'ADM_PASS' => 'bg-green-100 text-green-800',
                            'ADM_REJECT' => 'bg-red-100 text-red-800',
                            'PAID' => 'bg-blue-100 text-blue-800',
                            'PAYMENT_VERIFIED' => 'bg-purple-100 text-purple-800'
                        ];
                        @endphp
                        <span class="px-2 py-1 rounded text-xs {{ $statusColors[$p->status] ?? 'bg-gray-100' }}">{{ $p->status }}</span>
                    </td>
                    <td class="border p-2">
                        <button onclick="showDetail({{ $p->id }}, '{{ $p->status }}')" class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700 font-semibold w-full">
                            👁 Lihat Detail & Verifikasi
                        </button>
                        @if($p->user_verifikasi_adm)
                        <div class="text-xs text-gray-500 mt-1 text-center">oleh: {{ $p->user_verifikasi_adm }}</div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $pendaftar->appends(request()->query())->links() }}
    </div>
</div>

<!-- Modal Detail -->
<div id="detailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-4xl w-full max-h-screen overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">Detail Pendaftar</h3>
                    <button onclick="closeDetail()" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="detailContent">
                    <!-- Content will be loaded here -->
                </div>
                <div id="verifikasiForm" class="mt-6 border-t pt-4" style="display: none;">
                    <h4 class="font-bold text-lg mb-3">Form Verifikasi</h4>
                    <form id="formVerifikasi" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status Verifikasi</label>
                                <div class="flex gap-4">
                                    <label class="flex items-center">
                                        <input type="radio" name="status" value="ADM_PASS" class="mr-2" required>
                                        <span class="text-green-600 font-semibold">✓ Terima / Lulus Verifikasi</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="status" value="ADM_REJECT" class="mr-2" required>
                                        <span class="text-red-600 font-semibold">✗ Tolak / Tidak Lulus</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                                <textarea name="catatan" rows="3" class="w-full border rounded px-3 py-2" placeholder="Berikan catatan jika diperlukan..."></textarea>
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 font-semibold">
                                    Simpan Verifikasi
                                </button>
                                <button type="button" onclick="closeDetail()" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentPendaftarId = null;

function showDetail(id, status) {
    currentPendaftarId = id;
    document.getElementById('detailModal').classList.remove('hidden');
    document.getElementById('detailContent').innerHTML = '<div class="text-center py-8"><div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div><p class="mt-4 text-gray-600">Memuat data...</p></div>';
    
    // Show/hide verification form based on status
    const verifikasiForm = document.getElementById('verifikasiForm');
    if (status === 'SUBMIT' || status === 'PAID') {
        verifikasiForm.style.display = 'block';
        document.getElementById('formVerifikasi').action = `/verifikasi/${id}`;
    } else {
        verifikasiForm.style.display = 'none';
    }
    
    fetch(`/verifikasi/${id}/detail`)
        .then(response => response.json())
        .then(data => {
            let html = `
                <div class="space-y-6">
                    <div class="border-b pb-4">
                        <h4 class="font-bold text-lg mb-3 text-blue-600">Data Siswa</h4>
                        <div class="grid grid-cols-2 gap-4">
                            ${data.dataSiswa.foto ? `<div class="col-span-2"><img src="/storage/${data.dataSiswa.foto}" class="w-32 h-32 object-cover rounded-lg border"></div>` : ''}
                            <div><span class="text-gray-600">Nama:</span> <strong>${data.dataSiswa.nama || '-'}</strong></div>
                            <div><span class="text-gray-600">NIK:</span> <strong>${data.dataSiswa.nik || '-'}</strong></div>
                            <div><span class="text-gray-600">Tempat Lahir:</span> ${data.dataSiswa.tempat_lahir || '-'}</div>
                            <div><span class="text-gray-600">Tanggal Lahir:</span> ${data.dataSiswa.tanggal_lahir || '-'}</div>
                            <div><span class="text-gray-600">Jenis Kelamin:</span> ${data.dataSiswa.jenis_kelamin || '-'}</div>
                            <div><span class="text-gray-600">Agama:</span> ${data.dataSiswa.agama || '-'}</div>
                            <div class="col-span-2"><span class="text-gray-600">Alamat:</span> ${data.dataSiswa.alamat || '-'}</div>
                            <div><span class="text-gray-600">No. HP:</span> ${data.dataSiswa.no_hp || '-'}</div>
                            <div><span class="text-gray-600">Email:</span> ${data.dataSiswa.email || '-'}</div>
                        </div>
                    </div>
                    <div class="border-b pb-4">
                        <h4 class="font-bold text-lg mb-3 text-blue-600">Data Orang Tua/Wali</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div><span class="text-gray-600">Nama Ayah:</span> ${data.dataOrtu.nama_ayah || '-'}</div>
                            <div><span class="text-gray-600">Pekerjaan Ayah:</span> ${data.dataOrtu.pekerjaan_ayah || '-'}</div>
                            <div><span class="text-gray-600">Nama Ibu:</span> ${data.dataOrtu.nama_ibu || '-'}</div>
                            <div><span class="text-gray-600">Pekerjaan Ibu:</span> ${data.dataOrtu.pekerjaan_ibu || '-'}</div>
                            <div><span class="text-gray-600">No. HP Ortu:</span> ${data.dataOrtu.no_hp_ortu || '-'}</div>
                            <div><span class="text-gray-600">Penghasilan:</span> ${data.dataOrtu.penghasilan_ortu || '-'}</div>
                        </div>
                    </div>
                    <div class="border-b pb-4">
                        <h4 class="font-bold text-lg mb-3 text-blue-600">Asal Sekolah</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div><span class="text-gray-600">Nama Sekolah:</span> ${data.asalSekolah.nama_sekolah || '-'}</div>
                            <div><span class="text-gray-600">NPSN:</span> ${data.asalSekolah.npsn || '-'}</div>
                            <div class="col-span-2"><span class="text-gray-600">Alamat Sekolah:</span> ${data.asalSekolah.alamat_sekolah || '-'}</div>
                            <div><span class="text-gray-600">Tahun Lulus:</span> ${data.asalSekolah.tahun_lulus || '-'}</div>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg mb-3 text-blue-600">Berkas Pendaftaran</h4>
                        <div class="grid grid-cols-2 gap-2">
                            ${data.berkas.map(b => `
                                <div class="flex items-center gap-2 p-2 bg-gray-50 rounded">
                                    <span class="text-sm">${b.jenis_berkas}:</span>
                                    ${b.file_path ? `<a href="/storage/${b.file_path}" target="_blank" class="text-blue-600 text-sm underline">Lihat</a>` : '<span class="text-red-500 text-sm">Belum upload</span>'}
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('detailContent').innerHTML = html;
        })
        .catch(error => {
            document.getElementById('detailContent').innerHTML = '<div class="text-center text-red-600 py-4">Gagal memuat data</div>';
        });
}

// Handle form submission
document.getElementById('formVerifikasi').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const status = formData.get('status');
    const statusText = status === 'ADM_PASS' ? 'DITERIMA' : 'DITOLAK';
    
    if (!confirm(`Yakin ingin memverifikasi pendaftar ini dengan status ${statusText}?`)) {
        return;
    }
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Verifikasi berhasil disimpan!');
            window.location.reload();
        } else {
            alert('Gagal menyimpan verifikasi: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        alert('Terjadi kesalahan saat menyimpan verifikasi');
        console.error(error);
    });
});

function closeDetail() {
    document.getElementById('detailModal').classList.add('hidden');
    document.getElementById('formVerifikasi').reset();
    currentPendaftarId = null;
}

function toggleAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.pendaftar-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    
    updateSelection();
}

function updateSelection() {
    const checkboxes = document.querySelectorAll('.pendaftar-checkbox:checked');
    const count = checkboxes.length;
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');
    
    selectedCount.textContent = count;
    
    if (count > 0) {
        bulkActions.style.display = 'block';
        // Add selected IDs to bulk form
        const bulkForm = document.getElementById('bulkForm');
        // Remove existing hidden inputs
        bulkForm.querySelectorAll('input[name="pendaftar_ids[]"]').forEach(input => input.remove());
        
        // Add new hidden inputs
        checkboxes.forEach(checkbox => {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'pendaftar_ids[]';
            hiddenInput.value = checkbox.value;
            bulkForm.appendChild(hiddenInput);
        });
    } else {
        bulkActions.style.display = 'none';
    }
    
    // Update select all checkbox
    const allCheckboxes = document.querySelectorAll('.pendaftar-checkbox');
    const selectAll = document.getElementById('selectAll');
    selectAll.checked = allCheckboxes.length > 0 && count === allCheckboxes.length;
}

function clearSelection() {
    document.querySelectorAll('.pendaftar-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('selectAll').checked = false;
    updateSelection();
}

// Confirm bulk action
document.getElementById('bulkForm').addEventListener('submit', function(e) {
    const count = document.querySelectorAll('.pendaftar-checkbox:checked').length;
    const status = this.querySelector('select[name="status"]').value;
    const statusText = status === 'ADM_PASS' ? 'Lulus Verifikasi' : 'Ditolak';
    
    if (!confirm(`Yakin ingin memverifikasi ${count} pendaftar dengan status "${statusText}"?`)) {
        e.preventDefault();
    }
});
</script>
@endsection
