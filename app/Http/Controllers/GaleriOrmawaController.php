<?php

namespace App\Http\Controllers;

use App\Models\GaleriOrmawa;
use App\Http\Controllers\Controller;
use App\Models\Ormawa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriOrmawaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd("index");
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
        // ddd($request);

        if($request->tipe === 'foto') {
            $validatedData = $request->validate([
                'nama_file' => 'required|image|max:5000',
                'tipe' => 'required|string|max:255',
                'ormawa_id' => 'required|integer|exists:ormawas,id',
            ]);

            $validatedData['nama_file'] = $request->file('nama_file')->store('ormawa-galeri');

        }else if($request->tipe === 'video'){

            $validatedData = $request->validate([
                'nama_file' => 'required|file|max:100000',
                'tipe' => 'required|string|max:255',
                'ormawa_id' => 'required|integer|exists:ormawas,id',
            ]);
            
            $file = $request->file('nama_file');
            $file->move('storage/ormawa-galeri', $file->getClientOriginalName());

            $fileName = $file->getClientOriginalName();

            $validatedData['nama_file'] = 'ormawa-galeri/' . $fileName;
        }
        GaleriOrmawa::create($validatedData);
        
        return redirect()->back()->with('success', 'Galeri Ormawa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ormawa = Ormawa::findOrFail($id);

        $galeriOrmawa = GaleriOrmawa::where('ormawa_id', $id)->get();

        return view('ormawa.galeri.show', [
            'ormawa' => $ormawa,
            'galeriOrmawa' => $galeriOrmawa,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GaleriOrmawa $galeriOrmawa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GaleriOrmawa $galeriOrmawa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $galeriOrmawa = GaleriOrmawa::findOrFail($id);

        if($galeriOrmawa->nama_file){
            Storage::delete($galeriOrmawa->nama_file);
        }

        GaleriOrmawa::destroy($galeriOrmawa->id);

        return redirect()->back()->with('success', 'Galeri Ormawa berhasil dihapus.');
    }
}
