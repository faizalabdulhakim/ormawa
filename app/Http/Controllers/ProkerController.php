<?php

namespace App\Http\Controllers;

use App\Models\Proker;
use App\Http\Controllers\Controller;
use App\Models\Lpj;
use App\Models\Ormawa;
use App\Models\OrmawaUser;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Http\Request;
use Termwind\Components\Dd;

class ProkerController extends Controller
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

        if(auth()->user()->role() == 'sekretaris_umum'){
            $ormawa = auth()->user()->ormawa;
            $sekpros = OrmawaUser::where('role', 'sekretaris_proker')->where('ormawa_id', $ormawa->id)->get();
            $sekpros = $sekpros->map(function ($item, $key) {
                return User::find($item->user_id);
            });

            if ($selectedMonth) {
                $prokers = Proker::where('ormawa_id', $ormawa?->id)
                    ->whereMonth('tanggal_pelaksanaan', $selectedMonth)
                    ->get();
            } else {
                $prokers = Proker::where('ormawa_id', $ormawa?->id)->get();
            }

            return view('proker.index', compact('prokers', 'ormawa', 'sekpros', 'bulanOptions', 'selectedBulan'));

        }else if(auth()->user()->role() != 'admin'){
            $sekpro = User::find(auth()->user()->id);
            $ormawa = auth()->user()->ormawa;
            
            if ($selectedMonth) {
                $prokers = Proker::where('ormawa_id', $ormawa?->id)
                    ->whereMonth('tanggal_pelaksanaan', $selectedMonth)
                    ->get();
            } else {
                $prokers = Proker::where('ormawa_id', $ormawa?->id)->get();
            }

        }else{
            $ormawas = Ormawa::all();

            if ($selectedMonth) {
                $prokers = Proker::whereMonth('tanggal_pelaksanaan', $selectedMonth)->get();
            } else {
                $prokers = Proker::all();
            }

            return view('proker.index', compact('prokers', 'ormawas', 'bulanOptions', 'selectedBulan'));
        }

        return view('proker.index', compact('prokers', 'ormawa', 'sekpro', 'bulanOptions', 'selectedBulan'));
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
            'tanggal_pelaksanaan' => 'required|date_format:m/d/Y|unique:prokers,tanggal_pelaksanaan,NULL,id,ormawa_id,' . $request->ormawa_id,
            'deadline_proposal' => 'required|date_format:m/d/Y',
            'deadline_lpj' => 'required|date_format:m/d/Y',
            'user_id' => 'required|max:255|exists:users,id',
        ]);

        $validatedData['ormawa_id'] = auth()->user()->ormawa->id;
        
        $validatedData['tanggal_pelaksanaan'] = date('Y-m-d', strtotime($validatedData['tanggal_pelaksanaan']));
        $validatedData['deadline_proposal'] = date('Y-m-d', strtotime($validatedData['deadline_proposal']));
        $validatedData['deadline_lpj'] = date('Y-m-d', strtotime($validatedData['deadline_lpj']));

        // check in this ormawa, ketua_id, sekretaris_umum_id, sekretaris_proker_id, and pembina_id must available
        $ormawa = Ormawa::find(auth()->user()->ormawa->id);
        if($ormawa->ketua_id == null || $ormawa->sekretaris_umum_id == null || $ormawa->pembina_id == null){
            return redirect('/proker/')->with('error', 'Proker gagal ditambahkan. Lengkapi semua pengurus ormawa!.');
        }

        try{
            $proker = Proker::create($validatedData);
            
            $proposal = [
                'judul' => 'Proposal ' . $proker->nama,
                'user_id' => $validatedData['user_id'],
                'proker_id' => $proker->id,
                'status' => 'tanpa_isi',
            ];

            $proposal = Proposal::create($proposal);

            $lpj = [
                'judul' => 'LPJ ' . $proker->nama,
                'user_id' => $validatedData['user_id'],
                'proker_id' => $proker->id,
                'proposal_id' => $proposal->id,
            ];
            
            $lpj = Lpj::create($lpj);

            if ($proker && $proposal && $lpj) {
                return redirect('/proker/')->with('success', 'Proker berhasil ditambahkan.');
            } else {
                return redirect('/proker/')->with('error', 'Proker gagal ditambahkan.');
            }
        }catch(\Exception $e){
            return redirect('/proker/')->with('error', 'Proker gagal ditambahkan. Periksa kembali data yang diinputkan.');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $proker = Proker::findOrFail($id);
        return $proker;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proker $proker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proker $proker)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date_format:m/d/Y|unique:prokers,tanggal_pelaksanaan,'.$proker->id,
            'deadline_proposal' => 'required|date_format:m/d/Y',
            'deadline_lpj' => 'required|date_format:m/d/Y',
            'user_id' => 'required|max:255|exists:users,id',
        ]);

        $validatedData['tanggal_pelaksanaan'] = date('Y-m-d', strtotime($validatedData['tanggal_pelaksanaan']));
        $validatedData['deadline_proposal'] = date('Y-m-d', strtotime($validatedData['deadline_proposal']));
        $validatedData['deadline_lpj'] = date('Y-m-d', strtotime($validatedData['deadline_lpj']));

        try {
            $proker->update($validatedData);

            $proposalUpdate = [
                'judul' => 'Proposal ' . $proker->nama,
                'user_id' => $validatedData['user_id'],
                'proker_id' => $proker->id,
            ];

            $proposal = Proposal::where('proker_id', $proker->id)->first();
            $proposal->update($proposalUpdate);

            $lpjUpdate = [
                'judul' => 'LPJ ' . $proker->nama,
                'user_id' => $validatedData['user_id'],
                'proker_id' => $proker->id,
            ];

            $lpj = Lpj::where('proker_id', $proker->id)->first();
            $lpj->update($lpjUpdate);

            return redirect('/proker/')->with('success', 'Proker berhasil diubah.');
        } catch (\Exception $e) {
            return redirect('/proker/')->with('error', 'Proker gagal diubah. Periksa kembali data yang diinputkan.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proker $proker)
    {
        try {
            $proker->delete();
            
            $proposal = Proposal::where('proker_id', $proker->id)->first();
            $proposal->delete();

            $lpj = Lpj::where('proker_id', $proker->id)->first();
            $lpj->delete();

            return redirect('/proker/')->with('success', 'Proker berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect('/proker/')->with('error', 'Proker gagal dihapus.');
        }
    }
}
