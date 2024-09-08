<div id="tindakanModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog mt-4" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tindakan LPJ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" method="POST" action="" id="tindakanForm">
          @csrf
          @method('patch')

          <div class="row">
            <div class="col">

              <div class="form-group row">
                <label for="judul_feedback" class="col-sm-3 col-form-label">Judul</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="judul" id="judul_feedback" placeholder="Judul" required autocomplete="off" readonly>
                  @error('judul')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="proker" class="col-sm-3 col-form-label">Pilih Tindakan</label>
                <div class="col-sm-9">
                  <div class="form-check form-check-success">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="status" id="setuju" checked="" value="disetujui">
                      Setuju
                    <i class="input-helper"></i></label>
                  </div>
                  <div class="form-check form-check-danger">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="status" id="tolak" value="ditolak">
                      Tolak
                    <i class="input-helper"></i></label>
                  </div>
                  @error('status')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="feedback" class="col-sm-3 col-form-label">Umpan Balik</label>
                <div class="col-sm-9">
                  <textarea class="form-control" id="feedback" name="feedback" value="{{ old('feedback') }}" rows="4" placeholder="Umpan Balik" ></textarea>
                </div>
                @error('feedback')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>

              <input type="hidden" name="lpj_id" id="lpj_id_tindakan">
              <input type="hidden" name="proker_id" id="proker_id_tindakan">
              <input type="hidden" name="user_id" id="user_id_tindakan">
              

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