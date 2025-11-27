@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Kelola Pengguna</h2>
    
    <div class="mb-4">
        <input type="text" id="searchInput" placeholder="Cari nama atau email..." class="border px-4 py-2 rounded w-full md:w-96">
    </div>

    <div class="overflow-x-auto">
        <table class="w-full border" id="usersTable">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border p-2">Nama</th>
                    <th class="border p-2">Email</th>
                    <th class="border p-2">Role</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="border p-2">{{ $user->nama }}</td>
                    <td class="border p-2">{{ $user->email }}</td>
                    <td class="border p-2">
                        <span class="px-2 py-1 rounded text-xs font-semibold
                            @if($user->role == 'admin') bg-red-100 text-red-700
                            @elseif($user->role == 'pendaftar') bg-blue-100 text-blue-700
                            @else bg-gray-100 text-gray-700
                            @endif">
                            {{ strtoupper($user->role) }}
                        </span>
                    </td>
                    <td class="border p-2">
                        @if($user->aktif)
                            <span class="text-green-600 font-semibold">Aktif</span>
                        @else
                            <span class="text-red-600 font-semibold">Nonaktif</span>
                        @endif
                    </td>
                    <td class="border p-2">
                        <button onclick="resetPassword({{ $user->id }}, '{{ $user->nama }}')" 
                                class="bg-yellow-600 text-white px-3 py-1 rounded text-sm hover:bg-yellow-700">
                            Reset Password
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="resetModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-xl font-bold mb-4">Reset Password</h3>
        <form id="resetForm" method="POST">
            @csrf
            <input type="hidden" name="user_id" id="userId">
            
            <div class="mb-4">
                <label class="block mb-2 font-semibold">Nama Pengguna</label>
                <input type="text" id="userName" class="w-full border px-3 py-2 rounded bg-gray-100" readonly>
            </div>
            
            <div class="mb-4">
                <label class="block mb-2 font-semibold">Password Baru</label>
                <input type="text" name="new_password" id="newPassword" class="w-full border px-3 py-2 rounded" required>
                <p class="text-xs text-gray-500 mt-1">Minimal 6 karakter</p>
            </div>
            
            <div class="mb-4">
                <button type="button" onclick="generatePassword()" class="text-blue-600 text-sm font-semibold hover:underline">
                    Generate Password Otomatis
                </button>
            </div>
            
            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded font-semibold hover:bg-blue-700">
                    Reset Password
                </button>
                <button type="button" onclick="closeModal()" class="bg-gray-600 text-white px-4 py-2 rounded font-semibold hover:bg-gray-700">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function resetPassword(userId, userName) {
    document.getElementById('userId').value = userId;
    document.getElementById('userName').value = userName;
    document.getElementById('newPassword').value = '';
    document.getElementById('resetModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('resetModal').classList.add('hidden');
}

function generatePassword() {
    const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let password = '';
    for (let i = 0; i < 8; i++) {
        password += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('newPassword').value = password;
}

document.getElementById('resetForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const userId = document.getElementById('userId').value;
    const newPassword = document.getElementById('newPassword').value;
    
    fetch(`/admin/users/${userId}/reset-password`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ new_password: newPassword })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Password berhasil direset!\n\nPassword baru: ' + newPassword + '\n\nSalin dan berikan ke pengguna.');
            closeModal();
        } else {
            alert('Gagal reset password: ' + data.message);
        }
    })
    .catch(error => {
        alert('Terjadi kesalahan: ' + error);
    });
});

document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('#usersTable tbody tr');
    
    rows.forEach(row => {
        const nama = row.cells[0].textContent.toLowerCase();
        const email = row.cells[1].textContent.toLowerCase();
        
        if (nama.includes(searchValue) || email.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
@endsection
