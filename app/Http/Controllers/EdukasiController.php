<?php

namespace App\Http\Controllers;

use App\Models\Edukasi;
use Illuminate\Http\Request;


class EdukasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $education = Edukasi::all();
        return view('admin.edukasi.index', compact('education'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(edukasi $edukasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(edukasi $edukasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, edukasi $edukasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(edukasi $edukasi)
    {
        //
    }
}
