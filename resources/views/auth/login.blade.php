@extends('layouts.app')

@section('title', 'Login')

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
            <h2 class="text-3xl font-bold mb-2">Selamat Datang Kembali</h2>
            <p class="text-blue-100">Masuk ke akun Anda untuk melanjutkan</p>
        </div>
        <form action="{{ route('login') }}" method="POST" class="p-8">
            @csrf
            <div class="mb-6">
                <label class="block mb-2 font-semibold text-gray-700 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                    Email
                </label>
                <input type="text" name="email" value="{{ old('email') }}" class="w-full border-2 border-gray-200 px-4 py-3 rounded-xl focus:border-blue-600 focus:outline-none transition" placeholder="nama@email.com atau username" required autofocus>
            </div>
            <div class="mb-6">
                <label class="block mb-2 font-semibold text-gray-700 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                    Password
                </label>
                <input type="password" name="password" class="w-full border-2 border-gray-200 px-4 py-3 rounded-xl focus:border-blue-600 focus:outline-none transition" placeholder="••••••••" required>
            </div>
            <div class="text-right mb-4">
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800 hover:underline font-semibold">Lupa Password?</a>
            </div>
            <button type="submit" class="w-full gradient-bg text-white py-4 rounded-xl font-bold text-lg hover:shadow-2xl transition transform hover:scale-105 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                Masuk
            </button>
        </form>
        <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-8 py-5 text-center border-t">
            <p class="text-gray-700">Belum punya akun? <a href="{{ route('register') }}" class="text-blue-700 font-bold hover:text-blue-900 hover:underline">Daftar Sekarang</a></p>
        </div>
    </div>
</div>
@endsection
