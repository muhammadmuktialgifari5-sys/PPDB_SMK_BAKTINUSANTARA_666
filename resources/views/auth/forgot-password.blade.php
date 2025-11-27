@extends('layouts.app')

@section('title', 'Lupa Password')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="gradient-bg p-8 text-white text-center">
            <div class="bg-white bg-opacity-20 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd"/></svg>
            </div>
            <h2 class="text-3xl font-bold mb-2">Lupa Password?</h2>
            <p class="text-blue-100">Hubungi admin untuk reset password Anda</p>
        </div>
        <div class="p-8">
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    <div>
                        <h3 class="font-bold text-blue-900 mb-2">Cara Reset Password:</h3>
                        <ol class="text-sm text-blue-800 space-y-2 list-decimal list-inside">
                            <li>Hubungi admin sekolah melalui kontak di bawah</li>
                            <li>Berikan informasi: Nama lengkap dan Email/Username Anda</li>
                            <li>Admin akan mereset password Anda</li>
                            <li>Anda akan menerima password baru</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl p-6 mb-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                    Kontak Admin
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-gray-700">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                        <div>
                            <p class="text-sm text-gray-500">WhatsApp</p>
                            <p class="font-semibold">0812-3456-7890</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 text-gray-700">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-semibold">admin@spmb.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('login') }}" class="w-full bg-gray-600 text-white py-3 rounded-xl font-semibold hover:bg-gray-700 transition flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                Kembali ke Login
            </a>
        </div>
    </div>
</div>
@endsection
