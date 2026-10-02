<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipeKamar;
use Illuminate\Http\Request;

class TipeKamarController extends Controller
{
    public function index(Request $request)
    {
        $query = TipeKamar::withCount('kamars');

        if ($request->filled('search')) {
            $query->where('nama_tipe', 'like', '%'.$request->input('search').'%');
        }

        $tipeKamars = $query->paginate(6);
        return view('admin.tipe-kamar.index', compact('tipeKamars'));
    }

    public function create()
    {
        return view('admin.tipe-kamar.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_tipe' => 'required|string|max:100|unique:tipe_kamar,nama_tipe',
            'harga_dasar' => 'required|numeric|min:0',
            'max_tamu' => 'required|integer|min:1',
        ]);

        TipeKamar::create($data);
        return redirect()->route('admin.tipe-kamar.index')->with('success', 'Tipe kamar berhasil ditambahkan.');
    }

    public function show(TipeKamar $tipeKamar)
    {
        $tipeKamar->load(['kamars']);
        return view('admin.tipe-kamar.show', compact('tipeKamar'));
    }

    public function edit(TipeKamar $tipeKamar)
    {
        return view('admin.tipe-kamar.edit', compact('tipeKamar'));
    }

    public function update(Request $request, TipeKamar $tipeKamar)
    {
        $data = $request->validate([
            'nama_tipe' => 'required|string|max:100|unique:tipe_kamar,nama_tipe,'.$tipeKamar->id_tipe.',id_tipe',
            'harga_dasar' => 'required|numeric|min:0',
            'max_tamu' => 'required|integer|min:1',
        ]);

        $tipeKamar->update($data);
        return redirect()->route('admin.tipe-kamar.index')->with('success', 'Tipe kamar berhasil diperbarui.');
    }

    public function destroy(TipeKamar $tipeKamar)
    {
        // Check if tipe kamar has related kamars
        if ($tipeKamar->kamars()->count() > 0) {
            return redirect()->route('admin.tipe-kamar.index')->with('error', 'Tipe kamar tidak dapat dihapus karena masih memiliki kamar terkait.');
        }

        $tipeKamar->delete();
        return redirect()->route('admin.tipe-kamar.index')->with('success', 'Tipe kamar berhasil dihapus.');
    }
}
