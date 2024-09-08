<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Komentar;
use App\Models\Ormawa;
use App\Models\Peringatan;
use App\Models\Proker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\PDF;

class ProposalController extends Controller
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
        $proposals = Proposal::all();
        if ($selectedMonth) {
            $prokers = Proker::whereMonth('deadline_proposal', $selectedMonth)->get();
            $proposals = Proposal::whereIn('proker_id', $prokers->pluck('id'))->get();
        }

        $now = date('Y-m-d');

        if(auth()->user()->role() == 'sekretaris_umum'){
            $ormawa = Ormawa::where('sekretaris_umum_id', auth()->user()->id)->first();

            $proposals = $proposals->filter(function($proposal) use ($ormawa){
                return $proposal->proker->ormawa->id == $ormawa->id;
            });

        }else if(auth()->user()->role() == 'sekretaris_proker'){
            $proposals = Proposal::where('user_id', auth()->user()->id)->get();
        }else if(auth()->user()->role() == 'ketua'){

            $ketua = User::find(auth()->user()->id);
            $ormawa = Ormawa::where('ketua_id', $ketua->id)->first();

            $proposals = $proposals->filter(function($proposal) use ($ormawa){
                return $proposal->proker->ormawa->id == $ormawa->id;
            });
            
        }else if(auth()->user()->role() == 'pembina'){
            $ormawa = Ormawa::where('pembina_id', auth()->user()->id)->where('id', auth()->user()->ormawa_id)->first();

            $proposals = $proposals->filter(function($proposal) use ($ormawa){
                return $proposal->proker->ormawa->id == $ormawa->id;
            });
        }else if(auth()->user()->role() == 'anggota'){
            $ormawa = auth()->user()->ormawa;

            $proposals = $proposals->filter(function($proposal) use ($ormawa){
                return $proposal->proker->ormawa->id == $ormawa->id;
            });
        }

        return view('proposal.index', compact('proposals', 'prokers', 'now', 'bulanOptions', 'selectedBulan'));
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
        $proposal = Proposal::find($id);
        return $proposal;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proposal $proposal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proposal $proposal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proposal $proposal)
    {
        
    }

    public function tindakan(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => [
                Rule::unique('proposals')->ignore($request->proposal_id),
                'required',
                'string',
                'max:255',
            ],
            'proposal_id' => 'required|exists:proposals,id',
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
                    'dokumen_id' => $validatedData['proposal_id'],
                    'tipe' => 'proposal',
                    'status' => $validatedData['status'],
                    'user_id' => $validatedData['user_id'],
                    'ormawa_id' => $validatedData['ormawa_id'],
                    'feedback' => $validatedData['feedback'],
                ]
            );
            
            $proposal = Proposal::find($validatedData['proposal_id']);
    
            $proposal->fill(['judul' => $judul]);
            $proposal->fill(['status' => $validatedData['status']]);
            $proposal->fill(['proker_id' => $prokerId]);
            $proposal->fill(['user_id' => $validatedData['user_id']]);
            $proposal->save();

            return redirect('/proposal/')->with('success', 'Proposal berhasil ditindak.');
        } catch (\Exception $e) {
            return redirect('/proposal/')->with('error', 'Proposal gagal ditindak.');
        }
    }

    public function peringatan(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => [
                Rule::unique('proposals')->ignore($request->proposal_id),
                'required',
                'string',
                'max:255',
            ],
            'proposal_id' => 'required|exists:proposals,id',
            'user_id' => 'required|exists:users,id',
            'peringatan' => 'nullable|string|max:255',
        ]);
        
        $proker = Proker::where('id', $request->proker_id)->first();
        $validatedData['ormawa_id'] = $proker->ormawa_id;
        
        try {
            Peringatan::create(
                [
                    'dokumen_id' => $validatedData['proposal_id'],
                    'tipe' => 'proposal',
                    'user_id' => $validatedData['user_id'],
                    'ormawa_id' => $validatedData['ormawa_id'],
                    'peringatan' => $validatedData['peringatan'],
                ]
            );

            return redirect('/proposal/')->with('success', 'Berhasil memberi peringatan.');
        } catch (\Exception $e) {
            return redirect('/proposal/')->with('error', 'Gagal memberi peringatan.');
        }
    }

    public function template(string $id)
    {
        $proposal = Proposal::find($id);

        $ormawa = $proposal->proker->ormawa;
        $users = $proposal->proker->ormawa->users;

        if(auth()->user()->role() == 'pembina'){
            $proposal->isViewed = true;
            $proposal->save();
        }

        return view('proposal.template', compact('proposal', 'ormawa', 'users'));
    }

    public function print(Request $request)
    {
        // Pembina
        if(auth()->user()->role() == 'pembina'){
            try {
                $validatedData = $request->validate([
                    'proposal_id' => 'required|exists:proposals,id',
                    'komentar_latar_belakang' => 'nullable',
                    'komentar_nama' => 'nullable',
                    'komentar_tema' => 'nullable',
                    'komentar_tujuan' => 'nullable',
                    'komentar_target' => 'nullable',
                    'komentar_konsep' => 'nullable',
                    'komentar_waktu' => 'nullable',
                    'komentar_susunan_kegiatan' => 'nullable',
                    'komentar_susunan_kepanitiaan' => 'nullable',
                    'komentar_rab' => 'nullable',
                    'komentar_penutup' => 'nullable',
                ]);
                
                $id = $validatedData['proposal_id'];
                $proposal = Proposal::find($id);
                
                unset($validatedData['proposal_id']);
                foreach ($validatedData as $key => $value) {
                    if($value != $proposal->$key ){
                        Komentar::create([
                            'tipe' => 'proposal',
                            'dokumen_id' => $request->proposal_id,
                            'user_id' => $proposal->user_id,
                            'ormawa_id' => $proposal->proker->ormawa->id,
                            'bagian' => $key,
                        ]);
                    }
                }

                $validatedData['proposal_id'] = $id;
    
                $proposal = Proposal::find($validatedData['proposal_id']);
                $proposal->fill($validatedData);
                $proposal->save();
    
                return redirect('/proposal/')->with('success', 'Berhasil Memberi Komentar.');
            } catch (\Throwable $th) {
                return redirect('/proposal/')->with('error', 'Gagal Memberi Komentar.');
            }
        }

        // Sekretaris Proker
        if($request->cover){
            $validatedData = $request->validate([
                'cover' => 'required|image|max:5024',
                'proposal_id' => 'required|exists:proposals,id',
                'latar_belakang' => 'required',
                'nama' => 'required',
                'tema' => 'required',
                'tujuan' => 'required',
                'target' => 'required',
                'konsep' => 'required',
                'waktu' => 'required',
                'susunan_kegiatan' => 'required',
                'susunan_kepanitiaan' => 'required',
                'rab' => 'required',
                'penutup' => 'required',
            ]);
        }else{
            $proposalCover = Proposal::find($request->proposal_id);
            if($proposalCover->cover){
                $validatedData = $request->validate([
                    'proposal_id' => 'required|exists:proposals,id',
                    'latar_belakang' => 'required',
                    'nama' => 'required',
                    'tema' => 'required',
                    'tujuan' => 'required',
                    'target' => 'required',
                    'konsep' => 'required',
                    'waktu' => 'required',
                    'susunan_kegiatan' => 'required',
                    'susunan_kepanitiaan' => 'required',
                    'rab' => 'required',
                    'penutup' => 'required',
                ]);
            }else{
                $validatedData = $request->validate([
                    'cover' => 'required|image|max:5024',
                    'proposal_id' => 'required|exists:proposals,id',
                    'latar_belakang' => 'required',
                    'nama' => 'required',
                    'tema' => 'required',
                    'tujuan' => 'required',
                    'target' => 'required',
                    'konsep' => 'required',
                    'waktu' => 'required',
                    'susunan_kegiatan' => 'required',
                    'susunan_kepanitiaan' => 'required',
                    'rab' => 'required',
                    'penutup' => 'required',
            ]);
            }
        }
        
        if($request->ketua_pelaksana){
            $ketua_pelaksana = User::find($request->ketua_pelaksana);
            $validatedData['ketua_pelaksana'] = $ketua_pelaksana->nama;
            $validatedData['nim_ketua_pelaksana'] = $ketua_pelaksana->nim;
        }

        if($request->ketua_jurusan){
            $validatedData['ketua_jurusan'] = $request->ketua_jurusan;
            $validatedData['nip_ketua_jurusan'] = $request->nip_ketua_jurusan;
        }

        try {
            $proposal = Proposal::find($validatedData['proposal_id']);
            unset($validatedData['proposal_id']);
            
            if($request->tipe == 'simpan'){
                $proposal->fill(['status' => 'draft']);
            }else if($request->tipe == 'ajukan'){
                $proposal->fill(['status' => 'diajukan']);
            }

            if($request->cover){
                $validatedData['cover'] = $request->file('cover')->store('proposal/cover');
            }
            
            $proposal->isViewed = false;

            Komentar::create([
                'tipe' => 'proposal',
                'dokumen_id' => $request->proposal_id,
                'user_id' => $proposal->proker->ormawa->pembina_id,
                'ormawa_id' => $proposal->proker->ormawa->id,
            ]);
            
            $proposal->fill($validatedData);
            $proposal->save();
            
            Peringatan::where('dokumen_id', $proposal->id)->delete();

            return redirect('/proposal/')->with('success', 'Template Proposal berhasil dibuat.');
        } catch (\Exception $e) {
            return redirect('/proposal/')->with('error', 'Template Proposal gagal dibuat.');
        }
        
    }

    public function download(string $id)
    {
        $ormawa = Ormawa::where('jenis', 'BEM')->where('angkatan', date('Y'))->first();   
        $ketua_bem = User::find($ormawa?->ketua_id);

        $ormawa = Ormawa::where('jenis', 'MPM')->where('angkatan', date('Y'))->first();
        $ketua_mpm = User::find($ormawa?->ketua_id);

        $wadir = User::where('username', 'wadir-polsub')->first();

        $proposal = Proposal::find($id);

        if($proposal->proker->ormawa->jenis == 'UKM'){
            $pdf = PDF::loadView('proposal.jenis.ukm', compact('proposal', 'ketua_bem', 'ketua_mpm', 'wadir'));
        }else if($proposal->proker->ormawa->jenis == 'HMJ'){
            $pdf = PDF::loadView('proposal.jenis.hmj', compact('proposal', 'ketua_bem', 'ketua_mpm', 'wadir'));
        }else if($proposal->proker->ormawa->jenis == 'BEM'){
            $pdf = PDF::loadView('proposal.jenis.bem', compact('proposal', 'ketua_bem', 'ketua_mpm', 'wadir'));
        }else if($proposal->proker->ormawa->jenis == 'MPM'){
            $pdf = PDF::loadView('proposal.jenis.mpm', compact('proposal', 'ketua_bem', 'ketua_mpm', 'wadir'));
        }else{
            $pdf = PDF::loadView('proposal.print', compact('proposal', 'ketua_bem', 'ketua_mpm', 'wadir'));
        }
            
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('Proposal ' . $proposal->proker->nama . '.pdf');
    }
}
