<div id="prestasiModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog mt-4" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="forms-sample" method="POST" action="{{ route('prestasi-ormawa.store') }}" enctype="multipart/form-data">
      @csrf
        <div class="modal-body">

          <div class="form-group">
            <label for="nama">Nama Prestasi</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Prestasi" required value="{{ old('nama') }}">
            @error('nama')
              <p class="text-danger">{{ $message }}</p>
            @enderror
          </div>

          <div class="form-group">
            <label for="sertifikat">Upload Sertifikat</label>
            <input type="file" name="sertifikat" class="file-upload-default" id="sertifikat">
            <div class="input-group col-xs-12">
              <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Sertifikat">
              <span class="input-group-append">
                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
              </span>
            </div>
            @error('sertifikat')
              <p class="text-danger">{{ $message }}</p>
            @enderror
            <p class="mt-3">
              *Format File yang diupload adalah gambar
            </p>
          </div>
          <input type="text" name="ormawa_id" id="ormawa_id_prestasi" class="d-none">
            
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Tambah</button>
          <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>