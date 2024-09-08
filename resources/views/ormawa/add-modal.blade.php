<div id="tambahOrmawaModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg mt-4" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Ormawa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" method="POST" action="{{ route('ormawa.store') }}" enctype="multipart/form-data">
          @csrf

          <div class="row">
            <div class="col">

              <div class="form-group row">
                <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" required autocomplete="off" value="{{ old('nama') }}">
                  @error('nama')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
              
              <div class="form-group row">
                <label for="angkatan" class="col-sm-3 col-form-label">Angkatan</label>
                <div class="col-sm-9">
                  <input type="text" name="angkatan" class="form-control" id="datepicker" autocomplete="off" value="{{ old('angkatan') }}" placeholder="Angkatan"/>
                  @error('angkatan')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="jenis" class="col-sm-3 col-form-label">Jenis</label>

                <div class="col-sm-9">
                  <select class="form-control" id="jenis" name="jenis">
                    <option value="UKM" selected>Unit Kegiatan Mahasiswa (UKM)</option>
                    <option value="HMJ">Himpunan Mahasiswa Jurusan (HMJ)</option>
                    <option value="BEM">Badan Eksekutif Mahasiswa (BEM)</option>
                    <option value="MPM">Majelis Permusyawaratan Mahasiswa (MPM)</option>
                  </select>
                  @error('jenis')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>

              </div>

              <div class="form-group row" id="form-jurusan">
                <label for="jurusan" class="col-sm-3 col-form-label">Jurusan</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="jurusan" id="jurusan" placeholder="Nama Jurusan" autocomplete="off" value="{{ old('jurusan') }}">
                  @error('jurusan')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
            
            </div>
            
            <div class="col">

              <div class="form-group row">
                <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                <div class="col-sm-9">
                  <textarea class="form-control" id="deskripsi" name="deskripsi" required value="{{ old('deskripsi') }}" rows="4" placeholder="Deskripsi" ></textarea>
                </div>
                @error('deskripsi')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>

              <div class="form-group row">
                <div class="col-sm-3">
                  <label for="logo">Logo</label>
                </div>
                <div class="col-sm-9">
                  <input type="file" name="logo" class="file-upload-default" id="logo">
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
                *Tambahkan pengurus di "Pengguna" setelah membuat Ormawa<br>
                *Tambahkan galeri & prestasi di "Ormawa" setelah membuat Ormawa
              </p>
              
            </div>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Tambah</button>
            <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<script>
  // if jenis == HMJ show jurusan
  $(document).ready(function(){
    $('#form-jurusan').hide();
    $('#jenis').on('change', function() {
      if ( this.value == 'HMJ')
      {
        $("#form-jurusan").show();
      }
      else
      {
        $("#form-jurusan").hide();
      }
    });
  });

</script>