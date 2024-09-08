<div id="editUserModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg mt-4" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" method="POST" action="" id="userForm">
          @csrf
          @method('patch')

          <div class="row">
            <div class="col">
              <div class="form-group row">
                <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="nama" id="nama_update" placeholder="Nama" required autocomplete="off">
                  @error('nama')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div class="form-group row no-wadir">
                <label for="username" class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="username_update" name="username" placeholder="Username" required autocomplete="off">
                  @error('username')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>

            </div>
            <div class="col">

              <div class="form-group row">
                <label for="nim" class="col-sm-3 col-form-label">NIM/NIP</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="nim_update" name="nim" placeholder="nim" required autocomplete="off">
                  @error('nim')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div class="form-group row no-wadir">
                <label for="role" class="col-sm-3 col-form-label">Role</label>

                <div class="col-sm-9">
                  <select class="form-control" id="role_update" name="role">
                    <option value="ketua" selected>Ketua</option>
                    <option value="sekretaris_umum">Sekretaris Umum</option>
                    <option value="sekretaris_proker">Sekretaris Proker</option>
                    <option value="pembina">Pembina</option>
                    <option value="anggota">Anggota</option>
                  </select>
                  @error('role')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>

              </div>

              <div class="form-group row no-wadir">
                <label for="ormawa" class="col-sm-3 col-form-label">Ormawa</label>
                <div class="col-sm-9">
                  <select class="form-control" id="ormawa_update" name="ormawa_id">
                    @foreach ($ormawa as $item)
                      <option value="{{ $item->id }}">{{ $item->nama }}</option>
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
            <button type="submit" class="btn btn-primary">Ubah</button>
            <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
