<div id="editOrmawaModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg mt-4" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Ormawa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" method="POST" action="" id="ormawaForm" enctype="multipart/form-data">
          @csrf
          @method('patch')
          <div class="row">
            <div class="col">

              <div class="form-group row">
                <label for="nama_update" class="col-sm-3 col-form-label">Nama</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="nama" id="nama_update" placeholder="Nama" required autocomplete="off" value="{{ old('nama') }}">
                  @error('nama')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
              
              <div class="form-group row">
                <label for="angkatan_update" class="col-sm-3 col-form-label">Angkatan</label>
                <div class="col-sm-9">
                  <input type="text" name="angkatan" class="form-control" placeholder="Tahun Angkatan" id="datepicker2" autocomplete="off" value="{{ old('angkatan') }}"/>
                  @error('angkatan')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div class="form-group row" id="form-jurusan-update">
                <label for="jurusan_update" class="col-sm-3 col-form-label">Jurusan</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="jurusan" id="jurusan_update" placeholder="Nama Jurusan" autocomplete="off" value="{{ old('jurusan') }}">
                  @error('jurusan')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="deskripsi_update" class="col-sm-3 col-form-label">Deskripsi</label>
                <div class="col-sm-9">
                  <textarea class="form-control" id="deskripsi_update" name="deskripsi" required value="{{ old('deskripsi') }}" rows="4" placeholder="Deskripsi" ></textarea>
                </div>
                @error('deskripsi')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>
            
            </div>
            
            <div class="col">
              <div class="form-group row">
                <div class="col-sm-3">
                  <label for="logo_update">Logo</label>
                </div>
                <div class="col-sm-9">
                  <input type="file" name="logo" class="file-upload-default" id="logo_update" >
                  <div class="input-group col-xs-12">
                    <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Logo">
                    <span class="input-group-append">
                      <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                    </span>
                  </div>
                </div>
                @error('logo')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>

              <p class="card-description mt-5">
                *Abaikan Logo jika tidak ingin mengubah
              </p>
              <input type="hidden" class="form-control" name="oldLogo" id="old_logo_update">
              <input type="hidden" class="form-control" name="oldOrganigram" id="old_file_organigram_update">
            </div>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Ubah</button>
            <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>