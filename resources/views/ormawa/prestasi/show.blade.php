@extends('../layouts.main')

@section('title')
    Si Ormawa - Prestasi
@endsection

@section('content')

{{-- HEADER --}}
<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">

      <div class="row align-items-center justify-content-between mx-1 mb-2">
        <div class="col-md-10">
          <h2 class="">Prestasi Ormawa {{ $ormawa->nama }}</h2>
        </div>
        <div class="col-md-2">
          <a href="/ormawa" class="btn btn-primary items-center"> 
            <i class="mdi mdi-keyboard-backspace"></i> Kembali
          </a>
        </div>
      </div>
      
      <div class="row mx-1 mb-2">
        <div class="col d-flex justify-content-between align-items-center">

          @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
          @endif
          
        </div>
        <div class="col d-flex justify-content-end align-items-center">
          @if(auth()->user()->role() == 'admin')
            <button type="button" class="btn btn-info prestasi-btn" data-toggle="modal" data-target="#prestasiModal" data-id="{{ $ormawa->id }}" data-nama="{{ $ormawa->nama }}">
              <i class="mdi mdi-file-image"></i>
              Tambah Prestasi
            </button>
          @endif
        </div>
      </div>

    </div>
  </div>
</div>

{{-- KONTEN --}}
<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">

      <div class="photo-gallery">
        <div class="container">
          <div class="row photos">

            @foreach($prestasiOrmawa as $item)
            <div class="col-sm-6 col-md-4 col-lg-3 item position-relative">
                <a href="{{ asset('storage/' . $item->sertifikat) }}" data-lightbox="photos">
                <img class="img-fluid object-fit-cover w-100 h-100" src="{{ asset('storage/' . $item->sertifikat) }}">
                </a>
                <h4 class="mt-2">{{ $item->nama }}</h4>
                @if(auth()->user()->role() == 'admin')
                  <form action="{{ route('prestasi-ormawa.destroy', ['prestasi_ormawa' => $item->id]) }}" method="post" class="position-absolute top-0 right-0">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger btn-sm" id="btnHapus">X</button>
                  </form>
                @endif
            </div>
            @endforeach

          </div>
        </div>
      </div>

    </div>
  </div>
</div>

@include('ormawa.prestasi.add-modal')

<script>
  $(document).ready(function() {

    $('.prestasi-btn').click(function() {
      var dataNama = $(this).data('nama');
      $('#prestasiModal').find('.modal-title').text('Tambah Prestasi ' + dataNama);

      var dataId = $(this).data('id');
      $('#ormawa_id_prestasi').val(dataId);
    });
  });

</script>
<script>
  
  setTimeout(function() {
    $('.nav-item.active').removeClass('active');
    
    $('ul').find('li:contains("Ormawa")').addClass('active');

  }, 500);
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
@endsection