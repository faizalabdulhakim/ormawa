@extends('layouts.main')

@section('title')
    Si Ormawa - Proposal
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
          <h2 class="">Proposal</h2>
        </div>

        <div class="row justify-content-end align-items-center mx-1">
          <div class="form-group">
            <label for="bulanFilter">Filter Bulan</label>
            <form method="get" action="{{ route('proposal.index') }}">
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
          <table class="table table-bordered table-hover table-striped" id="tblProposal">
            <thead>
              <tr>
                <th>
                  ID
                </th>
                <th>
                  Judul
                </th>
                <th>
                  Tenggat Waktu
                </th>
                <th>
                  Status
                </th>
                <th>
                  Sekretaris
                </th>
                <th>
                  Aksi
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach ($proposals as $proposal)
                <tr>
                  <td>
                    {{ $proposal->id }}
                  </td>
                  <td>
                    {{ $proposal->judul }} <br>
                  </td>

                  {{-- Menampilkan Deadline --}}
                  <td>
                    {{ \Carbon\Carbon::parse($proposal->proker->deadline_proposal)->translatedFormat('d F Y') }}

                    {{-- Menampilkan Berapa Hari Lagi --}}
                    @php
                      $now = \Carbon\Carbon::now();
                      $diff = $now->diffInDays($proposal->proker->deadline_proposal, false);
                    @endphp
                    <br>

                    @if($diff > 0)
                    <p class="text-danger" style="font-size: 12px;">{{ $diff }} hari lagi</p>
                    
                    @endif
                  </td>

                  <td>                    
                    @if($proposal->status == 'tanpa_isi')
                      <span class="badge badge-warning">Tanpa Isi</span>
                    @elseif($proposal->status == 'draft')
                      <span class="badge badge-warning">Draft</span>
                    @elseif($proposal->status == 'diajukan')
                      <span class="badge badge-primary">Diajukan</span>
                    @elseif($proposal->status == 'disetujui')
                      <span class="badge badge-success">Disetujui</span>
                    @elseif($proposal->status == 'ditolak')
                      <span class="badge badge-danger">Ditolak</span>
                    @endif

                    <br>
                    <br>

                    {{-- Menampilkan dilihat atau belum --}}
                    @if(auth()->user()->role() === 'sekretaris_proker')
                      @if($proposal->isViewed)
                        <span class="badge badge-success">Sudah Dilihat</span>
                      @else
                        <span class="badge badge-primary">Belum Dilihat</span>
                      @endif
                    @endif

                  </td>

                  <td>
                    {{ $proposal->user?->nama }}
                  </td>

                  <td>

                    {{-- SEKPRO BISA EDIT --}}
                    @if(auth()->user()->role() == 'sekretaris_proker')
                      @if($proposal->proker->deadline_proposal < $now  && ($proposal->status == 'draft' || $proposal->status == 'tanpa_isi'))
                        <button 
                        type="button" 
                        class="btn btn-warning btn-sm"
                        disabled
                        >Edit</button>
                      @else
                        <a href="{{ route('proposal.template', ['id' => $proposal->id]) }}" class="btn btn-warning btn-sm" >Edit</a>
                      @endif
                    @endif

                    {{-- SELAIN ANGGOTA BISA LIHAT --}}
                    @if(auth()->user()->role() != 'anggota')
                      @if($proposal->proker->deadline_proposal < $now  && $proposal->status == 'draft' || $proposal->status == 'tanpa_isi')
                        <button 
                        type="button" 
                        class="btn btn-info btn-sm"
                        disabled
                        >Lihat</button>
                      @else
                        <a href="{{ route('proposal.template', ['id' => $proposal->id]) }}" class="btn btn-info btn-sm" >Lihat</a>
                      @endif
                    @endif

                    {{-- ALL UNDUH --}}
                    @if($proposal->status == 'tanpa_isi')
                      <button 
                        type="button" 
                        class="btn btn-primary btn-sm"
                        disabled
                        >Unduh</button>
                    @else
                      <a href="{{ route('proposal.download', ['id' => $proposal->id]) }}" class="btn btn-primary btn-sm">Unduh</a>
                    @endif

                    {{-- Pembina Bisa Tindak dan Peringati --}}
                    @if(auth()->user()->role() == 'pembina')
                      <button 
                        type="button" 
                        class="btn btn-warning btn-sm tindakanBtn" 
                        id="tindakanBtn"
                        data-toggle="modal" data-target="#tindakanModal" 
                        data-id="{{ $proposal->id }}" 
                        data-judul="{{ $proposal->judul }}"
                        @if ($proposal->status != 'diajukan')
                          disabled
                        @endif
                        >Tindakan</button>

                      <button 
                        type="button" 
                        class="btn btn-warning btn-sm peringatanBtn" 
                        id="peringatanBtn"
                        data-toggle="modal" data-target="#peringatanModal" 
                        data-id="{{ $proposal->id }}" 
                        data-judul="{{ $proposal->judul }}"
                        >Beri Pengingat</button>
                        
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

