@extends('layouts.main')

@section('title')
    Si Ormawa - Kelola Ormawa
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
          <h2 class="">Profil Organisasi Kemahasiswaan</h2>

          @if(auth()->user()->id == 1)
            <button class="btn btn-primary items-center" data-toggle="modal" data-target="#tambahOrmawaModal">
              <i class="mdi mdi-account-plus"></i>
              Tambah Ormawa
            </button>
          @endif
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

        @if(auth()->user()->id != 1)
        <div class="form-group row justify-content-end">
          <label for="ormawa" class="col-sm-1 col-form-label">Ormawa</label>
          <div class="col-sm-3">
            <form method="post" action="{{ route('ormawa.gantiOrmawa') }}">
            @csrf
            @method('patch')
            @if(auth()->user()->ormawas()->count() != 0 && auth()->user()->ormawas()->where('status', 'aktif')->count() != 0)
              <select class="form-control" id="gantiOrmawa" name="ormawa_id">
                @foreach (auth()->user()->ormawas()->where('status', 'aktif')->get() as $item)
                  <option value="{{ $item->id }}" @if($item->id === $selected_ormawa_id) selected @endif>
                    {{ $item->nama }} - {{ $item->angkatan }}
                  </option>
                @endforeach
              </select>
            <button type="submit" id="submitGanti" style="display: none;">Filter</button>
            </form>
            @else
              <select class="form-control" id="ormawa" name="ormawa_id">
                <option value="">Belum Terdaftar di Ormawa</option>
              </select>
            @endif
          </div>
        </div>
        @endif

        <div class="table-responsive pt-3">
          <table class="table table-bordered table-hover table-striped" id="tblOrmawa">
            <thead>
              <tr>
                <th>
                  ID
                </th>
                <th>
                  Logo
                </th>
                <th>
                  Nama
                </th>
                <th>
                  Angkatan
                </th>
                <th>
                  Jenis
                </th>
                <th>
                  Pengurus
                </th>
                <th>
                  Deskripsi
                </th>
                <th>
                  Aksi
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach ($ormawas as $ormawa)
                <tr>
                  <td>
                    {{ $ormawa->id }}
                  </td>
                  <td>
                    <img src="{{ asset('storage/' . $ormawa->logo) }}" alt="{{ $ormawa->nama }}" class="rounded-0 h-100">
                  </td>
                  <td>
                    {{ $ormawa->nama }}
                  </td>
                  <td>
                    {{ $ormawa->angkatan }}
                  </td>
                  <td>
                    {{ $ormawa->jenis }}
                  </td>
                  <td>
                    <ul>
                      @if ($ormawa->ketua)
                        <li>Ketua : {{ $ormawa->ketua->nama }}</li>
                      @endif
                      @if ($ormawa->sekretarisUmum)
                        <li>Sekretaris Umum : {{ $ormawa->sekretarisUmum->nama }}</li>
                      @endif
                      @if ($ormawa->pembina)
                        <li>Pembina : {{ $ormawa->pembina->nama }}</li>
                      @endif
                      @if (!$ormawa->ketua && !$ormawa->sekretarisUmum && !$ormawa->sekretarisProker && !$ormawa->pembina)
                        <p>Tidak ada pengurus</p>
                      @endif
                    </ul>
                  </td>
                  <td>
                    <button type="button" class="btn btn-info lihat-deskripsi-btn" data-toggle="modal" data-target="#deskripsiModal" data-id="{{ $ormawa->id }}" >
                      Lihat Deskripsi
                    </button>
                  </td>
                  <td>

                    @if(auth()->user()->id == 1)
                      <div class="row">
                        <div class="col">
                          <button type="button" class="btn btn-warning btn-sm edit-ormawa-btn" data-toggle="modal" data-target="#editOrmawaModal" data-id="{{ $ormawa->id }}">Edit</button>
      
                          <form action="{{ route('ormawa.destroy', ['ormawa' => $ormawa->id]) }}" method="post" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm" id="btnHapus">Hapus</button>
                          </form>
                        </div>
                      </div>
                    @endif

                    <div class="row mt-2">
                      <div class="col">

                        @if(auth()->user()->role() == 'sekretaris_umum')
                          @if (auth()->user()->ormawa->id != $ormawa->id)
                            <button class="btn btn-warning btn-sm" disabled>
                              LPJ Akhir
                            </button>
                          @else
                            <a href="{{ route('ormawa.lpj', ['id' => $ormawa->id]) }}" class="btn btn-warning btn-sm">
                              LPJ Akhir
                            </a>
                          @endif
                        @endif
    
                        @if(auth()->user()->role() == 'anggota')

                        @else
                        @if ($ormawa->cover == null)
                          <button class="btn btn-primary btn-sm" type="button" disabled>Unduh LPJ</button>
                        @else
                          <a href="{{ route('ormawa.download.lpj', ['id' => $ormawa->id]) }}" class="btn btn-primary btn-sm">Unduh LPJ</a>
                        @endif
                        @endif
                      </div>
                    </div>

                    @if(auth()->user()->role() == 'anggota')
                      <div class="row">
                        <div class="col">
                          <a href="{{ route('galeri-ormawa.show', ['galeri_ormawa' => $ormawa]) }}" class="btn btn-info btn-sm">
                            @if(auth()->user()->id == 1)
                              Galeri
                            @else
                              Lihat Galeri
                            @endif
                          </a>
      
                          <a href="{{ route('prestasi-ormawa.show', ['prestasi_ormawa' => $ormawa]) }}" class="btn btn-info btn-sm">
                            @if(auth()->user()->id == 1)
                              Prestasi
                            @else
                              Lihat Prestasi
                            @endif
                          </a>
                        </div>
                      </div>
                    @else
                      <div class="row mt-2">
                        <div class="col">
                          <a href="{{ route('galeri-ormawa.show', ['galeri_ormawa' => $ormawa]) }}" class="btn btn-info btn-sm">
                            @if(auth()->user()->id == 1)
                              Galeri
                            @else
                              Lihat Galeri
                            @endif
                          </a>
      
                          <a href="{{ route('prestasi-ormawa.show', ['prestasi_ormawa' => $ormawa]) }}" class="btn btn-info btn-sm">
                            @if(auth()->user()->id == 1)
                              Prestasi
                            @else
                              Lihat Prestasi
                            @endif
                          </a>
                        </div>
                      </div>
                    @endif

                    {{-- DAFTAR ORMAWA --}}
                    @if(auth()->user()->id != '1' && auth()->user()->role() != 'pembina')
                    <div class="row mt-2">
                      <div class="col">

                        @php
                            $user = auth()->user();
                            $isRegistered = $user->ormawas->contains('id', $ormawa->id);
                            $status = $ormawaUsers->where('user_id', $user->id)->where('ormawa_id', $ormawa->id)->first();
                        @endphp

                        @if($isRegistered && $status?->status == 'pending')
                            <button class="btn btn-info btn-sm" disabled>
                                Menunggu Konfirmasi
                            </button>
                        @elseif($isRegistered && $status?->status == 'aktif')
                            <button class="btn btn-info btn-sm" disabled>
                                Sudah Terdaftar
                            </button>
                        @else
                            <a href="{{ route('ormawa.daftar', ['ormawa_id' => $ormawa->id, 'user_id' => $user->id]) }}" class="btn btn-info btn-sm">
                                Daftar
                            </a>
                        @endif

                      </div>
                    </div>
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

