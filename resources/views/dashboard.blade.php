@extends('layouts.main')

@section('title')
    Si Ormawa - Dashboard
@endsection

<style>
  .table td {
    white-space: normal !important;
  }
</style>

@section('content')

<div class="row">
  
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h2>Selamat Datang, {{ auth()->user()->nama }}</h2>
        <p class="text-muted">Selamat Datang di Sistem Informasi untuk Kegiatan Organisasi Kemahasiswaan (Ormawa) Politeknik Negeri Subang.</p>

        @if(auth()->user()->role() != 'anggota')

        {{-- INFO DASHBOARD --}}
          <div class="row">
            <div class="col-md-12 grid-margin transparent p-4">
              <div class="row">
                @if(auth()->user()->id == 1)
                  <div class="col-md-3 mb-4 stretch-card transparent">
                    <div class="card card-tale">
                      <div class="card-body">
                        <p class="mb-4">Pengguna</p>
                        <p class="fs-30 mb-2">{{ $totalUser }}</p>
                      </div>
                    </div>
                  </div>
                @endif
                @if(auth()->user()->role() != 'sekretaris_proker' && auth()->user()->role() != 'anggota')
                  <div class="col-md-3 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                      <div class="card-body">
                        <p class="mb-4">Ormawa</p>
                        <p class="fs-30 mb-2">{{ $totalOrmawa }}</p>
                      </div>
                    </div>
                  </div>
                @endif
                <div class="col-md-3 mb-4 stretch-card transparent">
                  <div class="card card-light-blue">
                    <div class="card-body">
                      <p class="mb-4">Proposal</p>
                      <p class="fs-30 mb-2">{{ $totalProposal }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 mb-4 stretch-card transparent">
                  <div class="card card-light-danger">
                    <div class="card-body">
                      <p class="mb-4">Laporan Pertanggungjawaban</p>
                      <p class="fs-30 mb-2">{{ $totalLPJ }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          {{-- GRAPH --}}
          @if(auth()->user()->role() != 'anggota' && (auth()->user()->role() || auth()->user()->id == 1))
          <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Statistik Proker</h4>
                  <canvas id="lineChartProker"></canvas>
                </div>
              </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Statistik Proposal</h4>
                  <canvas id="lineChartProposal"></canvas>
                </div>
              </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Statistik LPJ</h4>
                  <canvas id="lineChartLpj"></canvas>
                </div>
              </div>
            </div>
          </div>
          @endif

        @endif
      </div>
    </div>
  </div>

  @if(auth()->user()->role() == 'sekretaris_proker')

    {{-- PROPOSAL --}}
    @if($proposalsComingSoon->count() > 0)
      <div class="col-lg-6 grid-margin strech-card">
        <div class="card">
          <div class="card-body">
            <h2 class="card-title mb-1 mt-3">Kamu punya Proposal yang belum dibuat !</h2>
            <h5>Harap Segara Kerjakan</h5>
            @if($proposalsComingSoon->count() > 0)
              <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h3>Proposal</h3>
                      <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                          <thead>
                            <tr>
                              <th>Nama</th>
                              <th>Tenggat Proposal</th>
                            </tr>  
                          </thead>
                          <tbody>
                            @if($proposalsComingSoon->count() > 0)
                              @foreach ($proposalsComingSoon as $proposal)
                                <tr>
                                  <td>{{ $proposal->judul }}</td>
                                  <td class="font-weight-bold text-danger">
                                    {{ \Carbon\Carbon::parse($proposal->proker->deadline_proposal)->translatedFormat('d F Y') }}
                                    <br>
                                    @php
                                      $now = \Carbon\Carbon::now();
                                      $diff = $now->diffInDays($proposal->proker->deadline_proposal, false);
                                      $diff = $diff + 1;
                                    @endphp
                                    @if($diff > 0)
                                      <p class="text-danger" style="font-size: 12px;">{{ $diff }} hari lagi</p>
                                    @else
                                      <p class="text-danger" style="font-size: 12px;">Hari ini</p>
                                    @endif
                                  </td>
                                </tr>    
                              @endforeach
                            @else
                              <tr>
                                <td colspan="3" class="text-center">Tidak ada data</td>
                              </tr>
                            @endif
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endif

          </div>
        </div>
      </div>
    @endif

    {{-- LPJ --}}
    @if($lpjsComingSoon->count() > 0)
      <div class="col-lg-6 grid-margin strech-card">
        <div class="card">
          <div class="card-body">
            <h2 class="card-title mb-1 mt-3">Kamu punya LPJ yang belum dibuat !</h2>
            <h5>Harap Segara Kerjakan</h5>
            @if($lpjsComingSoon->count() > 0)
              <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h3>LPJ</h3>
                      <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                          <thead>
                            <tr>
                              <th>Nama</th>
                              <th>Tenggat LPJ</th>
                            </tr>  
                          </thead>
                          <tbody>
                            @if($lpjsComingSoon->count() > 0)
                              @foreach ($lpjsComingSoon as $lpj)
                                <tr>
                                  <td>{{ $lpj->judul }}</td>
                                  <td class="font-weight-bold text-danger">
                                    {{ \Carbon\Carbon::parse($lpj->proker->deadline_lpj)->translatedFormat('d F Y') }}
                                    <br>
                                    @php
                                      $now = \Carbon\Carbon::now();
                                      $diff = $now->diffInDays($lpj->proker->deadline_lpj, false);
                                      $diff = $diff + 1;
                                    @endphp
                                    @if($diff > 0)
                                      <p class="text-danger" style="font-size: 12px;">{{ $diff }} hari lagi</p>
                                    @else
                                      <p class="text-danger" style="font-size: 12px;">Hari ini</p>
                                    @endif
                                  </td>
                                </tr>    
                              @endforeach
                            @else
                              <tr>
                                <td colspan="3" class="text-center">Tidak ada data</td>
                              </tr>
                            @endif
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endif

          </div>
        </div>
      </div>
    @endif

  @endif

</div>

<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h2 class="card-title mb-1 mt-3">Linimasa Program Kerja</h2>
        <div id="calendar" class="overflow-hidden">
        </div>
      </div>
    </div>
  </div>
</div>

{{-- MODAL --}}
<div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog mt-4" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Keterangan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col">

            <div class="form-group row">
              <label for="nama" class="col-sm-3 col-form-label">Nama</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="nama" id="nama" readonly>
              </div>
            </div>
            
            <div class="form-group row">
              <label for="tanggal_pelaksanaan" class="col-sm-3 col-form-label">Tanggal Pelaksanaan</label>
              <div class="col-sm-9">
                <input type="text" name="tanggal_pelaksanaan" class="form-control" id="tanggal_pelaksanaan" readonly/>
              </div>
            </div>

            <div class="form-group row">
              <label for="deadline_proposal" class="col-sm-3 col-form-label">Tenggat Waktu Proposal</label>
              <div class="col-sm-9">
                <input type="text" name="deadline_proposal" class="form-control" id="deadline_proposal" readonly/>
              </div>
            </div>

            <div class="form-group row">
              <label for="deadline_lpj" class="col-sm-3 col-form-label">Tenggat Waktu LPJ</label>
              <div class="col-sm-9">
                <input type="text" name="deadline_lpj" class="form-control" id="deadline_lpj" readonly/>
              </div>
            </div>            
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>

<script>

  function formatDateToCustom(dateStr) {
    return moment(dateStr).locale('id').format('D MMMM YYYY');
  }

    let prokers = {!! json_encode($prokers->toArray()) !!};

    prokers = prokers.map(function(proker) {
      return {
        title: proker.nama,
        start: proker.tanggal_pelaksanaan,
        end: proker.tanggal_pelaksanaan,
        url: proker.id,
      }
    });
    

    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 550,
        events: prokers,
        locale: 'id',
        buttonText: {
          today: 'Hari ini'
        },
        eventClick: function(info) {
          info.jsEvent.preventDefault();

          $.ajax({
            url: '/proker/' + info.event.url,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
              $('#nama').val(data.nama);
              $('#tanggal_pelaksanaan').val(formatDateToCustom(data.tanggal_pelaksanaan));
              $('#deadline_proposal').val(formatDateToCustom(data.deadline_proposal));
              $('#deadline_lpj').val(formatDateToCustom(data.deadline_lpj));
            },
          });

          $('#detailModal').modal('show');
        }
      });
      calendar.render();
    });

