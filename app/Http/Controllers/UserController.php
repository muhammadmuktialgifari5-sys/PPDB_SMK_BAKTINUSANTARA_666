<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = Pengguna::orderBy('created_at', 'desc')->get();
        return view('admin.users', compact('users'));
    }

    public function resetPassword(Request $request, $userId)
    {
        $request->validate([
            'new_password' => 'required|min:6'
        ]);

        $user = Pengguna::findOrFail($userId);
        $user->update([
            'password_hash' => Hash::make($request->new_password)
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'RESET_PASSWORD',
            'deskripsi' => "Reset password untuk user: {$user->nama} (ID: {$userId})",
            'ip_address' => $request->ip()
        ]);

        return response()->json(['success' => true, 'message' => 'Password berhasil direset']);
    }
}
