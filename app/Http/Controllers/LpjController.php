<?php

namespace App\Http\Controllers;

use App\Models\Lpj;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Komentar;
use App\Models\Ormawa;
use App\Models\Peringatan;
use App\Models\Proker;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\PDF;

class LpjController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selectedMonth = $request->bulanFilter;
        $bulanOptions = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        if($selectedMonth == 'Semua Bulan'){
            $selectedMonth = null;
        }
        
        $selectedBulan = $selectedMonth;
        if ($selectedMonth) {
            $selectedMonth = array_search($selectedMonth, $bulanOptions) + 1;
        }

        $prokers = Proker::all();
        $lpjs = Lpj::all();
        if ($selectedMonth) {
            $prokers = Proker::whereMonth('deadline_lpj', $selectedMonth)->get();
            $lpjs = Lpj::whereIn('proker_id', $prokers->pluck('id'))->get();
        }

        $now = date('Y-m-d');

        if(auth()->user()->role() == 'sekretaris_umum'){
            $ormawa = Ormawa::where('sekretaris_umum_id', auth()->user()->id)->first();

            $lpjs = $lpjs->filter(function($lpj) use ($ormawa){
                return $lpj->proker->ormawa->id == $ormawa->id;
            });
        }else if(auth()->user()->role() == 'sekretaris_proker'){
            $lpjs = Lpj::where('user_id', auth()->user()->id)->get();
        }else if(auth()->user()->role() == 'ketua'){
            $ketua = User::find(auth()->user()->id);
            $ormawa = Ormawa::where('ketua_id', $ketua->id)->first();

            $lpjs = $lpjs->filter(function($lpj) use ($ormawa){
                return $lpj->proker->ormawa->id == $ormawa->id;
            });
        }else if(auth()->user()->role() == 'pembina'){
            $pembina = User::find(auth()->user()->id);
            $ormawa = Ormawa::where('pembina_id', auth()->user()->id)->where('id', auth()->user()->ormawa_id)->first();

            $lpjs = $lpjs->filter(function($lpj) use ($ormawa){
                return $lpj->proker->ormawa->id == $ormawa->id;
            });
        }else if(auth()->user()->role() == 'anggota'){
            $ormawa = auth()->user()->ormawa;

            $lpjs = $lpjs->filter(function($lpj) use ($ormawa){
                return $lpj->proker->ormawa->id == $ormawa->id;
            });
        }

        return view('lpj.index', compact('lpjs', 'prokers', 'now', 'bulanOptions', 'selectedBulan'));
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

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lpj = Lpj::find($id);
        return $lpj;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lpj $lpj)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lpj $lpj)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lpj $lpj)
    {

    }

     public function tindakan(Request $request)
    {
        
        $validatedData = $request->validate([
            'judul' => [
                Rule::unique('lpjs')->ignore($request->lpj_id),
                'required',
                'string',
                'max:255',
            ],
            'lpj_id' => 'required|exists:lpjs,id',
            'feedback' => 'nullable|string|max:255',
            'status' => 'required|in:tanpa_isi,draft,diajukan,disetujui,ditolak',
            'proker_id' => 'required|exists:prokers,id',
            'user_id' => 'required|exists:users,id',
        ]);
        
        $proker = Proker::where('id', $request->proker_id)->first();
        $validatedData['ormawa_id'] = $proker->ormawa_id;

        $judul = $validatedData['judul'];
        unset($validatedData['judul']);

        $prokerId = $validatedData['proker_id'];
        unset($validatedData['proker_id']);

        try {
            Feedback::create(
                [
                    'dokumen_id' => $validatedData['lpj_id'],
                    'tipe' => 'lpj',
                    'status' => $validatedData['status'],
                    'user_id' => $validatedData['user_id'],
                    'ormawa_id' => $validatedData['ormawa_id'],
                    'feedback' => $validatedData['feedback'],
                ]
            );
            
            $lpj = Lpj::find($validatedData['lpj_id']);
    
            $lpj->fill(['judul' => $judul]);
            $lpj->fill(['status' => $validatedData['status']]);
            $lpj->fill(['proker_id' => $prokerId]);
            $lpj->fill(['user_id' => $validatedData['user_id']]);
            $lpj->save();

            return redirect('/lpj/')->with('success', 'Laporan Pertanggungjawaban berhasil ditindak.');
        } catch (\Exception $e) {
            return redirect('/lpj/')->with('error', 'Laporan Pertanggungjawaban gagal ditindak.');
        }
    }

    public function peringatan(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => [
                Rule::unique('lpjs')->ignore($request->lpj_id),
                'required',
                'string',
                'max:255',
            ],
            'lpj_id' => 'required|exists:lpjs,id',
            'user_id' => 'required|exists:users,id',
            'peringatan' => 'nullable|string|max:255',
        ]);

        $proker = Proker::where('id', $request->proker_id)->first();
        $validatedData['ormawa_id'] = $proker->ormawa_id;

        try {
            Peringatan::create(
                [
                    'dokumen_id' => $validatedData['lpj_id'],
                    'tipe' => 'lpj',
                    'user_id' => $validatedData['user_id'],
                    'ormawa_id' => $validatedData['ormawa_id'],
                    'peringatan' => $validatedData['peringatan'],
                ]
            );

            return redirect('/lpj/')->with('success', 'Berhasil memberi peringatan.');
        } catch (\Exception $e) {
            return redirect('/lpj/')->with('error', 'Gagal memberi peringatan.');
        }
    }

    public function template(string $id)
    {
        $lpj = lpj::find($id);

        $ormawa = $lpj->proker->ormawa;
        $users = $lpj->proker->ormawa->users;

        if(auth()->user()->role() == 'pembina'){
            $lpj->isViewed = true;
            $lpj->save();
        }

        return view('lpj.template', compact('lpj', 'ormawa', 'users'));
    }

    public function upload(Request $request){
        // $fileName=$request->file('file')->getClientOriginalName();
        // $path=$request->file('file')->storeAs('uploads', $fileName, 'public');
        // return response()->json(['location'=>"/storage/$path"]);

        $imgpath = request()->file('file')->store('lpj/bukti-dan-dokumentasi');
        // return $imgpath;
        return response()->json(['location' => "/storage/$imgpath"]);
    }


    public function print(Request $request)
    {

        // PEMBINA
        if(auth()->user()->role() == 'pembina'){
            try {
                $validatedData = $request->validate([
                    'lpj_id' => 'required|exists:lpjs,id',
                    'komentar_kata_pengantar' => 'nullable',
                    'komentar_latar_belakang' => 'nullable',
                    'komentar_nama' => 'nullable',
                    'komentar_tema' => 'nullable',
                    'komentar_tujuan' => 'nullable',
                    'komentar_sasaran' => 'nullable',
                    'komentar_konsep' => 'nullable',
                    'komentar_waktu' => 'nullable',
                    'komentar_kendala' => 'nullable',
                    'komentar_susunan_kegiatan' => 'nullable',
                    'komentar_susunan_kepanitiaan' => 'nullable',
                    'komentar_rab' => 'nullable',
                    'komentar_penutup' => 'nullable',
                    'komentar_bukti_transaksi' => 'nullable',
                    'komentar_dokumentasi' => 'nullable',
                ]);
                
                $id = $validatedData['lpj_id'];
                $lpj = Lpj::find($id);
                
                unset($validatedData['lpj_id']);
                foreach ($validatedData as $key => $value) {
                    if($value != $lpj->$key ){
                        Komentar::create([
                            'tipe' => 'lpj',
                            'dokumen_id' => $request->lpj_id,
                            'user_id' => $lpj->user_id,
                            'ormawa_id' => $lpj->proker->ormawa->id,
                            'bagian' => $key,
                        ]);
                    }
                }

                $validatedData['lpj_id'] = $id;
    
                $lpj = Lpj::find($validatedData['lpj_id']);
                $lpj->fill($validatedData);
                $lpj->save();
    
                return redirect('/lpj/')->with('success', 'Berhasil Memberi Komentar.');
            } catch (\Throwable $th) {
                return redirect('/lpj/')->with('error', 'Gagal Memberi Komentar.');
            }
        }

        // SEKPRO
        if($request->cover){
            $validatedData = $request->validate([
                'cover' => 'required|image|max:5024',
                'lpj_id' => 'required|exists:lpjs,id',
                'kata_pengantar' => 'required',
                'latar_belakang' => 'required',
                'nama' => 'required',
                'tema' => 'required',
                'tujuan' => 'required',
                'sasaran' => 'required',
                'waktu' => 'required',
                'kendala' => 'required',
                'susunan_kegiatan' => 'required',
                'susunan_kepanitiaan' => 'required',
                'rab' => 'required',
                'bukti_transaksi' => 'required',
                'dokumentasi' => 'required',
                'penutup' => 'required',
            ]);
        }else{
            $lpjCover = Lpj::find($request->lpj_id);
            if($lpjCover->cover){
                $validatedData = $request->validate([
                    'lpj_id' => 'required|exists:lpjs,id',
                    'kata_pengantar' => 'required',
                    'latar_belakang' => 'required',
                    'nama' => 'required',
                    'tema' => 'required',
                    'tujuan' => 'required',
                    'sasaran' => 'required',
                    'waktu' => 'required',
                    'kendala' => 'required',
                    'susunan_kegiatan' => 'required',
                    'susunan_kepanitiaan' => 'required',
                    'rab' => 'required',
                    'bukti_transaksi' => 'required',
                    'dokumentasi' => 'required',
                    'penutup' => 'required',
                ]);
            }else{
                $validatedData = $request->validate([
                    'cover' => 'required|image|max:5024',
                    'lpj_id' => 'required|exists:lpjs,id',
                    'kata_pengantar' => 'required',
                    'latar_belakang' => 'required',
                    'nama' => 'required',
                    'tema' => 'required',
                    'tujuan' => 'required',
                    'sasaran' => 'required',
                    'waktu' => 'required',
                    'kendala' => 'required',
                    'susunan_kegiatan' => 'required',
                    'susunan_kepanitiaan' => 'required',
                    'rab' => 'required',
                    'bukti_transaksi' => 'required',
                    'dokumentasi' => 'required',
                    'penutup' => 'required',
                ]);
            }
        }

        // BUKTI TRANSAKSI
        if($validatedData['bukti_transaksi']){
            // dd($validatedData['bukti_transaksi']);
            // $pattern = '/src="([^"]+)"/';

            // $validatedData['bukti_transaksi'] = preg_replace_callback($pattern, function ($matches) {
            //     $src = $matches[1];
            //     $filename = basename($src);
            //     $newSrc = "{{ asset('storage/lpj/bukti-dan-dokumentasi/{$filename}') }}";
            //     return "src=\"{$newSrc}\"";
            // }, $validatedData['bukti_transaksi']);

            // dd($replacedString);
        }

        try {
            $lpj = Lpj::find($validatedData['lpj_id']);
            unset($validatedData['lpj_id']);

            if($request->tipe == 'simpan'){
                $lpj->fill(['status' => 'draft']);
            }else if($request->tipe == 'ajukan'){
                $lpj->fill(['status' => 'diajukan']);
            }

            if($request->cover){
                $validatedData['cover'] = $request->file('cover')->store('lpj/cover');
            }

            $lpj->isViewed = false;

            Komentar::create([
                'tipe' => 'lpj',
                'dokumen_id' => $request->lpj_id,
                'user_id' => $lpj->proker->ormawa->pembina_id,
                'ormawa_id' => $lpj->proker->ormawa->id,
            ]);

            $lpj->fill($validatedData);
            $lpj->save();

            Peringatan::where('dokumen_id', $lpj->id)->delete();

            return redirect('/lpj/')->with('success', 'Template LPJ berhasil dibuat.');
        } catch (\Exception $e) {
            dd($e);
            return redirect('/lpj/')->with('error', 'Template LPJ gagal dibuat.');
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

    public function download(string $id)
    {
        $ormawa = Ormawa::where('jenis', 'BEM')->where('angkatan', date('Y'))->first();   
        $ketua_bem = User::find($ormawa?->ketua_id);

        $ormawa = Ormawa::where('jenis', 'MPM')->where('angkatan', date('Y'))->first();
        $ketua_mpm = User::find($ormawa?->ketua_id);

        $lpj = Lpj::find($id);
        $proposal = Proposal::find($lpj->proposal_id);

        $wadir = User::where('username', 'wadir-polsub')->first();

        $sekpro = User::find($lpj->user_id);

        $buktis = $this->extractImageUrls($lpj->bukti_transaksi);
        $dokumentasis = $this->extractImageUrls($lpj->dokumentasi);

        if($proposal->proker->ormawa->jenis == 'UKM'){
            $pdf = PDF::loadView('lpj.jenis.ukm', compact('lpj', 'proposal', 'ketua_bem', 'ketua_mpm', 'sekpro', 'wadir', 'buktis', 'dokumentasis'));
        }else if($proposal->proker->ormawa->jenis == 'HMJ'){
            $pdf = PDF::loadView('lpj.jenis.hmj', compact('lpj', 'proposal', 'ketua_bem', 'ketua_mpm', 'sekpro', 'wadir', 'buktis', 'dokumentasis'));
        }else if($proposal->proker->ormawa->jenis == 'BEM'){
            $pdf = PDF::loadView('lpj.jenis.bem', compact('lpj', 'proposal', 'ketua_bem', 'ketua_mpm', 'sekpro', 'wadir', 'buktis', 'dokumentasis'));
        }else if($proposal->proker->ormawa->jenis == 'MPM'){
            $pdf = PDF::loadView('lpj.jenis.mpm', compact('lpj', 'proposal', 'ketua_bem', 'ketua_mpm', 'sekpro', 'wadir', 'buktis', 'dokumentasis'));
        }else{
            $pdf = PDF::loadView('lpj.print', compact('lpj', 'proposal', 'ketua_bem', 'ketua_mpm', 'sekpro', 'wadir', 'buktis', 'dokumentasis'));
        }

        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('LPJ ' . $lpj->proker->nama . '.pdf');
    }

}
