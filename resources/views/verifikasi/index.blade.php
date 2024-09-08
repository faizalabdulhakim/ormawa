@extends('layouts.main')

@section('title')
    Si Ormawa - Verifikasi
@endsection    

<style>
  .table th {
    white-space: normal !important;
  }
</style>

@section('content')
<div class="row">
  
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">

        <div class="row justify-content-between align-items-center mx-1 mb-2">
          <h2 class="">Verifikasi</h2>
        </div>
        
        @if (session()->has('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
        @endif

        @if (session()->has('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
        @endif


        <div class="table-responsive pt-3">
          <table class="table table-bordered table-hover table-striped" id="tblUser">
            <thead>
              <tr>
                <th>
                  Nama
                </th>
                @if(auth()->user()->id == 1)
                  <th>
                    KTM
                  </th>
                @endif
                @if(auth()->user()->role() == 'ketua')
                  <th>
                    Ormawa
                  </th>
                @endif
                <th>
                  Aksi
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
                <tr>
                  <td>
                    {{ $user->nama }}
                  </td>

                  @if(auth()->user()->id == 1)
                  <td>
                    <img src="{{ asset('storage/' . $user->ktm) }}" alt="{{ $user->nama }}" class="rounded-0 h-100" style="width: 150px;">
                  </td>
                  @endif

                  @if(auth()->user()->role() == 'ketua')
                  <td>
                    {{ $ormawa->nama }}
                  </td>
                  @endif
 
                  {{-- Aksi --}}
                  <td>

                    {{-- Admin --}}
                    @if(auth()->user()->id == 1)

                      {{-- Terima --}}
                      <form action="{{ route('user.verifikasiRegistrasi', ['id' => $user->id]) }}" method="post" class="d-inline">
                        @csrf
                        @method('patch')

                        <input type="hidden" name="status" value="terima">

                        <button type="submit" class="btn btn-success btn-sm btnVerifikasi" id="btnVerifikasiRegistrasi">Terima</button>
                      </form>

                      {{-- Tolak --}}
                      <form action="{{ route('user.verifikasiRegistrasi', ['id' => $user->id]) }}" method="post" class="d-inline">
                        @csrf
                        @method('patch')

                        <input type="hidden" name="status" value="tolak">

                        <button type="submit" class="btn btn-danger btn-sm btnVerifikasi" id="btnVerifikasiRegistrasi">Tolak</button>
                      </form>

                    @endif

                    {{-- KETUA --}}
                    @if(auth()->user()->role() == 'ketua')

                      {{-- Terima --}}
                      <form action="{{ route('user.verifikasiAnggota', ['id' => $user->id]) }}" method="post" class="d-inline">
                        @csrf
                        @method('patch')

                        <input type="hidden" name="status" value="terima">

                        <button type="submit" class="btn btn-success btn-sm btnVerifikasi" id="btnVerifikasiAnggota">Terima</button>
                      </form>

                      {{-- Tolak --}}
                      <form action="{{ route('user.verifikasiAnggota', ['id' => $user->id]) }}" method="post" class="d-inline">
                        @csrf
                        @method('patch')

                        <input type="hidden" name="status" value="tolak">

                        <button type="submit" class="btn btn-danger btn-sm btnVerifikasi" id="btnVerifikasiAnggota">Tolak</button>
                      </form>

                    @endif
                  </td>

                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    $('#tblUser').DataTable();
  });
</script>

<script>

</script>

<script>

  // Konfirmation USER
  $(function(){
    $(document).on('click', '.btnVerifikasi', function(e){
      e.preventDefault();
  
      Swal.fire({
        title: 'Apakah anda yakin?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire(
            'Berhasil!',
            'Berhasil.',
            'success'
          )

          $(this).closest("form").submit()
        }
      })
    })
  });
</script>

<script>
  setTimeout(function() {
    $('.nav-item.active').removeClass('active');

    $('ul').find('li:contains("Verifikasi")').addClass('active');

  }, 300);
</script>

@endsection