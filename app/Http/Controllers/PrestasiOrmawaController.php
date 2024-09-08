<?php

namespace App\Http\Controllers;

use App\Models\PrestasiOrmawa;
use App\Http\Controllers\Controller;
use App\Models\Ormawa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrestasiOrmawaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'sertifikat' => 'required|image|max:5000',
            'ormawa_id' => 'required|integer|exists:ormawas,id',
        ]);

        $validatedData['sertifikat'] = $request->file('sertifikat')->store('ormawa-prestasi');

        PrestasiOrmawa::create($validatedData);

        return redirect()->back()->with('success', 'Prestasi Ormawa berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $ormawa = Ormawa::findOrFail($id);

        $prestasiOrmawa = PrestasiOrmawa::where('ormawa_id', $id)->get();

        return view('ormawa.prestasi.show', [
            'ormawa' => $ormawa,
            'prestasiOrmawa' => $prestasiOrmawa,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrestasiOrmawa $prestasiOrmawa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PrestasiOrmawa $prestasiOrmawa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $PrestasiOrmawa = PrestasiOrmawa::findOrFail($id);

        if($PrestasiOrmawa->nama_file){
            Storage::delete($PrestasiOrmawa->nama_file);
        }

        PrestasiOrmawa::destroy($PrestasiOrmawa->id);

        return redirect()->back()->with('success', 'Prestasi Ormawa berhasil dihapus.');
    }
}
