<?php

namespace App\Http\Middleware; // <<< HARUS DIPERBAIKI INI

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureMember
{
    public function handle(Request $request, Closure $next)
    {
        // Pengguna pasti sudah login karena middleware 'auth' dijalankan sebelumnya.
        $user = Auth::user();

        // 1. Cek apakah pengguna adalah Admin
        if ($user->isAdmin()) {
            // Redirect ke dashboard admin jika dia admin
            return redirect()->route('admin.dashboard.index')->with('error', 'Admin tidak dapat mengakses halaman member.');
        }

        // 2. Jika dia bukan admin (maka dia member), lanjutkan permintaan
        return $next($request);
    }
}