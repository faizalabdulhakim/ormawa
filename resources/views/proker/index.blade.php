@extends('layouts.main')

@section('title')
    Si Ormawa - Proker
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
          <h2 class="">Program Kerja</h2>

          @if(auth()->user()->role() == 'sekretaris_umum')
            <button class="btn btn-primary items-center" data-toggle="modal" data-target="#tambahProkerModal" id="btnTambahProker">
              <i class="mdi mdi-account-plus"></i>
              Tambah Program Kerja
            </button>
          @endif
        </div>

        <div class="row justify-content-end align-items-center mx-1">
          <div class="form-group">
            <label for="bulanFilter">Filter Bulan</label>
            <form method="get" action="{{ route('proker.index') }}">
              @csrf
              <select class="form-control form-control-sm" id="bulanFilter" name="bulanFilter">
                <option value="" selected>--Pilih Bulan--</option>
                <option>Semua Bulan</option>
                @foreach ($bulanOptions as $bulan)
                  <option value="{{ $bulan }}" @if($selectedBulan == $bulan) selected @endif >{{ $bulan }}</option>
                @endforeach
              </select>
               <button type="submit" id="submitFilter" style="display: none;">Filter</button>
            </form>
          </div>
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
          <table class="table table-bordered table-hover table-striped" id="tblProker">
            <thead>
              <tr>
                <th>
                  ID
                </th>
                <th>
                  Nama
                </th>
                <th>
                  Tanggal Pelaksanaan
                </th>
                <th>
                  Tenggat Waktu Proposal
                </th>
                <th>
                  Tenggat Waktu LPJ
                </th>
                <th>
                  Ormawa
                </th>
                <th>
                  Sekretaris Program Kerja
                </th>
                @if(auth()->user()->role() != 'sekretaris_umum')

                @else
                <th>
                  Aksi
                </th>
                @endif
              </tr>
            </thead>
            <tbody>
              @foreach ($prokers as $proker)
                <tr>
                  <td>
                    {{ $proker->id }}
                  </td>
                  <td>
                    {{ $proker->nama }}
                  </td>
                  <td>
                    {{ \Carbon\Carbon::parse($proker->tanggal_pelaksanaan)->translatedFormat('d F Y') }}
                  </td>
                  <td>
                    {{ \Carbon\Carbon::parse($proker->deadline_proposal)->translatedFormat('d F Y') }}
                  </td>
                  <td>
                    {{ \Carbon\Carbon::parse($proker->deadline_lpj)->translatedFormat('d F Y') }}
                  </td>
                  <td>
                    {{ $proker->ormawa?->nama }} - {{ $proker->ormawa?->angkatan }}
                  </td>
                  <td>
                    {{ $proker->user?->nama }}
                  </td>
                  @if(auth()->user()->role() != 'sekretaris_umum')

                  @else
                  <td>
                    <button type="button" class="btn btn-warning btn-sm edit-proker-btn" data-toggle="modal" data-target="#editProkerModal" data-id="{{ $proker->id }}">Edit</button>

                    @if(auth()->user()->role() == 'admin')

                    @else
                      <form action="{{ route('proker.destroy', ['proker' => $proker->id]) }}" method="post" class="d-inline">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger btn-sm" id="btnHapus">Hapus</button>
                      </form>
                    @endif

                  </td>
                  @endif
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        
      </div>
    </div>
  </div>
</div>

@if(auth()->user()->role() == 'sekretaris_umum')
  @include('proker.add-modal')
  @include('proker.edit-modal')
@endif


