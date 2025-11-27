<!DOCTYPE html>
<html>
<head>
    <title>Kartu Pendaftaran - {{ $pendaftar->no_pendaftaran }}</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; max-width: 800px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 3px solid #1e40af; padding-bottom: 10px; }
        .header h1 { color: #1e40af; margin: 10px 0; }
        .header h2 { color: #1e3a8a; margin: 5px 0; }
        .header h3, .header h4 { color: #666; margin: 5px 0; font-weight: normal; }
        .content { margin: 20px 0; }
        .row { display: flex; margin-bottom: 10px; }
        .label { width: 200px; font-weight: bold; color: #333; }
        .value { flex: 1; color: #555; }
        h3 { color: #1e40af; padding-bottom: 5px; }
        button { background: #1e40af; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        button:hover { background: #1e3a8a; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="no-print">Cetak</button>
    
    <div class="header">
        <img src="{{ asset('images/bn666.png') }}" alt="Logo SMK" style="width: 80px; height: 80px; object-fit: contain; margin: 0 auto 10px; display: block;">
        <h1>SMK BAKTI NUSANTARA 666</h1>
        <h2>KARTU PENDAFTARAN</h2>
        <h3>SISTEM PENERIMAAN MAHASISWA BARU</h3>
        <h4>Tahun {{ $pendaftar->gelombang->tahun }}</h4>
    </div>

    <div class="content">
        <div class="row">
            <div class="label">No. Pendaftaran</div>
            <div class="value">: {{ $pendaftar->no_pendaftaran }}</div>
        </div>
        <div class="row">
            <div class="label">Tanggal Daftar</div>
            <div class="value">: {{ $pendaftar->tanggal_daftar->format('d F Y') }}</div>
        </div>
        <div class="row">
            <div class="label">Gelombang</div>
            <div class="value">: {{ $pendaftar->gelombang->nama }}</div>
        </div>
        <div class="row">
            <div class="label">Jurusan Pilihan</div>
            <div class="value">: {{ $pendaftar->jurusan->nama }}</div>
        </div>

        <h3 style="margin-top: 30px; border-bottom: 2px solid #000;">DATA SISWA</h3>
        <div style="display: flex; gap: 30px; margin-bottom: 20px;">
            <div style="flex: 1;">
                <div class="row">
                    <div class="label">Nama Lengkap</div>
                    <div class="value">: {{ $pendaftar->dataSiswa->nama }}</div>
                </div>
            </div>
            <div style="width: 120px; text-align: center;">
                <img src="{{ $pendaftar->dataSiswa->foto ? asset('storage/' . $pendaftar->dataSiswa->foto) : asset('images/default-avatar.png') }}" alt="Pas Foto" style="width: 90px; height: 120px; object-fit: cover; border: 2px solid #333; margin-bottom: 5px;">
                <div style="font-size: 10px; color: #666;">Pas Foto 3x4</div>
            </div>
        </div>
        <div class="row">
            <div class="label">NIK</div>
            <div class="value">: {{ $pendaftar->dataSiswa->nik }}</div>
        </div>
        <div class="row">
            <div class="label">NISN</div>
            <div class="value">: {{ $pendaftar->dataSiswa->nisn }}</div>
        </div>
        <div class="row">
            <div class="label">Jenis Kelamin</div>
            <div class="value">: {{ $pendaftar->dataSiswa->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
        </div>
        <div class="row">
            <div class="label">Tempat, Tanggal Lahir</div>
            <div class="value">: {{ $pendaftar->dataSiswa->tmp_lahir }}, {{ $pendaftar->dataSiswa->tgl_lahir->format('d F Y') }}</div>
        </div>
        <div class="row">
            <div class="label">Alamat</div>
            <div class="value">: {{ $pendaftar->dataSiswa->alamat }}</div>
        </div>

        <h3 style="margin-top: 30px; border-bottom: 2px solid #000;">ASAL SEKOLAH</h3>
        <div class="row">
            <div class="label">Nama Sekolah</div>
            <div class="value">: {{ $pendaftar->asalSekolah->nama_sekolah }}</div>
        </div>

        <div style="margin-top: 50px; text-align: right;">
            <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
