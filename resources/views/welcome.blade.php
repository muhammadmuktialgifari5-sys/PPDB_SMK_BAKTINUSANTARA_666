<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPMB - SMK Bakti Nusantara 666</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-image: url('/images/gedungpk.jpeg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.5);
            z-index: -1;
        }

        .gradient-primary {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
        }

        .gradient-hero {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 50%, #bfdbfe 100%);
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-scroll {
            animation: scroll 77s linear infinite;
            will-change: transform;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="antialiased">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm fixed w-full top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <img src="/images/bn666.png" alt="Logo SMK" class="w-12 h-12 object-contain">
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">SMK Bakti Nusantara 666</h1>
                        <p class="text-xs text-gray-500">Sistem Penerimaan Mahasiswa Baru</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('login') }}"
                        class="text-gray-700 hover:text-blue-700 px-4 py-2 rounded-lg font-semibold transition">Masuk</a>
                    <a href="{{ route('register') }}"
                        class="gradient-primary text-white px-6 py-2 rounded-lg font-semibold hover:shadow-lg transition transform hover:scale-105">Daftar
                        Sekarang</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20"
        style="background-image: url('/images/gedungpk.jpeg'); background-size: cover; background-position: center; position: relative;">
        <div
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(239, 246, 255, 0.5);">
        </div>
        <div class="container mx-auto px-6" style="position: relative; z-index: 1;">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <div
                        class="inline-block bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-semibold mb-6 shadow-lg">
                        🎓 Pendaftaran Dibuka!
                    </div>
                    <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 mb-6 leading-tight">
                        SMK <span class="text-blue-700">BAKTI NUSANTARA 666</span>
                    </h1>
                    <p class="text-xl text-gray-700 mb-8 leading-relaxed">
                        Bergabunglah dengan SMK Bakti Nusantara 666 dan raih kesempatan untuk mengembangkan potensi diri
                        dengan pendidikan berkualitas.
                    </p>
                    <div class="flex gap-4">
                        <a href="{{ route('register') }}"
                            class="gradient-primary text-white px-8 py-4 rounded-xl font-bold text-lg hover:shadow-2xl transition transform hover:scale-105 inline-flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                    clip-rule="evenodd" />
                            </svg>
                            Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}"
                            class="bg-white text-gray-800 px-8 py-4 rounded-xl font-bold text-lg hover:shadow-xl transition border-2 border-gray-200 inline-flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Login
                        </a>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="relative">
                        <div class="absolute inset-0 bg-blue-600 rounded-3xl transform rotate-6 opacity-20"></div>
                        <div class="relative rounded-3xl shadow-2xl p-8 animate-float bg-white border border-gray-200">
                            <div class="text-center mb-6" style="position: relative; z-index: 1;">
                                <img src="/images/bn666.png" alt="Logo SMK"
                                    class="w-20 h-20 mx-auto mb-4 object-contain">
                                <h3 class="text-2xl font-bold text-gray-800">Pendaftaran Online</h3>
                                <p class="text-gray-600 mt-2">Mudah, Cepat & Aman</p>
                            </div>
                            <div class="space-y-4" style="position: relative; z-index: 1;">
                                <div class="flex items-center gap-3 bg-blue-50 p-4 rounded-xl">
                                    <div
                                        class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold">
                                        1</div>
                                    <span class="text-gray-700 font-medium">Registrasi Akun</span>
                                </div>
                                <div class="flex items-center gap-3 bg-blue-50 p-4 rounded-xl">
                                    <div
                                        class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold">
                                        2</div>
                                    <span class="text-gray-700 font-medium">Isi Formulir</span>
                                </div>
                                <div class="flex items-center gap-3 bg-blue-50 p-4 rounded-xl">
                                    <div
                                        class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold">
                                        3</div>
                                    <span class="text-gray-700 font-medium">Upload Berkas</span>
                                </div>
                                <div class="flex items-center gap-3 bg-blue-50 p-4 rounded-xl">
                                    <div
                                        class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold">
                                        4</div>
                                    <span class="text-gray-700 font-medium">Verifikasi & Diterima</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Jurusan Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Program Keahlian</h2>
                <p class="text-xl text-gray-600">Pilih jurusan sesuai minat dan bakat Anda</p>
            </div>
            <div class="overflow-hidden relative">
                <div class="flex animate-scroll space-x-8" style="width: max-content;">
                    @php
                        $jurusan = \App\Models\Jurusan::all();
                    @endphp
                    @for($i = 0; $i < 10; $i++)
                        @foreach($jurusan as $j)
                            <div class="bg-white p-6 rounded-2xl shadow-lg text-center min-w-[280px] flex-shrink-0">
                                @if($j->gambar)
                                    <img src="{{ asset($j->gambar) }}" alt="{{ $j->nama }}"
                                        class="w-16 h-16 mx-auto mb-4 object-cover rounded-lg">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @endif
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $j->nama }}</h3>
                                <p class="text-gray-600 text-sm mb-4">Kuota: {{ $j->kuota }} siswa</p>
                                <div class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $j->kode }}
                                </div>
                            </div>
                        @endforeach
                    @endfor
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Kenapa Memilih Kami?</h2>
                <p class="text-xl text-gray-600">Kemudahan dan keunggulan sistem pendaftaran online</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-2xl card-hover">
                    <div
                        class="bg-blue-600 text-white rounded-xl w-16 h-16 flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Proses Cepat</h3>
                    <p class="text-gray-700">Pendaftaran online yang mudah dan cepat tanpa perlu datang ke sekolah</p>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-green-100 p-8 rounded-2xl card-hover">
                    <div
                        class="bg-green-600 text-white rounded-xl w-16 h-16 flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Aman & Terpercaya</h3>
                    <p class="text-gray-700">Data Anda dijamin aman dengan sistem keamanan berlapis</p>
                </div>
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-8 rounded-2xl card-hover">
                    <div
                        class="bg-purple-600 text-white rounded-xl w-16 h-16 flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Tracking Real-time</h3>
                    <p class="text-gray-700">Pantau status pendaftaran Anda secara real-time kapan saja</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="gradient-primary py-20">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">Siap Memulai Perjalanan Anda?</h2>
            <p class="text-xl text-green-100 mb-8">Daftar sekarang dan jadilah bagian dari keluarga besar SMK Bakti
                Nusantara 666</p>
            <a href="{{ route('register') }}"
                class="bg-white text-blue-700 px-10 py-4 rounded-xl font-bold text-lg hover:shadow-2xl transition transform hover:scale-105 inline-flex items-center gap-2">
                Daftar Sekarang
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="container mx-auto px-6 text-center">
            <div class="mb-6">
                <img src="/images/bn666.png" alt="Logo SMK" class="w-16 h-16 mx-auto mb-4 object-contain">
                <h3 class="text-xl font-bold text-white">SMK Bakti Nusantara 666</h3>
            </div>
            <p class="text-gray-400 mb-4">Sistem Penerimaan Mahasiswa Baru</p>
            <p class="text-gray-500 text-sm">&copy; 2024 SMK Bakti Nusantara 666. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>