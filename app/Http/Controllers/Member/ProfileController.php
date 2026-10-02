<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Show member profile
    public function show()
    {
        $user = Auth::user();
        $currentActivities = $user->pemesanan()->whereIn('status_pemesanan', ['confirmed', 'checked_in'])->latest()->take(5)->get();
        $activityHistory = $user->pemesanan()->whereIn('status_pemesanan', ['completed', 'cancelled'])->latest()->take(10)->get();
        return view('member.profile.show', compact('user', 'currentActivities', 'activityHistory'));
    }

    // Edit member profile
    public function edit()
    {
        $user = Auth::user();
        return view('member.profile.edit', compact('user'));
    }

    // Update member profile
    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'nohp' => 'nullable|string|max:15',
            'nik' => 'nullable|string|max:20',
            'password' => 'nullable|min:8|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB max
        ]);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old profile photo if exists
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Store new profile photo
            $fileName = time() . '_' . $user->id . '.' . $request->file('profile_photo')->getClientOriginalExtension();
            $path = $request->file('profile_photo')->storeAs('profile-photos', $fileName, 'public');
            $data['profile_photo'] = $path;
        }

        // Map form field 'name' to database field 'nama_lengkap'
        if (isset($data['name'])) {
            $data['nama_lengkap'] = $data['name'];
            unset($data['name']);
        }

        // Remove password if not provided
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);
        return redirect()->route('member.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
