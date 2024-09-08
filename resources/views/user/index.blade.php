@extends('layouts.main')

@section('title')
    Si Ormawa - User
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
          <h2 class="">Pengguna</h2>
  
          <button class="btn btn-primary items-center" data-toggle="modal" data-target="#tambahUserModal">
            <i class="mdi mdi-account-plus"></i>
            Tambah Pengguna
          </button>
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
                  ID
                </th>
                <th>
                  Nama
                </th>
                <th>
                  NIM/NIP
                </th>
                <th>
                  Username
                </th>
                <th>
                  Peran
                </th>
                <th>
                  Aksi
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
                <tr>
                  <td>
                    {{ $user->id }}
                  </td>
                  <td>
                    {{ $user->nama }}
                  </td>
                  <td>
                    @if(!$user->nim)
                      -
                    @else
                      {{ $user->nim }}
                    @endif
                  </td>
                  <td>
                    {{ $user->username }}
                  </td>
                  <td>
                    @if($user->id != 2)
                      <ul>
                        @foreach($user->ormawas as $item)
                        <li>
                          @switch($item->pivot->role)
                            @case('sekretaris_umum')
                              Sekretaris Umum di {{ $item->nama }}
                              @break
                            @case('sekretaris_proker')
                              Sekretaris Proker di {{ $item->nama }}
                              @break
                            @default
                              {{ ucfirst($item->pivot->role) }} di {{ $item->nama }}
                          @endswitch
                          
                        </li>
                        @endforeach
                      </ul>
                    @elseif($user->id == 2)
                      Wakil Direktur
                    @else 
                      -
                    @endif
                  </td>
                  <td>
                    {{-- EDIT --}}
                    <button type="button" class="btn btn-warning btn-sm edit-user-btn" data-toggle="modal" data-target="#editUserModal" data-id="{{ $user->id }}">Edit</button>
                    
                    {{-- RESET PASSWORD --}}
                    @if($user->id != 2)
                      <button type="button" class="btn btn-warning btn-sm reset-password-btn" data-toggle="modal" data-target="#resetPasswordModal" data-id="{{ $user->id }}">Ubah Password</button>

                      {{-- HAPUS --}}
                      <form action="{{ route('user.destroy', ['user' => $user->id]) }}" method="post" class="d-inline">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger btn-sm" id="btnHapus">Hapus</button>
                      </form>
                    @endif

                    {{-- Tambah menjadi pembina --}}
                    @if($user->ormawas()->where('role', 'pembina' )->count() > 0)
                      <br>
                      <br>
                      <button type="button" class="btn btn-warning btn-sm tambah-pembina-btn" data-toggle="modal" data-target="#tambahPembinaModal" data-id="{{ $user->id }}">Tambah Pembina</button>
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

@include('user.add-modal')
@include('user.edit-modal')
@include('user.reset-password-modal')
@include('user.tambah-pembina-modal')

<script>
  $(document).ready(function () {
    $('#tblUser').DataTable({
        order: [[0, 'desc']] // Angka 0 mengacu pada indeks kolom 'id', 'desc' untuk descending
    });
  });
</script>

<script>

  // EDIT USER
  $('.edit-user-btn').click(function() {
    var userId = $(this).data('id');
    var tambahFormAction = "{{ route('user.update', ['user' => 'userIdPlaceholder']) }}";

    tambahFormAction = tambahFormAction.replace('userIdPlaceholder', userId);
    $('#userForm').attr('action', tambahFormAction);

    $.ajax({
      url: '/user/' + userId,
      type: 'GET',
      success: function(response) {
        var user = response;

        $('#nama_update').val(user.nama);
        $('#username_update').val(user.username);
        $('#nim_update').val(user.nim);
        $('#role_update').val(user.role);

        // if role_update is wadir then class no-wadir is hidden
        if (user.username == 'wadir-polsub') {
          $('.no-wadir').addClass('d-none');
        } else {
          $('.no-wadir').removeClass('d-none');
        }

      },
      error: function(error) {
        console.log(error);
      }
    });

    $.ajax({
      url: '/user/getOrmawa/' + userId,
      type: 'GET',
      success: function(response) {
        var ormawa = response;

        $('#ormawa_update').val(ormawa.id);
      },
      error: function(error) {
        console.log(error);
      }
    });
  });

  // Tambah Pembina
  $('.tambah-pembina-btn').click(function() {
    var userId = $(this).data('id');
    var tambahPembinaFormAction = "{{ route('user.tambahPembina', ['id' => 'userIdPlaceholder']) }}";

    tambahPembinaFormAction = tambahPembinaFormAction.replace('userIdPlaceholder', userId);
    $('#tambahpembinaForm').attr('action', tambahPembinaFormAction);

    $('#userIdInput').val(userId);
  });

  // RESET PASSWORD
  $('.reset-password-btn').click(function() {
    var userId = $(this).data('id');
    var tambahFormAction = "{{ route('user.resetPassword', ['id' => 'userIdPlaceholder']) }}";

    tambahFormAction = tambahFormAction.replace('userIdPlaceholder', userId);
    $('#resetForm').attr('action', tambahFormAction);

    $.ajax({
      url: '/user/' + userId,
      type: 'GET',
      success: function(response) {
        var user = response;

        $('#username_reset').val(user.username);

      },
      error: function(error) {
        console.log(error);
      }
    });
  });

</script>

<script>

  // DELETE USER
  $(function(){
    $(document).on('click', '#btnHapus', function(e){
      e.preventDefault();
  
      Swal.fire({
        title: 'Apakah anda yakin ingin menghapus ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire(
            'Deleted!',
            'Data Berhasil Dihapus.',
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

    $('ul').find('li:contains("Pengguna")').addClass('active');

  }, 300);
</script>

@endsection