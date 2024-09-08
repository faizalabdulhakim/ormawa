<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Lpj;
use App\Models\Komentar;
use App\Models\Ormawa;
use App\Models\Peringatan;
use App\Models\Proker;
use App\Models\Proposal;
use App\Models\User;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $totalUser = User::count();
        $totalOrmawa = Ormawa::count();
        $proposalsComingSoon = collect([]);
        $lpjsComingSoon = collect([]);
        $totalProkerPembina = [];

        if(auth()->user()->status != 'aktif'){
            auth()->logout();
            return redirect()->route('login')->with('info', 'Akun anda belum aktif');
        }
        
        if(auth()->user()->id != 1){
            $user = User::find(auth()->user()->id);
            $ormawa = $user->ormawa;
            
            $prokers = Proker::where('ormawa_id', $ormawa?->id)->get();

            // INFO DASHBOARD
            $totalProposal = 0;
            $totalLPJ = 0;
            foreach ($prokers as $proker) {
                $totalProposal += Proposal::where('proker_id', $proker->id)->count();
                $totalLPJ += Lpj::where('proker_id', $proker->id)->count();
            }

            // STATISTIK
            $totalProkers = $prokers->count();

            $totalProposalsConfirm = Proposal::where('status', 'disetujui')->count();
            $totalProposalsUnconfirm = Proposal::where('status', 'ditolak')->count();
            $totalProposalsOngoing = Proposal::where('status', 'draft')->count();

            $totalLpjsConfirm = Lpj::where('status', 'disetujui')->count();
            $totalLpjsUnconfirm = Lpj::where('status', 'ditolak')->count();
            $totalLpjsOngoing = Lpj::where('status', 'draft')->count(); 

            // totalProkersDone where Proposal and LPJ is done
            $totalProkersDone = 0;
            $totalProkersUndone = 0;
            foreach ($prokers as $proker) {
                $proposal = Proposal::where('proker_id', $proker->id)->first();
                $lpj = Lpj::where('proker_id', $proker->id)->first();

                if($proposal && $lpj){
                    if($proposal->status == 'disetujui' && $lpj->status == 'disetujui'){
                        $totalProkersDone++;
                    }else{
                        $totalProkersUndone++;
                    }
                }
            }
            
            // Notifikasi Proposal dan LPJ
            if(auth()->user()->role() == 'sekretaris_proker'){
                $proposals = Proposal::where('user_id', auth()->user()->id)->where('status', 'tanpa_isi')->get();
                $lpjs = Lpj::where('user_id', auth()->user()->id)->where('status', 'tanpa_isi')->get();

                // filter proposals->proker->deadline_proposal where deadline is 30 days from now
                $proposalsComingSoon = collect($proposals)->filter(function ($proposal) {
                    $proker = Proker::find($proposal->proker_id);
                    $deadline = Carbon::parse($proker->deadline_proposal);
                    $today = Carbon::now();

                    return $deadline->isFuture() && $deadline->diffInDays($today) >= 0 && $deadline->diffInDays($today) <= 30;
                });

                // filter lpjs->proker->deadline_lpj where deadline is 30 days from now
                $lpjsComingSoon = collect($lpjs)->filter(function ($lpj) {
                    $proker = Proker::find($lpj->proker_id);
                    $deadline = Carbon::parse($proker->deadline_lpj);
                    $today = Carbon::now();

                    return $deadline->isFuture() && $deadline->diffInDays($today) >= 0 && $deadline->diffInDays($today) <= 30;
                });
            }
            
        }else{
            $totalProkers = Proker::count();
            $totalProposal = Proposal::count();
            $totalLPJ = Lpj::count();

            $totalProposalsConfirm = Proposal::where('status', 'disetujui')->count();
            $totalLpjsConfirm = Lpj::where('status', 'disetujui')->count();

            $totalProposalsUnconfirm = Proposal::where('status', 'ditolak')->count();
            $totalLpjsUnconfirm = Lpj::where('status', 'ditolak')->count();

            $totalProposalsOngoing = Proposal::where('status', 'draft')->count();
            $totalLpjsOngoing = Lpj::where('status', 'draft')->count();

            // totalProkersDone where Proposal and LPJ is done
            $totalProkersDone = 0;
            $totalProkersUndone = 0;
            $prokers = Proker::all();
            foreach ($prokers as $proker) {
                $proposal = Proposal::where('proker_id', $proker->id)->first();
                $lpj = Lpj::where('proker_id', $proker->id)->first();

                if($proposal && $lpj){
                    if($proposal->status == 'disetujui' && $lpj->status == 'disetujui'){
                        $totalProkersDone++;
                    }else{
                        $totalProkersUndone++;
                    }
                }
            }

        }

        return view('dashboard', compact('totalUser', 'totalOrmawa', 'totalProkers', 'totalProposal', 'totalLPJ', 'totalProposalsConfirm', 'totalLpjsConfirm', 'totalProposalsUnconfirm', 'totalLpjsUnconfirm', 'totalProposalsOngoing', 'totalLpjsOngoing', 'totalProkersDone', 'totalProkersUndone', 'proposalsComingSoon', 'lpjsComingSoon', 'prokers'));
    }

    public function notifikasi()
    {
        if(auth()->user()->role() == 'sekretaris_proker'){
            $user = User::find(auth()->user()->id);
            $ormawa = $user->ormawa;
            
            $peringatanProposals = Peringatan::where('user_id', $user->id)->where('ormawa_id', $ormawa->id)->where('tipe', 'proposal')->get();
            $peringatanLpjs = Peringatan::where('user_id', $user->id)->where('ormawa_id', $ormawa->id)->where('tipe', 'lpj')->get();

            $feedbackProposals = Feedback::where('user_id', $user->id)->where('ormawa_id', $ormawa->id)->where('tipe', 'proposal')->get();
            $feedbackLpjs = Feedback::where('user_id', $user->id)->where('ormawa_id', $ormawa->id)->where('tipe', 'lpj')->get();

            $komentarProposals = Komentar::where('user_id', $user->id)->where('ormawa_id', $ormawa->id)->where('tipe', 'proposal')->get();
            $komentarLpjs = Komentar::where('user_id', $user->id)->where('ormawa_id', $ormawa->id)->where('tipe', 'lpj')->get();

            foreach ($peringatanProposals as $peringatan) {
                $peringatan->is_open = true;
                $peringatan->save();
            }

            foreach ($peringatanLpjs as $peringatan) {
                $peringatan->is_open = true;
                $peringatan->save();
            }

            foreach ($feedbackProposals as $feedback) {
                $feedback->is_open = true;
                $feedback->save();
            }

            foreach ($feedbackLpjs as $feedback) {
                $feedback->is_open = true;
                $feedback->save();
            }

            foreach ($komentarProposals as $komentar) {
                $komentar->is_open = true;
                $komentar->save();
            }

            foreach ($komentarLpjs as $komentar) {
                $komentar->is_open = true;
                $komentar->save();
            }

        }elseif(auth()->user()->role() == 'admin'){
            $peringatanProposals = Peringatan::where('tipe', 'proposal')->get();
            $peringatanLpjs = Peringatan::where('tipe', 'lpj')->get();

            $feedbackProposals = Feedback::where('tipe', 'proposal')->get();;
            $feedbackLpjs = Feedback::where('tipe', 'lpj')->get();

            $komentarProposals = Komentar::where('tipe', 'proposal')->get();
            $komentarLpjs = Komentar::where('tipe', 'lpj')->get();
        }elseif(auth()->user()->role() == 'pembina'){
            $user = User::find(auth()->user()->id);
            $ormawa = $user->ormawa;

            $komentarsProposalPembina = Komentar::where('user_id', $user->id)->where('ormawa_id', $ormawa->id)->where('tipe', 'proposal')->get();
            $komentarsLpjPembina = Komentar::where('user_id', $user->id)->where('ormawa_id', $ormawa->id)->where('tipe', 'lpj')->get();

            foreach ($komentarsProposalPembina as $komentar) {
                $komentar->is_open = true;
                $komentar->save();
            }

            foreach ($komentarsLpjPembina as $komentar) {
                $komentar->is_open = true;
                $komentar->save();
            }
        }

        $prokersComingSoon = $this->getProkersComingSoon();

        if(auth()->user()->role() != 'admin')
        $prokersComingSoon = collect($prokersComingSoon)->filter(function ($proker) {
            $user = User::find(auth()->user()->id);
            $ormawa = $user->ormawa;

            return $proker->ormawa_id == $ormawa->id;
        });

        if(auth()->user()->role() == 'sekretaris_proker' || auth()->user()->id == 1){
            return view('notifikasi.index', compact('peringatanProposals', 'peringatanLpjs', 'feedbackProposals', 'feedbackLpjs', 'komentarProposals', 'komentarLpjs', 'prokersComingSoon'));
        }elseif(auth()->user()->role() == 'pembina'){
            return view('notifikasi.index', compact('komentarsProposalPembina', 'komentarsLpjPembina', 'prokersComingSoon'));
        }else{
            return view('notifikasi.index', compact('prokersComingSoon'));
        }

    }

    public function destroyFeedback(string $id)
    {
        $feedback = Feedback::find($id);
        $feedback->delete();

        return redirect()->back()->with('success', 'Feedback berhasil dihapus.');
    }

    public function destroyKomentar(string $id)
    {
        $komentar = Komentar::find($id);
        $komentar->delete();

        return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
    }
    
    public function getProkersComingSoon()
    {
        $today = Carbon::now();
        $prokers = Proker::all();
        $prokersComingSoon = [];

        foreach ($prokers as $proker) {
            $executionDate = Carbon::parse($proker->tanggal_pelaksanaan);

            if ($executionDate->isAfter($today)) {
                $diffInDays = $today->diffInDays($executionDate);
                $proker->selisih_hari = $diffInDays + 1;

                if ($diffInDays < 30) {
                    $prokersComingSoon[] = $proker;
                }
            }
        }

        return $prokersComingSoon;
    }
}
