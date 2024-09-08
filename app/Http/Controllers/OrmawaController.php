<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GaleriOrmawa;
use App\Models\Ormawa;
use App\Models\OrmawaUser;
use App\Models\PrestasiOrmawa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\PDF;

class OrmawaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ormawas = Ormawa::all();
        $ormawaUsers = OrmawaUser::all();
        $selected_ormawa_id = auth()->user()->ormawa_id;

        return view('ormawa.index', compact('ormawas', 'selected_ormawa_id', 'ormawaUsers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'angkatan' => 'required|string|max:255',
            'jenis' => 'required|in:UKM,HMJ,BEM,MPM',
            'jurusan' => 'nullable|string|max:255',
            'deskripsi' => 'required',
            'logo' => 'required|image|max:5000',
        ]);

        if($validatedData['jenis'] == 'HMJ'){
            // if jurusan is null then error
            if(!$validatedData['jurusan']){
                return redirect('/ormawa/')->with('error', 'Ormawa gagal ditambah. Jurusan harus diisi untuk HMJ.');
            }
            
        }

        // CHECK NAMA AND ANGKATAN EXISTS
        $existingOrmawa = Ormawa::where('nama', $validatedData['nama'])
                            ->where('angkatan', $validatedData['angkatan'])
                            ->first();
        
        if($existingOrmawa){
            return redirect('/ormawa/')->with('error', 'Ormawa gagal ditambah. Ormawa dengan nama dan angkatan tersebut sudah ada.');
        }

        try {
            $validatedData['logo'] = $request->file('logo')->store('ormawa-logo');
            
            if(Ormawa::create($validatedData)){
                return redirect('/ormawa/')->with('success', 'Ormawa berhasil ditambahkan.');
            }else{
                Storage::delete($validatedData['logo']);
                return redirect('/ormawa/')->with('error', 'Ormawa gagal ditambahkan.');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/ormawa/')->with('error', 'Ormawa gagal ditambahkan.');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ormawa = Ormawa::findOrFail($id);
        return $ormawa;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'angkatan' => 'required|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'deskripsi' => 'required',
        ]);

        // CHECK NAMA AND ANGKATAN EXISTS
        $existingOrmawa = Ormawa::where('nama', $validatedData['nama'])
                            ->where('angkatan', $validatedData['angkatan'])
                            ->first();
        
        if($existingOrmawa && $existingOrmawa->id != $id){
            return redirect('/ormawa/')->with('error', 'Ormawa gagal diupdate. Ormawa dengan nama dan angkatan tersebut sudah ada.');
        }

        $ormawa = Ormawa::findOrFail($id);

        try {
            if ($ormawa->fill($validatedData)->save()) {
                if($request->file('logo')){
        
                    if($request->oldLogo){
                        try{
                            Storage::delete($request->oldLogo);
                        }catch(\Throwable $th){
                            //throw $th;
                        }
                    }
        
                    $validatedData['logo'] = $request->validate([
                        'logo' => 'required|image|max:5000',
                    ]);
                    
                    $validatedData['logo'] = $request->file('logo')->store('ormawa-logo');
                    $ormawa->fill($validatedData)->save();
                }
            
                return redirect('/ormawa/')->with('success', 'Ormawa berhasil diupdate.');
            } else {
                return redirect('/ormawa/')->with('error', 'Ormawa gagal diupdate.');
            }
        } catch (\Throwable $th) {
            return redirect('/ormawa/')->with('error', 'Ormawa gagal diupdate.');
        }
        

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ormawa = Ormawa::findOrFail($id);

        try {
            $galleries = GaleriOrmawa::where('ormawa_id', $ormawa->id)->get();
            foreach ($galleries as $gallery) {
                $gallery->delete();
            }
    
            $prestasies = PrestasiOrmawa::where('ormawa_id', $ormawa->id)->get();
            foreach ($prestasies as $prestasi) {
                $prestasi->delete();
            }

            Storage::delete($ormawa->logo);
            Ormawa::destroy($ormawa->id);
            return redirect('/ormawa/')->with('success', 'Ormawa berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect('/ormawa/')->with('success', 'Ormawa gagal dihapus.');
        }

    }

    public function lpj(string $id)
    {
        $ormawa = Ormawa::findOrFail($id);
        return view('ormawa.lpj.index', compact('ormawa'));
    }

    public function upload(Request $request){
        // $fileName=$request->file('file')->getClientOriginalName();
        // $path=$request->file('file')->storeAs('uploads', $fileName, 'public');
        // return response()->json(['location'=>"/storage/$path"]);

        $imgpath = request()->file('file')->store('ormawa/lpj/bukti-dan-dokumentasi');
        return response()->json(['location' => "/storage/$imgpath"]);
    }

    public function createLpj(Request $request, string $id)
    {
        if($request->cover){
            $validatedData = $request->validate([
                'cover' => 'required|image|max:5024',
                'kata_pengantar' => 'required',
                'bab1' => 'required',
                'bab2' => 'required',
                'laporan_admin' => 'required',
                'laporan_keuangan' => 'required',
                'bab3' => 'required',
                'bukti_transaksi' => 'required',
                'dokumentasi' => 'required',
            ]);
        }else{
            $ormawaCover = Ormawa::find($id);
            if($ormawaCover->cover){
                $validatedData = $request->validate([
                    'kata_pengantar' => 'required',
                    'bab1' => 'required',
                    'bab2' => 'required',
                    'laporan_admin' => 'required',
                    'laporan_keuangan' => 'required',
                    'bab3' => 'required',
                    'bukti_transaksi' => 'required',
                    'dokumentasi' => 'required',
                ]);
            }else{
                $validatedData = $request->validate([
                    'cover' => 'required|image|max:5024',
                    'kata_pengantar' => 'required',
                    'bab1' => 'required',
                    'bab2' => 'required',
                    'laporan_admin' => 'required',
                    'laporan_keuangan' => 'required',
                    'bab3' => 'required',
                    'bukti_transaksi' => 'required',
                    'dokumentasi' => 'required',
                ]);
            }
        }

        if($request->ketua_jurusan){
            $validatedData['ketua_jurusan'] = $request->ketua_jurusan;
            $validatedData['nip_ketua_jurusan'] = $request->nip_ketua_jurusan;
        }

        try {
            $ormawa = Ormawa::find($id);

            if($request->cover){
                $validatedData['cover'] = $request->file('cover')->store('ormawa/cover');
            }
            
            $ormawa->fill($validatedData);
            $ormawa->save();

            return redirect('/ormawa/')->with('success', 'Template LPJ ' . $ormawa->nama .  ' Akhir berhasil dibuat.');
        } catch (\Exception $e) {
            return redirect('/ormawa/')->with('error', 'Template LPJ  ' . $ormawa->nama .  '  Akhir gagal dibuat.');
        }
    }

    public function extractImageUrls($text, $basePath = '../../storage/') {
        $pattern = '/<img[^>]+src\s*=\s*"([^"]+)"/';
        $matches = [];
        preg_match_all($pattern, $text, $matches);

        $imageUrls = $matches[1];

        $imageUrls = array_map(function ($imageUrl) use ($basePath) {
            return str_replace($basePath, '', $imageUrl);
        }, $imageUrls);

        return $imageUrls;
    }

    public function downloadLpj(string $id)
    {
        $ormawa = Ormawa::where('jenis', 'BEM')->where('angkatan', date('Y'))->first();   
        $ketua_bem = User::find($ormawa?->ketua_id);

        $ormawa = Ormawa::where('jenis', 'MPM')->where('angkatan', date('Y'))->first();
        $ketua_mpm = User::find($ormawa?->ketua_id);

        $ormawa = Ormawa::find($id);
        $ketua = User::find($ormawa?->ketua_id);
        $sekum = User::find($ormawa?->sekretaris_umum_id);
        $wadir = User::where('username', 'wadir-polsub')->first();

        $buktis = $this->extractImageUrls($ormawa->bukti_transaksi);
        $dokumentasis = $this->extractImageUrls($ormawa->dokumentasi);

        if($ormawa->jenis == 'UKM'){
            $pdf = PDF::loadView('ormawa.jenis.ukm', compact('ormawa', 'ketua_bem', 'ketua_mpm', 'ketua', 'sekum', 'wadir', 'buktis', 'dokumentasis'));
        }else if($ormawa->jenis == 'HMJ'){
            $pdf = PDF::loadView('ormawa.jenis.hmj', compact('ormawa', 'ketua_bem', 'ketua_mpm', 'ketua', 'sekum', 'wadir', 'buktis', 'dokumentasis'));
        }else if($ormawa->jenis == 'BEM'){
            $pdf = PDF::loadView('ormawa.jenis.bem', compact('ormawa', 'ketua_bem', 'ketua_mpm', 'ketua', 'sekum', 'wadir', 'buktis', 'dokumentasis'));
        }else if($ormawa->jenis == 'MPM'){
            $pdf = PDF::loadView('ormawa.jenis.mpm', compact('ormawa', 'ketua_bem', 'ketua_mpm', 'ketua', 'sekum', 'wadir', 'buktis', 'dokumentasis'));
        }

        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('LPJ Akhir ' . $ormawa->nama . '.pdf');
    }

    public function daftar(string $ormawa_id, string $user_id)
    {
        $ormawa = Ormawa::findOrFail($ormawa_id);

        $user = User::findOrFail($user_id);

        // attach user with ormawa with status pending
        $ormawa->users()->attach($user, ['status' => 'pending']);

        return back()->with('success', 'Berhasil mendaftar sebagai anggota ' . $ormawa->nama);
    }

    public function gantiOrmawa(Request $request)
    {
        $validatedData = $request->validate([
            'ormawa_id' => 'required',
        ]);

        $user = User::findOrFail(auth()->user()->id);

        $user->ormawa_id = $validatedData['ormawa_id'];
        $user->save();

        return back()->with('success', 'Berhasil mengganti ormawa');
    }
}
