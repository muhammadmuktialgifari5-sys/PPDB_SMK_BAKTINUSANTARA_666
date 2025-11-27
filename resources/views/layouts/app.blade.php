<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SPMB')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Inter', sans-serif;
            background-image: url('/images/sekolah.jpeg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.85);
            z-index: -1;
        }
        .gradient-bg { background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%); }
        .gradient-card { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
        .gradient-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .gradient-warning { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
        .gradient-info { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
        .gradient-danger { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        .sidebar-link { transition: all 0.2s ease; }
        .sidebar-link:hover { background: rgba(255,255,255,0.1); transform: translateX(4px); }
        .sidebar-link.active { background: rgba(255,255,255,0.2); border-left: 4px solid #60a5fa; }
    </style>
    @yield('styles')
</head>
<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-sky-50 min-h-screen antialiased">
    <!-- Top Navbar -->
    <nav class="gradient-bg text-white shadow-xl fixed w-full top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <img src="/images/bn666.png" alt="Logo SMK" class="w-14 h-14 object-contain">
                    <div>
                        <h1 class="text-xl font-bold">SMK Bakti Nusantara 666</h1>
                        <p class="text-xs text-blue-100">Sistem Penerimaan Mahasiswa Baru</p>
                    </div>
                </div>
                @auth
                <div class="flex gap-4 items-center">
                    @if(in_array(auth()->user()->role, ['admin', 'keuangan']))
                        @php
                            $pendingPayments = \App\Models\Pembayaran::where('status', 'PENDING')->count();
                        @endphp
                        @if($pendingPayments > 0)
                        <a href="{{ route('pembayaran.index', ['status' => 'PENDING']) }}" class="relative bg-red-500 hover:bg-red-600 px-4 py-2 rounded-xl transition shadow-lg flex items-center gap-2 animate-pulse">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-semibold text-sm">{{ $pendingPayments }} Pending</span>
                            <span class="absolute -top-2 -right-2 bg-yellow-400 text-red-800 text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center">!</span>
                        </a>
                        @endif
                    @endif
                    
                    <div class="bg-white bg-opacity-20 px-5 py-2.5 rounded-xl backdrop-blur-sm border border-white border-opacity-30">
                        <div class="flex items-center gap-3">
                            <div class="bg-white text-blue-700 rounded-full w-10 h-10 flex items-center justify-center font-bold">
                                {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-sm">{{ auth()->user()->nama }}</p>
                                <span class="text-xs bg-blue-400 text-white px-2 py-0.5 rounded-full font-semibold">{{ auth()->user()->role }}</span>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 px-5 py-2.5 rounded-xl transition shadow-lg font-semibold flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/></svg>
                            Logout
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-24 pb-8">
        <div class="container mx-auto px-6">
            <!-- Alerts -->
            @if(session('success'))
            <div class="bg-white border-l-4 border-green-500 rounded-xl shadow-lg mb-6 overflow-hidden animate-slide-down">
                <div class="flex items-center p-5">
                    <div class="bg-green-500 text-white rounded-full w-12 h-12 flex items-center justify-center mr-4">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800 text-lg">Berhasil!</p>
                        <p class="text-gray-600">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="bg-white border-l-4 border-red-500 rounded-xl shadow-lg mb-6 overflow-hidden animate-slide-down">
                <div class="flex items-start p-5">
                    <div class="bg-red-500 text-white rounded-full w-12 h-12 flex items-center justify-center mr-4 flex-shrink-0">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800 text-lg mb-2">Terjadi Kesalahan!</p>
                        <ul class="text-gray-600 space-y-1">
                            @foreach($errors->all() as $error)
                            <li class="flex items-start">
                                <span class="text-red-500 mr-2">•</span>
                                <span>{{ $error }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            @if(!isset($hideBackButton) || !$hideBackButton)
                @if(request()->route() && request()->route()->getName() !== 'dashboard' && auth()->check())
                    <x-back-button :url="route('dashboard')" />
                @endif
            @endif
            
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="container mx-auto px-6 py-6">
            <div class="text-center text-gray-600 text-sm">
                <p>&copy; 2024 SMK Bakti Nusantara 666. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Auto refresh CSRF token setiap 30 menit
        setInterval(function() {
            fetch('/refresh-csrf').then(r => r.json()).then(data => {
                document.querySelector('meta[name="csrf-token"]').content = data.token;
                document.querySelectorAll('input[name="_token"]').forEach(input => {
                    input.value = data.token;
                });
            }).catch(() => {});
        }, 1800000);
        
        // Update CSRF token on logout form submit
        const logoutForm = document.getElementById('logout-form');
        if (logoutForm) {
            logoutForm.addEventListener('submit', function(e) {
                const tokenInput = this.querySelector('input[name="_token"]');
                if (tokenInput) {
                    fetch('/refresh-csrf').then(r => r.json()).then(data => {
                        tokenInput.value = data.token;
                    }).catch(() => {});
                }
            });
        }

        // Auto refresh notifikasi pembayaran pending setiap 30 detik
        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'keuangan']))
        function updatePendingPayments() {
            fetch('/api/pending-payments')
                .then(r => r.json())
                .then(data => {
                    const notifBtn = document.getElementById('pending-payment-btn');
                    const countSpan = document.getElementById('pending-count');
                    
                    if (data.count > 0) {
                        if (!notifBtn) {
                            // Buat tombol notifikasi jika belum ada
                            const navbar = document.querySelector('.flex.gap-4.items-center');
                            const newBtn = document.createElement('a');
                            newBtn.id = 'pending-payment-btn';
                            newBtn.href = '{{ route("pembayaran.index", ["status" => "PENDING"]) }}';
                            newBtn.className = 'relative bg-red-500 hover:bg-red-600 px-4 py-2 rounded-xl transition shadow-lg flex items-center gap-2 animate-pulse';
                            newBtn.innerHTML = `
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-semibold text-sm" id="pending-count">${data.count} Pending</span>
                                <span class="absolute -top-2 -right-2 bg-yellow-400 text-red-800 text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center">!</span>
                            `;
                            navbar.insertBefore(newBtn, navbar.firstChild);
                        } else {
                            countSpan.textContent = data.count + ' Pending';
                        }
                    } else {
                        if (notifBtn) {
                            notifBtn.remove();
                        }
                    }
                })
                .catch(() => {});
        }
        
        // Jalankan setiap 30 detik
        setInterval(updatePendingPayments, 30000);
        // Jalankan sekali saat load
        updatePendingPayments();
        @endif
    </script>
    @yield('scripts')
</body>
</html>