<div class="modal fade" id="deskripsiModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="labelDeskripsi">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="bodyDeskripsi">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

@include('ormawa.add-modal')
@include('ormawa.edit-modal')

<script>
  $(document).ready(function () {
    $('#tblOrmawa').DataTable({
        order: [[0, 'desc']] // Angka 0 mengacu pada indeks kolom 'id', 'desc' untuk descending
    });
  });
</script>

<script>
  $("#datepicker").datepicker({
    format: "yyyy",
    viewMode: "years", 
    minViewMode: "years"
  });

  $("#datepicker2").datepicker({
    format: "yyyy",
    viewMode: "years", 
    minViewMode: "years"
  });

  $('.edit-ormawa-btn').click(function() {
    var ormawaId = $(this).data('id');
    var tambahFormAction = "{{ route('ormawa.update', ['ormawa' => 'ormawaIdPlaceholder']) }}";

    tambahFormAction = tambahFormAction.replace('ormawaIdPlaceholder', ormawaId);
    $('#ormawaForm').attr('action', tambahFormAction);

    $.ajax({
      url: '/ormawa/' + ormawaId,
      type: 'GET',
      success: function(response) {
        var ormawa = response;

        $('#nama_update').val(ormawa.nama);
        $('#datepicker2').val(ormawa.angkatan);
        $('#deskripsi_update').val(ormawa.deskripsi);
        $('#old_logo_update').val(ormawa.logo);

        //if jurusan is not null then set the value of jurusan
        if(ormawa.jurusan != null) {
          $('#jurusan_update').val(ormawa.jurusan);
          $('#form-jurusan-update').show();
        }else if (ormawa.jurusan == null){
          $('#jurusan_update').val('');
          $('#form-jurusan-update').hide();
        }

      },
      error: function(error) {
        console.log(error);
      }
    });
  });

  $('.lihat-deskripsi-btn').click(function() {
    var ormawaId = $(this).data('id');

    console.log(ormawaId);

    $.ajax({
      url: '/ormawa/' + ormawaId,
      type: 'GET',
      success: function(response) {
        var ormawa = response;

        $('#labelDeskripsi').text(`Deskripsi ${ormawa.nama}`);
        $('#bodyDeskripsi').text(ormawa.deskripsi);
      },
      error: function(error) {
        console.log(error);
      }
    });
  });
</script>

<script type="text/javascript">
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

{{-- FILTER BULAN --}}
<script>
  const selectElement = document.getElementById('gantiOrmawa');
  const submitButton = document.getElementById('submitGanti');

  selectElement.addEventListener('change', function() {
    submitButton.click();
  });
</script>

@endsection
