<div id="tambahUserModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg mt-4" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" method="POST" action="{{ route('user.store') }}">
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
                <label for="nim" class="col-sm-3 col-form-label">NIM</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="nim" id="nim" placeholder="NIM/NIP" required autocomplete="off" value="{{ old('nim') }}">
                  @error('nim')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
              
              <div class="form-group row">
                <label for="username" class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="username" name="username" placeholder="Username" required autocomplete="off" value="{{ old('username') }}">
                  @error('username')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>

            </div>

            <div class="col">

              <div class="form-group row">
                <label for="password" class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password" required autocomplete="off" value="{{ old('password') }}">
                  @error('password')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="confirm-password" class="col-sm-3 col-form-label">Confirm Password</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" id="confirm-password" placeholder="Confirm Password" name="password_confirmation" required autocomplete="off" value="{{ old('password') }}">
                </div>
              </div>

              <div class="form-group row">
                <label for="role" class="col-sm-3 col-form-label">Role</label>
                <div class="col-sm-9">
                  <select class="form-control" id="role" name="role">
                    <option value="ketua" selected>Ketua</option>
                    <option value="sekretaris_umum">Sekretaris Umum</option>
                    <option value="sekretaris_proker">Sekretaris Proker</option>
                    <option value="pembina">Pembina</option>
                  </select>
                  @error('role')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
              
              <div class="form-group row">
                <label for="ormawa" class="col-sm-3 col-form-label">Ormawa</label>
                <div class="col-sm-9">
                  <select class="form-control" id="ormawa" name="ormawa_id">
                    @foreach ($ormawa as $item)
                      <option value="{{ $item->id }}">{{ $item->nama }} - {{ $item->angkatan }}</option>  
                    @endforeach
                  </select>
                  @error('ormawa_id')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
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