<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ormawa;
use App\Models\OrmawaUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;

use function GuzzleHttp\Promise\all;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $ormawa = Ormawa::all();

        $users = $users->sortByDesc('id')->filter(function ($user) {
            return $user->id != 1;
        });

        // dd($users);

        return view('user.index', compact('users', 'ormawa'));
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
        $ormawa = Ormawa::find($request->ormawa_id);

        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'nim' => 'nullable|string|max:255',
            'password' => 'required|string|max:255',
            'role' => 'required|string|in:ketua,sekretaris_umum,sekretaris_proker,anggota,pembina',
            'ormawa_id' => 'required|integer|exists:ormawas,id',
        ]);

        $validatedData['status'] = 'aktif';

        // KONFIRMASI PASSWORD
        if ($validatedData['password'] != $request->password_confirmation) {
            return redirect('/user/')->with('error', 'Password tidak sama dengan password konfirmasi.');
        }

        // ENCRYPT PASSWORD
        $validatedData['password'] = bcrypt($validatedData['password']);

        // CHECK NIM
        $existingNim = User::where('nim', $validatedData['nim'])->first();

        // CHECK NAME MUST SAME WITH EXISTING NIM
        if ($existingNim && $validatedData['nama'] != $existingNim->nama) {
            return redirect('/user/')->with('error', 'Nama tidak sama dengan NIM yang sudah terdaftar.');
        }

        // CHECK IF NAMA AND NIM AND ORMAWA EXIST
        $existingUser = User::where('nama', $validatedData['nama'])
                            ->where('nim', $validatedData['nim']) 
                            ->first();

        // CHECK NAMA AND NIM IS SAME ORMAWA
        if($existingUser) {
            if($existingUser->ormawa_id == $validatedData['ormawa_id']){
                return redirect('/user/')->with('error', 'User sudah terdaftar di ormawa ini.');
            }
        }
        
        // VALIDATED ROLE
        $role = $validatedData['role'];
        
        // CHECK IF ROLE IS ALREADY TAKEN
        if (in_array($role, ['ketua', 'sekretaris_umum', 'pembina'])) {
            if($ormawa && $ormawa->{$role . '_id'} != null) {
                return redirect('/user/')->with('error', ucfirst($role)  . ' ' . $ormawa->nama . ' sudah terisi.');
            } 
        }
        
        try {
            unset($validatedData['role']);
            
            $user = User::create($validatedData);

            if (in_array($role, ['ketua', 'sekretaris_umum', 'pembina'])) {
                $ormawa->{$role . '_id'} = $user->id;
                $ormawa->save();
            }

            // attach user to ormawa
            OrmawaUser::create([
                'user_id' => $user->id,
                'ormawa_id' => $validatedData['ormawa_id'],
                'status' => 'aktif',
                'role' => $role,
            ]);
            
            return redirect('/user/')->with('success', 'User berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return redirect('/user/')->with('error', 'User gagal ditambahkan.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return $user;
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
        $user = User::findOrFail($id);
        
        // IF USER IS WADIR
        if($user->id == 2){
            $validatedData = request()->validate([
                'nama' => 'required|string|max:255',
                'nim' => 'nullable|string|max:255',
            ]);
        
        // IF USER IS NOT WADIR
        }else{
            $validatedData = $request->validate([
                'nama' => 'required|string|max:255',
                'username' => [
                    Rule::unique('users')->ignore($user->id),
                    'required',
                    'string',
                    'max:255',
                ],
                'role' => 'required|string|in:admin,ketua,sekretaris_umum,sekretaris_proker,anggota,pembina',
                'nim' => 'nullable|string|max:255',
            ]);
        }

        // IF PENGURUS
        if($user->id != 2){

            // find this user in any ormawa
            $ormawaNull = Ormawa::where('ketua_id', $user->id)
                            ->orWhere('sekretaris_umum_id', $user->id)
                            ->orWhere('pembina_id', $user->id)
                            ->first();
            
            if($ormawaNull){
                if ($ormawaNull->ketua_id == $user->id) {
                    $ormawaNull->ketua_id = null;
                } elseif ($ormawaNull->sekretaris_umum_id == $user->id) {
                    $ormawaNull->sekretaris_umum_id = null;
                } elseif ($ormawaNull->sekretaris_proker_id == $user->id) {
                    $ormawaNull->sekretaris_proker_id = null;
                } elseif ($ormawaNull->pembina_id == $user->id) {
                    $ormawaNull->pembina_id = null;
                }
                $ormawaNull->save();
            }

            $ormawa = Ormawa::find($request->ormawa_id);
            $role = $validatedData['role'];
            if (in_array($role, ['ketua', 'sekretaris_umum', 'pembina'])) {
                if ($ormawa->{$role . '_id'} != null) {
                    return redirect('/user/')->with('error', 'Role ' . ucfirst($role) . ' di ' . $ormawa->nama . ' sudah diisi.');
                }
                $ormawa->{$role . '_id'} = $user->id;
                $ormawa->save();
            }

            if($role == 'anggota'){
                $ormawa->save();
            }

        }

        // // CHECK NIM
        // $existingNim = User::where('nim', $validatedData['nim'])->first();

        // // CHECK NAME MUST SAME WITH EXISTING NIM
        // if ($existingNim && $validatedData['nama'] != $existingNim->nama) {
        //     return redirect('/user/')->with('error', 'Nama tidak sama dengan NIM yang sudah terdaftar.');
        // }

        // CHECK IF NAMA AND NIM AND ORMAWA EXIST
        $existingUser = User::where('nama', $validatedData['nama'])
                            ->where('nim', $validatedData['nim']) 
                            ->first();

        // CHECK NAMA AND NIM IS SAME ORMAWA
        if($existingUser) {
            if($existingUser->ormawa_id == $request->ormawa_id){
                return redirect('/user/')->with('error', 'User sudah terdaftar di ormawa ini.');
            }
        }

        if ($user->fill($validatedData)->save()) {  
            return redirect('/user/')->with('success', 'User berhasil diupdate.');
        } else {
            return redirect('/user/')->with('error', 'User gagal diupdate.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // HARUSNYA DI HANDLE DI ON DELETE SET NULL
        // if user is ketua, sekretaris, or pembina then change ormawa ketua_id, sekretaris_id, or pembina_id to null in ormawa table
        $ormawa = Ormawa::where('ketua_id', $user->id)->orWhere('sekretaris_umum_id', $user->id)->orWhere('pembina_id', $user->id)->first();

        // buat ilangain user id di ormawa
        if($ormawa){
            if ($ormawa->ketua_id == $user->id) {
                $ormawa->ketua_id = null;
            } elseif ($ormawa->sekretaris_umum_id == $user->id) {
                $ormawa->sekretaris_umum_id = null;
            } elseif ($ormawa->sekretaris_proker_id == $user->id) {
                $ormawa->sekretaris_proker_id = null;
            } elseif ($ormawa->pembina_id == $user->id) {
                $ormawa->pembina_id = null;
            }
            $ormawa->save();
        }

        try {
            $user->ormawas()->detach();
            User::destroy($user->id);


            return redirect('/user/')->with('success', 'User berhasil dihapus.');
        }catch(\Throwable $th){
            return redirect('/user/')->with('error', 'User gagal dihapus.');
        }

    }

    public function getOrmawa(string $id){
        $user = User::findOrFail($id);

        $ormawa = $user->ormawa;
    
        return $ormawa;
    }

    public function getUser(string $id){
        $user = User::findOrFail($id);

        return $user;
    }

    public function resetPassword(Request $request, string $id){
        
        if($request->password != $request->password_confirmation){
            return redirect('/user/')->with('error', 'Password tidak sama.');
        }

        $user = User::findOrFail($id);
        $validatedData = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->password = bcrypt($validatedData['password']);

        try{
            $user->save();
            return redirect('/user/')->with('success', 'Password berhasil direset.');
        }catch(\Throwable $th){
            return redirect('/user/')->with('error', 'Password gagal direset.');
        }

    }

    public function verifikasi()
    {
        if(auth()->user()->id == 1){
            $users = User::where('status', 'pending')->get();

            return view('verifikasi.index', compact('users'));
        }elseif(auth()->user()->role() == 'ketua'){
            // find user in OrmawaUser where ormawa_id is auth()->user()->ormawa_id where status is pending
            $users = OrmawaUser::where('ormawa_id', auth()->user()->ormawa_id)->where('status', 'pending')->get();

            $users = User::whereIn('id', $users->pluck('user_id'))->get();
            $ormawa = Ormawa::findOrFail(auth()->user()->ormawa_id);

            return view('verifikasi.index', compact('users', 'ormawa'));
        }

    }

    public function verifikasiRegistrasi(string $id, Request $request)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'status' => 'required|string',
        ]);

        if($validatedData['status'] == 'terima'){
            $user->status = 'aktif';
        }elseif($validatedData['status'] == 'tolak'){
            try{
                User::destroy($user->id);
                return redirect('/user/verifikasi')->with('success', 'Verifikasi berhasil ditolak.');
            }catch(\Throwable $th){
                return redirect('/user/verifikasi')->with('error', 'Verifikasi gagal.');
            }
        }

        try{
            $user->save();
            return redirect('/user/verifikasi')->with('success', 'Verifikasi berhasil diterima.');
        }catch(\Throwable $th){
            return redirect('/user/verifikasi')->with('error', 'Verifikasi gagal.');
        }
    }

    public function verifikasiAnggota(string $id, Request $request)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'status' => 'required|string',
        ]);

        if($validatedData['status'] == 'terima'){
            try{
                // patch status in ormawa_user where user_id is $user->id and ormawa_id is auth()->user()->ormawa_id
                $ormawaUser = OrmawaUser::where('user_id', $user->id)
                                    ->where('ormawa_id', auth()->user()->ormawa_id)
                                    ->update(['status' => 'aktif']);

                $user->ormawa_id = auth()->user()->ormawa_id;
                $user->save();
                
                return redirect('/user/verifikasi')->with('success', 'Verifikasi berhasil diterima.');
            }catch(\Throwable $th){
                return redirect('/user/verifikasi')->with('error', 'Verifikasi gagal.');
            }
        }elseif($validatedData['status'] == 'tolak'){
            try{
                // delete ormawa_user where user_id is $user->id and ormawa_id is auth()->user()->ormawa_id
                OrmawaUser::where('user_id', $user->id)->where('ormawa_id', auth()->user()->ormawa_id)->delete();
                return redirect('/user/verifikasi')->with('success', 'Verifikasi berhasil ditolak.');
            }catch(\Throwable $th){
                return redirect('/user/verifikasi')->with('error', 'Verifikasi gagal.');
            }
        }

    }

    public function tambahPembina(Request $request)
    {
        // validate request user_id and ormawa_id
        $validatedData = $request->validate([
            'user_id' => 'required|string',
            'ormawa_id' => 'required|string',
        ]);

        // attach user_id and ormawa_id to ormawa_user
        $ormawaUser = new OrmawaUser;
        $ormawaUser->user_id = $validatedData['user_id'];
        $ormawaUser->ormawa_id = $validatedData['ormawa_id'];
        $ormawaUser->status = 'aktif';
        $ormawaUser->role = 'pembina';
        $ormawaUser->save();

        // update ormawa pembina_id to user_id
        $ormawa = Ormawa::findOrFail($validatedData['ormawa_id']);
        $ormawa->pembina_id = $validatedData['user_id'];
        $ormawa->save();
        
        // return back
        return redirect()->back()->with('success', 'Pembina Telah ditambahkan ke '.$ormawa->nama.'.');
    }
}