@include('proposal.tindakan-modal')
@include('proposal.peringatan-modal')

<script>

  // NOT USED
  $('#proker').click(function() {
    $('#judul').val('Proposal ' + $('#proker option:selected').text());

    var proker_id = $('#proker option:selected').val();

    getProker(proker_id)
      .then(function(proker) {
        var ormawa_id = proker.ormawa_id;

        getOrmawa(ormawa_id)
          .then(function(ormawa) {
            var sekretaris_proker_id = ormawa.sekretaris_proker_id;

            getUser(sekretaris_proker_id)
              .then(function(user) {
                $('#sekretaris').val(user.nama);
                $('#sekretaris_id').val(user.id);
              })
              .catch(function(error) {
                console.error(error);
              });
          })
          .catch(function(error) {
            console.error(error);
          });
      })
      .catch(function(error) {
        console.error(error);
      });
  });

  // ENABLE ORMAWA WHEN SUBMIT
  $('#prokerForm').on('submit', function() {
    $('#ormawa_update').prop('disabled', false);
  });

  // Tindakan Modal
  $('.tindakanBtn').click(function() {
    var proposalId = $(this).data('id');
    var tambahFormAction = "{{ route('proposal.tindakan', ['id' => 'proposalIdPlaceholder']) }}";

    tambahFormAction = tambahFormAction.replace('proposalIdPlaceholder', proposalId);
    $('#tindakanForm').attr('action', tambahFormAction);

    $.ajax({
      url: '/proposal/' + proposalId,
        type: 'GET',
        success: function(response) {
          var proposal = response;
          
          $('#judul_feedback').val(proposal.judul);
          $('#proposal_id_tindakan').val(proposalId);
          $('#proker_id_tindakan').val(proposal.proker_id);
          $('#user_id_tindakan').val(proposal.user_id);

        },
        error: function(error) {
          console.log(error);
        }
    })
  });

  // Peringatan Modal
  $('.peringatanBtn').click(function() {
    var proposalId = $(this).data('id');
    var tambahFormAction = "{{ route('proposal.peringatan', ['id' => 'peringatanIdPlaceholder']) }}";

    tambahFormAction = tambahFormAction.replace('peringatanIdPlaceholder', proposalId);
    $('#peringatanForm').attr('action', tambahFormAction);

    $.ajax({
      url: '/proposal/' + proposalId,
        type: 'GET',
        success: function(response) {
          var proposal = response;
          
          $('#judul_peringatan').val(proposal.judul);
          $('#proposal_id_peringatan').val(proposalId);
          $('#proker_id_peringatan').val(proposal.proker_id);
          $('#user_id_peringatan').val(proposal.user_id);

        },
        error: function(error) {
          console.log(error);
        }
    })
  });

  // GET ORMAWA
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

  // GET USER
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

  // GET PROKER
  function getProker(id) {
    return new Promise(function(resolve, reject) {
      $.ajax({
        url: '/proker/' + id,
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
    $('#tblProposal').DataTable();
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
