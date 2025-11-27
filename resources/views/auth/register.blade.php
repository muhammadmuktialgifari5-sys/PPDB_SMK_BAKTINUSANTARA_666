@extends('layouts.app')

@section('title', 'Registrasi')

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
                <h2 class="text-3xl font-bold mb-2">Daftar Akun Baru</h2>
                <p class="text-blue-100">Bergabunglah dengan SMK Bakti Nusantara 666</p>
            </div>
            <form action="{{ route('register') }}" method="POST" class="p-8">
                @csrf
                <div class="mb-5">
                    <label class="block mb-2 font-semibold text-gray-700 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                        Nama Lengkap
                    </label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                        class="w-full border-2 border-gray-200 px-4 py-3 rounded-xl focus:border-blue-600 focus:outline-none transition"
                        placeholder="Nama lengkap Anda" required autofocus>
                </div>
                <div class="mb-5">
                    <label class="block mb-2 font-semibold text-gray-700 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        Email
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border-2 border-gray-200 px-4 py-3 rounded-xl focus:border-blue-600 focus:outline-none transition"
                        placeholder="nama@email.com" required>
                </div>

                <div class="mb-5">
                    <label class="block mb-2 font-semibold text-gray-700 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Password
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="w-full border-2 border-gray-200 px-4 py-3 pr-12 rounded-xl focus:border-blue-600 focus:outline-none transition"
                            placeholder="Minimal 6 karakter" required>
                        <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            <svg id="eye-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Password minimal 6 karakter</p>
                </div>
                <div class="mb-6">
                    <label class="block mb-2 font-semibold text-gray-700 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Konfirmasi Password
                    </label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full border-2 border-gray-200 px-4 py-3 pr-12 rounded-xl focus:border-blue-600 focus:outline-none transition"
                            placeholder="Ulangi password" required>
                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            <svg id="eye-password_confirmation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Masukkan password yang sama</p>
                </div>
                
                <script>
                function togglePassword(fieldId) {
                    const field = document.getElementById(fieldId);
                    const eye = document.getElementById('eye-' + fieldId);
                    
                    if (field.type === 'password') {
                        field.type = 'text';
                        eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464M9.878 9.878l-1.415-1.414M14.12 14.12l1.415 1.415M14.12 14.12L15.535 15.535M14.12 14.12l-4.243-4.243m0 0L8.464 8.464M3 3l18 18"/>';
                    } else {
                        field.type = 'password';
                        eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
                    }
                }
                </script>
                <button type="submit"
                    class="w-full gradient-bg text-white py-4 rounded-xl font-bold text-lg hover:shadow-2xl transition transform hover:scale-105 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                            clip-rule="evenodd" />
                    </svg>
                    Daftar Sekarang
                </button>
            </form>
            <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-8 py-5 text-center border-t">
                <p class="text-gray-700">Sudah punya akun? <a href="{{ route('login') }}"
                        class="text-blue-700 font-bold hover:text-blue-900 hover:underline">Login Di Sini</a></p>
            </div>
        </div>
    </div>
@endsection