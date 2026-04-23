<?php

namespace App\Http\Controllers;

use App\Models\Edukasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EdukasiController extends Controller
{
    public function index()
    {
        $education = Edukasi::latest()->get();
        return view('admin.edukasi.index', compact('education'));
    }

    public function showUser($id)
    {
        $edukasi = Edukasi::findOrFail($id);
        return view('education', compact('edukasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'content' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $data = $request->only(['judul', 'content']);
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('edukasi', 'public');
        }

        Edukasi::create($data);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function show(Edukasi $edukasi)
    {
        return view('admin.edukasi.show', compact('edukasi'));
    }

    public function edit(Edukasi $edukasi)
    {
        return view('admin.edukasi.edit', compact('edukasi'));
    }

    public function update(Request $request, Edukasi $edukasi)
    {
        $request->validate([
            'judul' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // $data = $request->only(['judul', 'content']);
        // $data['user_id'] = Auth::id();
        $data = $request->all();
        // upload gambar baru
        if ($request->hasFile('image')) {

            // hapus gambar lama
            if ($edukasi->image && Storage::disk('public')->exists($edukasi->image)) {
                Storage::disk('public')->delete($edukasi->image);
            }

            $data['image'] = $request->file('image')->store('edukasi', 'public');
        }
        dd($data);
        $edukasi->update($data);

        // 🔥 FIX: return JSON kalau AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diupdate'
            ]);
        }

        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy(Request $request, Edukasi $edukasi)
    {
        if ($edukasi->image && Storage::disk('public')->exists($edukasi->image)) {
            Storage::disk('public')->delete($edukasi->image);
        }

        $edukasi->delete();

        // 🔥 FIX: return JSON kalau AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        }

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}