<script>
  $("#tanggal_pelaksanaan").datepicker({
  });

  $("#deadline_proposal").datepicker({
  });

  $("#deadline_lpj").datepicker({
  });

  $("#tanggal_pelaksanaan_update").datepicker({
  });

  $("#deadline_proposal_update").datepicker({
  });

  $("#deadline_lpj_update").datepicker({
  });

  $(document).ready(function() {

    $('.edit-proker-btn').click(function() {
      var prokerId = $(this).data('id');
      var tambahFormAction = "{{ route('proker.update', ['proker' => 'prokerIdPlaceholder']) }}";

      tambahFormAction = tambahFormAction.replace('prokerIdPlaceholder', prokerId);
      $('#prokerForm').attr('action', tambahFormAction);

      $.ajax({
        url: '/proker/' + prokerId,
        type: 'GET',
        success: function(response) {
          var proker = response;

          $('#nama_update').val(proker.nama);

          var tanggal_pelaksanaan = proker.tanggal_pelaksanaan;
          var parts = tanggal_pelaksanaan.split("-");
          var tanggalBaru = parts[1] + "/" + parts[2] + "/" + parts[0];
          $('#tanggal_pelaksanaan_update').val(tanggalBaru);

          var deadline_proposal = proker.deadline_proposal;
          var parts = deadline_proposal.split("-");
          var tanggalBaru = parts[1] + "/" + parts[2] + "/" + parts[0];
          $('#deadline_proposal_update').val(tanggalBaru);

          var deadline_lpj = proker.deadline_lpj;
          var parts = deadline_lpj.split("-");
          var tanggalBaru = parts[1] + "/" + parts[2] + "/" + parts[0];
          $('#deadline_lpj_update').val(tanggalBaru);

          getUser(proker.user_id)
            .then(function(sekretaris) {

              var selectElement = document.getElementById("sekpro_update");

              for (var i = 0; i < selectElement.options.length; i++) {
                var option = selectElement.options[i];

                if (option.value == sekretaris.id) {
                  option.selected = true;
                  break;
                }
              }

            })
            .catch(function(error) {
              console.error(error);
            });

        },
        error: function(error) {
          console.log(error);
        }
      });
    });

  });

  $('#tanggal_pelaksanaan').change(function() {
    var tanggal_pelaksanaan = $(this).val();

    // DEADLINE PROPOSAL
    var deadline_proposal = new Date(tanggal_pelaksanaan);
    deadline_proposal.setDate(deadline_proposal.getDate() - 30);

    var month = deadline_proposal.getMonth() + 1;
    var day = deadline_proposal.getDate();
    var year = deadline_proposal.getFullYear();

    var formattedDate = ('0' + month).slice(-2) + '/' + ('0' + day).slice(-2) + '/' + year;

    $('#deadline_proposal').val(formattedDate);

    // DEADLINE LPJ
    var deadline_lpj = new Date(tanggal_pelaksanaan);
    deadline_lpj.setDate(deadline_lpj.getDate() + 10);

    var month = deadline_lpj.getMonth() + 1;
    var day = deadline_lpj.getDate();
    var year = deadline_lpj.getFullYear();

    var formattedDate = ('0' + month).slice(-2) + '/' + ('0' + day).slice(-2) + '/' + year;

    $('#deadline_lpj').val(formattedDate);

  });

  $('#tanggal_pelaksanaan_update').change(function() {
    var tanggal_pelaksanaan_update = $(this).val();

    // DEADLINE PROPOSAL
    var deadline_proposal_update = new Date(tanggal_pelaksanaan_update);
    deadline_proposal_update.setDate(deadline_proposal_update.getDate() - 30);

    var month = deadline_proposal_update.getMonth() + 1;
    var day = deadline_proposal_update.getDate();
    var year = deadline_proposal_update.getFullYear();

    var formattedDate = ('0' + month).slice(-2) + '/' + ('0' + day).slice(-2) + '/' + year;

    $('#deadline_proposal_update').val(formattedDate);

    // DEADLINE LPJ
    var deadline_lpj_update = new Date(tanggal_pelaksanaan_update);
    deadline_lpj_update.setDate(deadline_lpj_update.getDate() + 10);

    var month = deadline_lpj_update.getMonth() + 1;
    var day = deadline_lpj_update.getDate();
    var year = deadline_lpj_update.getFullYear();

    var formattedDate = ('0' + month).slice(-2) + '/' + ('0' + day).slice(-2) + '/' + year;

    $('#deadline_lpj_update').val(formattedDate);

  });

  $('#prokerForm').on('submit', function() {
    $('#ormawa_update').prop('disabled', false);
  });

  function getOrmawa(id) {
    return new Promise(function(resolve, reject) {
      $.ajax({
        url: '/ormawa/' + id,
        type: 'GET',
        success: function(response) {
          resolve(response);
        },
        error: function(error) {
          reject(error);
        }
      });
    });
  }

  function getUser(id) {
    return new Promise(function(resolve, reject) {
      $.ajax({
        url: '/user/' + id,
        type: 'GET',
        success: function(response) {
          resolve(response);
        },
        error: function(error) {
          reject(error);
        }
      });
    });
  }

</script>

<script>
  $(document).ready(function () {
    $('#tblProker').DataTable();
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
  const selectElement = document.getElementById('bulanFilter');
  const submitButton = document.getElementById('submitFilter');

  selectElement.addEventListener('change', function() {
    submitButton.click();
  });
</script>

@endsection
