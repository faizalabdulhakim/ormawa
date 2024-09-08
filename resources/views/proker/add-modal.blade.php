<div id="tambahProkerModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg mt-4" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Program Kerja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" method="POST" action="{{ route('proker.store') }}">
          @csrf

          <div class="row">
            <div class="col">

              <div class="form-group row">
                <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Program Kerja" required autocomplete="off" value="{{ old('nama') }}">
                  @error('nama')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
              
              <div class="form-group row">
                <label for="tanggal_pelaksanaan" class="col-sm-3 col-form-label">Tanggal Pelaksanaan</label>
                <div class="col-sm-9">
                  <input type="text" name="tanggal_pelaksanaan" class="form-control" id="tanggal_pelaksanaan" autocomplete="off" value="{{ old('tanggal_pelaksanaan') }}"/>
                  @error('tanggal_pelaksanaan')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="deadline_proposal" class="col-sm-3 col-form-label">Tenggat Waktu Proposal</label>
                <div class="col-sm-9">
                  <input type="text" name="deadline_proposal" class="form-control" id="deadline_proposal" autocomplete="off" value="{{ old('deadline_proposal') }}"/>
                  @error('deadline_proposal')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="deadline_lpj" class="col-sm-3 col-form-label">Tenggat Waktu LPJ</label>
                <div class="col-sm-9">
                  <input type="text" name="deadline_lpj" class="form-control" id="deadline_lpj" autocomplete="off" value="{{ old('deadline_lpj') }}"/>
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
                  <select class="form-control" id="sekpro" name="user_id">
                    @foreach ($sekpros as $sekpro)
                      <option selected value="{{ $sekpro->id }}">{{ $sekpro->nama }}</option>  
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
            <button type="submit" class="btn btn-primary">Tambah</button>
            <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>