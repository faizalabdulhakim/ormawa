@extends('layouts.main')

@section('title')
    Si Ormawa - Notifikasi
@endsection

<style>
  .table th {
    white-space: normal !important;
  }
</style>

@section('content')

{{-- HEADER --}}
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">

          <div class="row justify-content-between align-items-center mx-1 mb-2">
            <div>
              <h3>Notifikasi</h3>
              <p class="text-muted">Semua Notifikasi Akan Ditampilkan Disini.</p>
            </div>

            <a class="btn btn-primary items-center" href="/">
              Kembali <br> Ke Dashboard
            </a>
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

        </div>
      </div>
    </div>
  </div>

@if(auth()->user()->role() == "sekretaris_proker" || auth()->user()->id == 1)


  {{-- PERINGATAN --}}
  <div class="row">

    {{-- PERINGATAN PROPOSAL --}}
    <div class="col-lg-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">

          <p class="card-title">Pengingat Proposal</p>
          <ul class="icon-data-list d-inline">
            @if($peringatanProposals->count() > 0)
              @foreach ($peringatanProposals as $peringatan)
                <li>
                  <div class="d-flex">
                    <div>
                      <h4 class="text-primary mb-1">{{ $peringatan->proposal->judul }}</h4>
                      <p class="mb-0">{{ $peringatan->peringatan }}</p>
                      <small>
                        {{ $peringatan->created_at->translatedFormat('d F Y') }} | 
                        {{ $peringatan->created_at->translatedFormat('H:i') }} WIB
                      </small>
                    </div>
                  </div>
                </li>
              @endforeach
            @else
              <li>
                <div class="d-flex">
                  <div>
                    <h4 class="text-primary mb-1">Tidak Ada Pengingat</h4>
                  </div>
                </div>
              </li>
            @endif
          </ul>

        </div>
      </div>
    </div>

    {{-- PERINGATAN LPJ --}}
    <div class="col-lg-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">

          <p class="card-title">Pengingat LPJ</p>
          <ul class="icon-data-list d-inline">
            @if($peringatanLpjs->count() > 0)
              @foreach ($peringatanLpjs as $peringatan)
                <li>
                  <div class="d-flex">
                    <div>
                      <h4 class="text-primary mb-1">{{ $peringatan->lpj->judul }}</h4>
                      <p class="mb-0">{{ $peringatan->peringatan }}</p>
                      <small>
                        {{ $peringatan->created_at->translatedFormat('d F Y') }} | 
                        {{ $peringatan->created_at->translatedFormat('H:i') }} WIB
                      </small>
                    </div>
                  </div>
                </li>
              @endforeach
            @else
              <li>
                <div class="d-flex">
                  <div>
                    <h4 class="text-primary mb-1">Tidak Ada Pengingat</h4>
                  </div>
                </div>
              </li>
            @endif
          </ul>

        </div>
      </div>
    </div>

  </div>

  {{-- KOMENTAR --}}
  <div class="row">

    {{-- KOMENTAR PROPOSAL --}}
    <div class="col-lg-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">

          <p class="card-title">Komentar Proposal</p>
          <ul class="icon-data-list d-inline">
            @if($komentarProposals->count() > 0)
              @foreach ($komentarProposals as $komentar)
                <li>
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-success mb-1">{{ $komentar->proposal->judul }}</h4>
                      </div>
                      <p class="mb-0">Pembina memberi  {{ ucwords(str_replace('_', ' ', $komentar->bagian)) }}</p>
                      <small>
                        {{ $komentar->created_at->translatedFormat('d F Y') }} | 
                        {{ $komentar->created_at->translatedFormat('H:i') }} WIB
                      </small>
                    </div>

                    <div>
                      <form action="{{ route('komentar.destroy', $komentar->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="btnHapus" class="btn btn-danger btn-sm">
                          <i class="mdi mdi-close-box"></i>
                        </button>
                      </form>
                    </div>
                  </div>
                </li>
              @endforeach
            @else
              <li>
                <div class="d-flex">
                  <div>
                    <h4 class="text-success mb-1">Tidak Ada Komentar</h4>
                  </div>
                </div>
              </li>
            @endif
          </ul>

        </div>
      </div>
    </div>

    {{-- KOMENTAR LPJ --}}
    <div class="col-lg-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">

          <p class="card-title">Komentar LPJ</p>
          <ul class="icon-data-list d-inline">
            @if($komentarLpjs->count() > 0)
              @foreach ($komentarLpjs as $komentar)
                <li>
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-success mb-1">{{ $komentar->lpj->judul }}</h4>
                      </div>
                      <p class="mb-0">Pembina memberi  {{ ucwords(str_replace('_', ' ', $komentar->bagian)) }}</p>
                      <small>
                        {{ $komentar->created_at->translatedFormat('d F Y') }} | 
                        {{ $komentar->created_at->translatedFormat('H:i') }} WIB
                      </small>
                    </div>

                    <div>
                      <form action="{{ route('komentar.destroy', $komentar->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="btnHapus" class="btn btn-danger btn-sm">
                          <i class="mdi mdi-close-box"></i>
                        </button>
                      </form>
                    </div>
                  </div>
                </li>
              @endforeach
            @else
              <li>
                <div class="d-flex">
                  <div>
                    <h4 class="text-success mb-1">Tidak Ada Komentar</h4>
                  </div>
                </div>
              </li>
            @endif
          </ul>

        </div>
      </div>
    </div>

  </div>

  {{-- FEEDBACK --}}
  <div class="row">

    {{-- FEEDBACK PROPOSAL --}}
    <div class="col-lg-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">

          <p class="card-title">Umpan Balik Proposal</p>
          <ul class="icon-data-list d-inline">
            @if($feedbackProposals->count() > 0)
              @foreach ($feedbackProposals as $feedback)
                <li>
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <h4 class="text-warning mb-1">{{ $feedback->proposal->judul }}</h4>
                      <p class="mb-0">{{ $feedback->feedback }}</p>

                      <small>
                        {{ $feedback->created_at->translatedFormat('d F Y') }} | 
                        {{ $feedback->created_at->translatedFormat('H:i') }} WIB
                      </small>
                    </div>
                    <div>
                      @if($feedback->status == 'draft')
                        <span class="badge badge-warning">Draft</span>
                      @elseif($feedback->status == 'diajukan')
                        <span class="badge badge-primary">Diajukan</span>
                      @elseif($feedback->status == 'disetujui')
                        <span class="badge badge-success">Disetujui</span>
                      @elseif($feedback->status == 'ditolak')
                        <span class="badge badge-danger">Ditolak</span>
                      @endif
                      <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="btnHapus" class="btn btn-danger btn-sm">
                          <i class="mdi mdi-close-box"></i>
                        </button>
                      </form>
                    </div>
                  </div>
                </li>
              @endforeach
            @else
              <li>
                <div class="d-flex">
                  <div>
                    <h4 class="text-warning mb-1">Tidak Ada Umpan Balik</h4>
                  </div>
                </div>
              </li>
            @endif
          </ul>

        </div>
      </div>
    </div>

    {{-- FEEDBACK LPJ --}}
    <div class="col-lg-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">

          <p class="card-title">Umpan Balik LPJ</p>
          <ul class="icon-data-list d-inline">
            @if($feedbackLpjs->count() > 0)
              @foreach ($feedbackLpjs as $feedback)
                <li>
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <h4 class="text-warning mb-1">{{ $feedback->lpj->judul }}</h4>
                      <p class="mb-0">{{ $feedback->feedback }}</p>

                      <small>
                        {{ $feedback->created_at->translatedFormat('d F Y') }} | 
                        {{ $feedback->created_at->translatedFormat('H:i') }} WIB
                      </small>
                    </div>
                    <div>
                      @if($feedback->status == 'draft')
                        <span class="badge badge-warning">Draft</span>
                      @elseif($feedback->status == 'diajukan')
                        <span class="badge badge-primary">Diajukan</span>
                      @elseif($feedback->status == 'disetujui')
                        <span class="badge badge-success">Disetujui</span>
                      @elseif($feedback->status == 'ditolak')
                        <span class="badge badge-danger">Ditolak</span>
                      @endif
                      <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="btnHapus" class="btn btn-danger btn-sm">
                          <i class="mdi mdi-close-box"></i>
                        </button>
                      </form>
                    </div>
                  </div>
                </li>
              @endforeach
            @else
              <li>
                <div class="d-flex">
                  <div>
                    <h4 class="text-warning mb-1">Tidak Ada Umpan Balik</h4>
                  </div>
                </div>
              </li>
            @endif
          </ul>

        </div>
      </div>
    </div>
    

  </div>

