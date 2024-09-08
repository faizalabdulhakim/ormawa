<div id="tambahPembinaModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog mt-4" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Pembina</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" method="POST" action="" id="tambahpembinaForm">
          @csrf
          @method('patch')

          <div class="row">
            <div class="col">
              
              <div class="form-group row justify-content-end">
                <label for="ormawa_pembina" class="col-sm-3 col-form-label">Ormawa</label>
                <div class="col-sm-9">
                  <select class="form-control" id="tambahOrmawa" name="ormawa_id">
                    @php
                        $filteredOrmawa = $ormawa->filter(function ($ormawa) use ($user) {
                            return !$user->ormawas->contains('id', $ormawa->id);
                        });
                    @endphp
                    @foreach ($filteredOrmawa as $item)
                      <option value="{{ $item->id }}">
                        {{ $item->nama }} - {{ $item->angkatan }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

            </div>
          </div>

          <input type="hidden" id="userIdInput" name="user_id">

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Tambah</button>
            <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
