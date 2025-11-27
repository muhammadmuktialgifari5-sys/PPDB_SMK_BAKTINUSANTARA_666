@extends('layouts.app')

@section('title', 'Verifikasi Email')

@section('styles')
    <style>
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
    </style>
@endsection

@section('content')
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="gradient-bg p-8 text-white text-center">
                <img src="/images/bn666.png" alt="Logo SMK" class="w-20 h-20 mx-auto mb-4 object-contain">
                <h2 class="text-3xl font-bold mb-2">Verifikasi Email</h2>
                <p class="text-blue-100">Masukkan kode yang dikirim ke email Anda</p>
            </div>
            
            <div class="p-8">
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="bg-blue-100 text-blue-600 rounded-full w-10 h-10 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-blue-800 font-semibold">Kode dikirim ke:</p>
                            <p class="text-blue-600 text-sm">{{ $user->email }}</p>
                            @if(app()->environment('local') && $user->verification_code)
                                <p class="text-red-600 text-xs mt-1 font-mono bg-red-50 px-2 py-1 rounded">
                                    DEBUG: {{ $user->verification_code }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <form action="{{ route('verify.email', $user->id) }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label class="block mb-2 font-semibold text-gray-700">
                            Kode Verifikasi (6 digit)
                        </label>
                        <input type="text" name="verification_code" maxlength="6" 
                               class="w-full border-2 border-gray-200 px-4 py-3 rounded-xl focus:border-blue-600 focus:outline-none transition text-center text-2xl font-mono tracking-widest"
                               placeholder="000000" required autofocus>
                        <p class="text-xs text-gray-500 mt-1">Kode berlaku selama 15 menit</p>
                    </div>
                    
                    <button type="submit"
                        class="w-full gradient-bg text-white py-4 rounded-xl font-bold text-lg hover:shadow-2xl transition transform hover:scale-105 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Verifikasi Email
                    </button>
                </form>
                
                <div class="mt-6 text-center">
                    <p class="text-gray-600 text-sm mb-3">Tidak menerima kode?</p>
                    <div class="space-y-2">
                        <a href="{{ route('resend.verification', $user->id) }}" 
                           class="text-blue-600 font-semibold hover:text-blue-800 hover:underline block">
                            Kirim Ulang Kode
                        </a>
                        @if(app()->environment('local'))
                            <a href="{{ route('dev.verify.email', $user->id) }}" 
                               class="text-red-600 font-semibold hover:text-red-800 hover:underline block text-xs">
                                [DEV] Bypass Verifikasi
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto format input
        document.querySelector('input[name="verification_code"]').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
@endsection