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

    public function index_user(Request $request)
    {
        $query = $request->q;

        $edukasis = Edukasi::query();

        // SEARCH
        if ($query) {
            $edukasis->where(function ($q) use ($query) {
                $q->where('judul', 'like', "%$query%")
                    ->orWhere('content', 'like', "%$query%");
            });
        }

        $edukasis = $edukasis->latest()->get();

        return view('allEducation', compact('edukasis', 'query'));
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
    public function update(Request $request, Edukasi $education)
    {
        $request->validate([
            'judul' => 'required',
            'content' => 'required',
        ]);

        $education->update([
            'judul' => $request->input('judul'),
            'content' => $request->input('content'),
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function destroy(Edukasi $education)
    {
        $education->delete();

        return response()->json([
            'success' => true
        ]);
    }
}