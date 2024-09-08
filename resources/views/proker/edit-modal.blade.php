<div id="editProkerModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg mt-4" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Program Kerja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" method="POST" action="" id="prokerForm">
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
              
              <div class="form-group row">
                <label for="tanggal_pelaksanaan" class="col-sm-3 col-form-label">Tanggal Pelaksanaan</label>
                <div class="col-sm-9">
                  <input type="text" name="tanggal_pelaksanaan" class="form-control" id="tanggal_pelaksanaan_update" autocomplete="off"/>
                  @error('tanggal_pelaksanaan')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="deadline_proposal" class="col-sm-3 col-form-label">Tenggat Waktu Proposal</label>
                <div class="col-sm-9">
                  <input type="text" name="deadline_proposal" class="form-control" id="deadline_proposal_update" autocomplete="off"/>
                  @error('deadline_proposal')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="deadline_lpj" class="col-sm-3 col-form-label">Tenggat Waktu LPJ</label>
                <div class="col-sm-9">
                  <input type="text" name="deadline_lpj" class="form-control" id="deadline_lpj_update" autocomplete="off"/>
                  @error('deadline_lpj')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>            
            </div>
            
            <div class="col">

              <div class="form-group row">
                <label for="sekpro" class="col-sm-3 col-form-label">Sekretaris Proker</label>

                <div class="col-sm-9">
                  <select class="form-control" id="sekpro_update" name="user_id">
                    
                    @foreach ($sekpros as $sekpro)
                      <option value="{{ $sekpro->id }}">{{ $sekpro->nama }}</option>
                    @endforeach

                  </select>
                  @error('user_id')
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