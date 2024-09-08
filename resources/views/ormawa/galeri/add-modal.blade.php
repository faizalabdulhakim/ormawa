<div id="galeriModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog mt-4" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="forms-sample" method="POST" action="{{ route('galeri-ormawa.store') }}" enctype="multipart/form-data">
      @csrf
        <div class="modal-body">
            <div class="form-group">
              <label for="tipe">Tipe</label>
              <select class="form-control form-control-sm" id="tipe" name="tipe">
                <option value="foto">Foto</option>
                <option value="video">Video</option>
              </select>
              @error('tipe')
                <p class="text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="form-group">
              <label for="nama_file">Upload File</label>
              <input type="file" name="nama_file" class="file-upload-default" id="nama_file">
              <div class="input-group col-xs-12">
                <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload File">
                <span class="input-group-append">
                  <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                </span>
              </div>
              @error('nama_file')
                <p class="text-danger">{{ $message }}</p>
              @enderror
              <p class="mt-3">
                *Format File yang diupload adalah gambar atau video
              </p>
            </div>
            <input type="text" name="ormawa_id" id="ormawa_id_galeri" class="d-none">
            
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Tambah</button>
          <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>