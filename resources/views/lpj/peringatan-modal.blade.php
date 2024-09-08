<div id="peringatanModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog mt-4" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Beri Pengingat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" method="POST" action="" id="peringatanForm">
          @csrf
          @method('patch')

          <div class="row">
            <div class="col">

              <div class="form-group row">
                <label for="judul_peringatan" class="col-sm-3 col-form-label">Judul</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="judul" id="judul_peringatan" placeholder="Judul" required autocomplete="off" readonly>
                  @error('judul')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="peringatan" class="col-sm-3 col-form-label">Pengingat</label>
                <div class="col-sm-9">
                  <textarea class="form-control" id="peringatan" name="peringatan" value="{{ old('peringatan') }}" rows="4" placeholder="peringatan" ></textarea>
                </div>
                @error('peringatan')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>

              <input type="hidden" name="lpj_id" id="lpj_id_peringatan">
              <input type="hidden" name="proker_id" id="proker_id_peringatan">
              <input type="hidden" name="user_id" id="user_id_peringatan">
              

            </div>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Konfirmasi</button>
            <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>