@endif

@if(auth()->user()->role() == "pembina")

  <div class="row">

    {{-- KOMENTAR PROPOSAL --}}
    <div class="col-lg-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
  
          <p class="card-title">Notifikasi Perubahan Proposal</p>
          <ul class="icon-data-list d-inline">
            @if($komentarsProposalPembina->count() > 0)
              @foreach ($komentarsProposalPembina as $komentar)
                <li>
                  <div class="d-flex justify-content-between align-items-center">

                    <div>
                      <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-success mb-1">{{ $komentar->proposal->judul }} Telah Diubah</h4>
                      </div>
                      <small>
                        {{ $komentar->created_at->translatedFormat('d F Y') }} | 
                        {{ $komentar->created_at->translatedFormat('H:i') }} WIB
                      </small>
                    </div>

                    <div>
                      <form action="{{ route('komentar.destroy', $komentar->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="btnHapus" class="btn btn-danger btn-sm">
                          <i class="mdi mdi-close-box"></i>
                        </button>
                      </form>
                    </div>

                  </div>
                </li>
              @endforeach
            @else
              <li>
                <div class="d-flex">
                  <div>
                    <h4 class="text-success mb-1">Tidak Ada Perubahan</h4>
                  </div>
                </div>
              </li>
            @endif
          </ul>
  
        </div>
      </div>
    </div>

    {{-- KOMENTAR LPJ --}}
    <div class="col-lg-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
  
          <p class="card-title">Notifikasi Perubahan LPJ</p>
          <ul class="icon-data-list d-inline">
            @if($komentarsLpjPembina->count() > 0)
              @foreach ($komentarsLpjPembina as $komentar)
                <li>
                  <div class="d-flex">
                    <div>
                      <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-success mb-1">{{ $komentar->lpj->judul }} Telah Diubah</h4>
                        <form action="{{ route('komentar.destroy', $komentar->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" id="btnHapus" class="btn btn-danger btn-sm">
                            <i class="mdi mdi-close-box"></i>
                          </button>
                        </form>
                      </div>
                      <small>
                        {{ $komentar->created_at->translatedFormat('d F Y') }} | 
                        {{ $komentar->created_at->translatedFormat('H:i') }} WIB
                      </small>
                    </div>
                  </div>
                </li>
              @endforeach
            @else
              <li>
                <div class="d-flex">
                  <div>
                    <h4 class="text-success mb-1">Tidak Ada Perubahan</h4>
                  </div>
                </div>
              </li>
            @endif
          </ul>
  
        </div>
      </div>
    </div>

  </div>