</script>

<script>
  $(function() {
    /* ChartJS
    * -------
    * Data and config for chartjs
    */
    'use strict';

    let totalProkers = {!! json_encode($totalProkers) !!};
    let totalProkersDone = {!! json_encode($totalProkersDone) !!};
    let totalProkersUndone = {!! json_encode($totalProkersUndone) !!};

    var dataProker = {
      labels: ["Total Proker", "Total Proker Terlaksana", "Proker Belum Terlaksana"],
      datasets: [{
        label: 'Proker',
        data: [totalProkers, totalProkersDone, totalProkersUndone],
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
        ],
        borderColor: [
          'rgba(255,99,132,1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
        ],
        borderWidth: 1,
        fill: false
      }]
    }

    let totalProposal = {!! json_encode($totalProposal) !!};
    let totalProposalsConfirm = {!! json_encode($totalProposalsConfirm) !!};
    let totalProposalsUnconfirm = {!! json_encode($totalProposalsUnconfirm) !!};
    let totalProposalsOngoing = {!! json_encode($totalProposalsOngoing) !!};   
  

    var dataProposal = {
      labels: ["Total Proposal", "Proposal Disetujui", "Proposal Ditolak", "Proposal Dalam Pengerjaan"],
      datasets: [{
        label: 'Proposal',
        data: [totalProposal, totalProposalsConfirm, totalProposalsUnconfirm, totalProposalsOngoing],
        backgroundColor: [
          'rgba(39, 93, 245, 0.2)',
          'rgba(39, 245, 217, 0.2)',
          'rgba(39, 245, 54, 0.2)',
          'rgba(245, 195, 39, 0.2)',
        ],
        borderColor: [
          'rgba(39, 93, 245, 1)',
          'rgba(39, 245, 217, 1)',
          'rgba(39, 245, 54, 1)',
          'rgba(245, 195, 39, 1)',
        ],
        borderWidth: 1,
        fill: false
      }]
    }

    let totalLpj = {!! json_encode($totalLPJ) !!};
    let totalLpjsConfirm = {!! json_encode($totalLpjsConfirm) !!};
    let totalLpjsUnconfirm = {!! json_encode($totalLpjsUnconfirm) !!};
    let totalLpjsOngoing = {!! json_encode($totalLpjsOngoing) !!};   
  
    var dataLpj = {
      labels: ["Total LPJ", "LPJ Disetujui", "LPJ Ditolak", "LPJ Dalam Pengerjaan"],
      datasets: [{
        label: 'LPJ',
        data: [totalLpj, totalLpjsConfirm, totalLpjsUnconfirm, totalLpjsOngoing],
        backgroundColor: [
          'rgba(245, 39, 89, 0.2)',
          'rgba(245, 39, 226, 0.2)',
          'rgba(92, 39, 245, 0.2)',
          'rgba(39, 136, 245, 0.2)',
        ],
        borderColor: [
          'rgba(245, 39, 89, 1)',
          'rgba(245, 39, 226, 1)',
          'rgba(92, 39, 245, 1)', 
          'rgba(39, 136, 245, 1)',
        ],
        borderWidth: 1,
        fill: false
      }]
    }

    var options = {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            stepSize: 1,
          }
        }],
        xAxes: [{
          ticks: {
            fontSize: 9,
          }
        }]
      },
      legend: {
        display: false
      },
      elements: {
        point: {
          radius: 0
        }
      }

    };

    // Get context with jQuery - using jQuery's .get() method.
    if ($("#lineChartProker").length) {
      var lineChartCanvasProker = $("#lineChartProker").get(0).getContext("2d");
      var lineChartProker = new Chart(lineChartCanvasProker, {
        type: 'bar',
        data: dataProker,
        options: options
      });
    }

    if ($("#lineChartProposal").length) {
      let lineChartCanvasProposal = $("#lineChartProposal").get(0).getContext("2d");
      let lineChartProposal = new Chart(lineChartCanvasProposal, {
        type: 'bar',
        data: dataProposal,
        options: options
      });
    }

    if ($("#lineChartLpj").length) {
      let lineChartCanvasLpj = $("#lineChartLpj").get(0).getContext("2d");
      let lineChartLpj = new Chart(lineChartCanvasLpj, {
        type: 'bar',
        data: dataLpj,
        options: options
      });
    }

  });
</script>
@endsection