<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\TipeKamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KamarController extends Controller
{
    // List kamar (admin)
    public function index(Request $request)
    {
        $query = Kamar::with('tipe');

        if ($request->filled('nomor_kamar')) {
            $query->where('nomor_kamar', 'like', '%'.$request->input('nomor_kamar').'%');
        }

        if ($request->filled('type')) {
            $query->whereHas('tipe', function($q) use ($request){
                $q->where('nama_tipe', 'like', '%'.$request->input('type').'%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status_ketersediaan', $request->input('status'));
        }

        $kamars = $query->paginate(6);
        $tipeKamars = TipeKamar::all();

        return view('admin.kamar.index', compact('kamars', 'tipeKamars'));
    }

    // Create form (admin only)
    public function create()
    {
        $tipe = TipeKamar::all();

        // Generate auto room number
        $lastRoom = Kamar::orderBy('id_kamar', 'desc')->first();
        if ($lastRoom) {
            // Extract numeric part from room number (handles cases like "101", "A-01", etc.)
            $numericPart = preg_replace('/[^0-9]/', '', $lastRoom->nomor_kamar);
            $nextNumber = intval($numericPart) + 1;
        } else {
            $nextNumber = 1;
        }
        $generatedRoomNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('admin.kamar.create', compact('tipe', 'generatedRoomNumber'));
    }

    // Store kamar (admin only)
    public function store(Request $request)
    {
        $request->merge([
            'status_ketersediaan' => $request->input('status_ketersediaan', 'available')
        ]);

        $data = $request->validate([
            'id_tipe' => 'required|exists:tipe_kamar,id_tipe',
            'deskripsi' => 'nullable|string|max:500',
            'status_ketersediaan' => 'required|in:available,booked,maintenance',
            'foto_kamar' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_detail.*' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_detail' => 'nullable|array|max:3',
        ]);

        // Generate auto room number
        $lastRoom = Kamar::orderBy('id_kamar', 'desc')->first();
        if ($lastRoom) {
            // Extract numeric part from room number (handles cases like "101", "A-01", etc.)
            $numericPart = preg_replace('/[^0-9]/', '', $lastRoom->nomor_kamar);
            $nextNumber = intval($numericPart) + 1;
        } else {
            $nextNumber = 1;
        }
        $data['nomor_kamar'] = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // Handle foto_kamar upload
        if ($request->hasFile('foto_kamar')) {
            $fotoKamarPath = $request->file('foto_kamar')->store('kamar', 'public');
            $data['foto_kamar'] = $fotoKamarPath;
        }

        // Handle foto_detail upload (multiple files)
        if ($request->hasFile('foto_detail')) {
            $fotoDetailPaths = [];
            foreach ($request->file('foto_detail') as $file) {
                $path = $file->store('kamar/detail', 'public');
                $fotoDetailPaths[] = $path;
            }
            $data['foto_detail'] = json_encode($fotoDetailPaths);
        }

        Kamar::create($data);
        return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil ditambahkan.');
    }

    // Edit form (admin only)
    public function edit(Kamar $kamar)
    {
        $tipe = TipeKamar::all();
        return view('admin.kamar.edit', compact('kamar', 'tipe'));
    }

    // Update kamar (admin only)
    public function update(Request $request, Kamar $kamar)
    {
        $data = $request->validate([
            'nomor_kamar' => 'required|string|unique:kamar,nomor_kamar,'.$kamar->id_kamar.',id_kamar',
            'id_tipe' => 'required|exists:tipe_kamar,id_tipe',
            'deskripsi' => 'nullable|string|max:500',
            'status_ketersediaan' => 'required|in:available,booked,maintenance',
            'foto_kamar' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_detail.*' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_detail' => 'nullable|array|max:3',
        ]); // <-- SINTAKS ARRAY DIPERBAIKI DI SINI

        // Handle foto_kamar upload
        if ($request->hasFile('foto_kamar')) {
            // Delete old file if exists
            if ($kamar->foto_kamar && \Storage::disk('public')->exists($kamar->foto_kamar)) {
                \Storage::disk('public')->delete($kamar->foto_kamar);
            }
            $fotoKamarPath = $request->file('foto_kamar')->store('kamar', 'public');
            $data['foto_kamar'] = $fotoKamarPath;
        }

        // Handle foto_detail upload (multiple files)
        if ($request->hasFile('foto_detail')) {
            // Delete old files if exist
            if ($kamar->foto_detail) {
                $oldDetailPhotos = json_decode($kamar->foto_detail, true);
                foreach ($oldDetailPhotos as $oldPhoto) {
                    if (\Storage::disk('public')->exists($oldPhoto)) {
                        \Storage::disk('public')->delete($oldPhoto);
                    }
                }
            }
            $fotoDetailPaths = [];
            foreach ($request->file('foto_detail') as $file) {
                $path = $file->store('kamar/detail', 'public');
                $fotoDetailPaths[] = $path;
            }
            $data['foto_detail'] = json_encode($fotoDetailPaths);
        }

        $kamar->update($data);
        return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil diperbarui.');
    }

    // Delete kamar (admin only)
    public function destroy(Kamar $kamar)
    {
        $kamar->delete();
        return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil dihapus.');
    }
}