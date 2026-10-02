<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // List all users (admin only)
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->input('search').'%')
                  ->orWhere('email', 'like', '%'.$request->input('search').'%');
        }

        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        $users = $query->paginate(15);
        
        return view('admin.user.index', compact('users'));
    }

    // Show user detail
    public function show(User $user)
    {
        return view('admin.user.show', compact('user'));
    }

    // Edit user
    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required|in:member,admin',
            'nohp' => 'nullable|string|max:15',
            'nik' => 'nullable|string|max:20',
        ]);

        $user->update($data);
        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui.');
    }

    // Delete user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus.');
    }
}