@endif

{{-- PROKER COMING SOON --}}
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <p class="card-title mb-0">Program Kerja yang akan datang !</p>
        <p class="text-muted mb-2">Dalam 30 Hari Terakhir.</p>

        <div class="table-responsive">
          <table class="table table-striped table-borderless">
            <thead>
              <tr>
                <th>Proker</th>
                <th>Tanggal Pelaksanaan</th>
                <th>Selisih Hari</th>
              </tr>  
            </thead>
            <tbody>
              @if($prokersComingSoon)
                @foreach ($prokersComingSoon as $proker)
                  <tr>
                    <td>
                      {{ $proker->nama }}
                    </td>
                    <td class="font-weight-bold">
                      {{ $proker->tanggal_pelaksanaan }}
                    </td>
                    <td class="font-weight-medium">
                      @if($proker->selisih_hari < 0)
                        <span class="badge badge-danger">Terlewat</span>
                      @elseif($proker->selisih_hari == 0)
                        <span class="badge badge-info">Hari ini</span>
                      @elseif($proker->selisih_hari > 0)
                        <span class="badge badge-success">{{ $proker->selisih_hari}} Hari yang akan datang!</span>
                      @endif
                    </td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="3" class="text-center">
                    <h4 class="text-primary">Tidak ada program kerja yang akan datang!</h4>
                  </td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

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
@endsection
