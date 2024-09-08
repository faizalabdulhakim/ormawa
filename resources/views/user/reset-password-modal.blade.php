<div id="resetPasswordModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog mt-4" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ubah Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" method="POST" action="" id="resetForm">
          @csrf
          @method('patch')

          <div class="row">
            <div class="col">

              <div class="form-group row">
                <label for="username" class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="username" id="username_reset" placeholder="Username" required autocomplete="off" value="{{ old('username') }}" readonly>
                  @error('username')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
              
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
                <label for="confirm-password" class="col-sm-3 col-form-label">Konfirmasi Password</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" id="confirm-password" placeholder="Konfirmasi Password" name="password_confirmation" required autocomplete="off" value="{{ old('password') }}">
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