@extends('layouts.main')

@section('title')
    Si Ormawa - Edit Template Proposal
@endsection

@section('content')
<div class="row">
  
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">

        <div class="row justify-content-between align-items-center mx-1 mb-5">
          <div>
            <h2>{{ $proposal->judul }}</h2>
          </div>

          <a href="{{ route('proposal.index') }}" class="btn btn-primary items-center"id="btnKembali">
            <i class="mdi mdi-arrow-left"></i>
            Kembali
          </a>
        </div>   

        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-cover-tab" data-toggle="tab" data-target="#nav-cover" type="button" role="tab" aria-controls="nav-cover" aria-selected="true">Cover</button>
            <button class="nav-link" id="nav-pengesahan-tab" data-toggle="tab" data-target="#nav-pengesahan" type="button" role="tab" aria-controls="nav-pengesahan" aria-selected="false">Lembar Pengesahan</button>
            <button class="nav-link" id="nav-latar-tab" data-toggle="tab" data-target="#nav-latar" type="button" role="tab" aria-controls="nav-latar" aria-selected="false">Latar Belakang</button>
            <button class="nav-link" id="nav-nama-tab" data-toggle="tab" data-target="#nav-nama" type="button" role="tab" aria-controls="nav-nama" aria-selected="false">Nama</button>
            <button class="nav-link" id="nav-tema-tab" data-toggle="tab" data-target="#nav-tema" type="button" role="tab" aria-controls="nav-tema" aria-selected="false">Tema</button>
            <button class="nav-link" id="nav-tujuan-tab" data-toggle="tab" data-target="#nav-tujuan" type="button" role="tab" aria-controls="nav-tujuan" aria-selected="false">Tujuan</button>
            <button class="nav-link" id="nav-target-tab" data-toggle="tab" data-target="#nav-target" type="button" role="tab" aria-controls="nav-target" aria-selected="false">Target</button>
            <button class="nav-link" id="nav-konsep-tab" data-toggle="tab" data-target="#nav-konsep" type="button" role="tab" aria-controls="nav-konsep" aria-selected="false">Konsep</button>
            <button class="nav-link" id="nav-waktu-tab" data-toggle="tab" data-target="#nav-waktu" type="button" role="tab" aria-controls="nav-waktu" aria-selected="false">Waktu dan Tempat</button>
            <button class="nav-link" id="nav-kegiatan-tab" data-toggle="tab" data-target="#nav-kegiatan" type="button" role="tab" aria-controls="nav-kegiatan" aria-selected="false">Susunan Kegiatan</button>
            <button class="nav-link" id="nav-kepanitiaan-tab" data-toggle="tab" data-target="#nav-kepanitiaan" type="button" role="tab" aria-controls="nav-kepanitiaan" aria-selected="false">Susunan Kepanitiaan</button>
            <button class="nav-link" id="nav-rab-tab" data-toggle="tab" data-target="#nav-rab" type="button" role="tab" aria-controls="nav-rab" aria-selected="false">Rencana Anggaran Biaya</button>
            <button class="nav-link" id="nav-penutup-tab" data-toggle="tab" data-target="#nav-penutup" type="button" role="tab" aria-controls="nav-penutup" aria-selected="false">Penutup</button>
          </div>
        </nav>

        <form action="{{ route('proposal.print') }}" method="post" enctype="multipart/form-data">
          @csrf
          @method('patch')
          <div class="tab-content" id="nav-tabContent">

            {{-- Cover --}}
            <div class="tab-pane fade show active" id="nav-cover" role="tabpanel" aria-labelledby="nav-cover-tab">
              <div class="row">
                <div class="col-6">
                  <div class="form-group row">
                    <div class="col-sm-9">
                      <input type="file" name="cover" class="file-upload-default" id="cover" onchange="previewImage()">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Cover">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                      <p>*Gambar Cover harus berbentuk .jpg</p>
                    </div>
                    <div class="col-sm-3">
                      @if($proposal->cover)
                        <img id="cover-img" src="{{  asset('storage/' . $proposal->cover)  }}" class="img-fluid img-thumbnail img-preview" style="width: 200px; height: 200px;">
                      @else
                        <img id="cover-img" class="img-fluid img-thumbnail img-preview" style="width: 200px; height: 200px;">
                      @endif
                    </div>
                    @error('cover')
                      <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
                <div class="col-6">
                  <div class="border p-5">
                    <h5>Contoh Cover</h5>
                    <img id="cover-img" src="{{ asset('images/cover/cover-proposal-lpj.jpg') }}" class="img-fluid img-thumbnail" style="width: 300px; height: 400px;">
                    <p class="muted-text">
                      *Konten yang berada dicontoh cover wajib untuk dicantumkan <br>
                      *Penempatan konten bersifat opsional sesuai dengan kebutuhan
                    </p>
                  </div>
                </div>
              </div>  
            </div>

            {{-- Lembar Pengesahan --}}
            <div class="tab-pane fade" id="nav-pengesahan" role="tabpanel" aria-labelledby="nav-pengesahan-tab">
              {{-- Ketuplak --}}
              <div class="row">
                <div class="col-6">
                  <div class="form-group row">
                    <label for="ketua_pelaksana" class="col-sm-3 col-form-label">Ketua Pelaksana</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="ketua_pelaksana" name="ketua_pelaksana">
                        @foreach ($users as $user)
                        @if($user->nim == $proposal->nim_ketua_pelaksana)
                          <option value="{{ $user->id }}" selected>{{ $user->nama }}</option>
                        @else
                          <option value="{{ $user->id }}">{{ $user->nama }}</option>
                        @endif
                        @endforeach
                      </select>
                      @error('ketua_pelaksana')
                        <p class="text-danger">{{ $message }}</p>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>

              @if($ormawa->jenis == "HMJ")
                <div class="row">
                  <div class="col-6">
                    <div class="form-group row">
                      <label for="ketua_jurusan" class="col-sm-3 col-form-label">Ketua Jurusan</label>
                      <div class="col-sm-9">
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="ketua_jurusan" id="ketua_jurusan" placeholder="Ketua Jurusan" required autocomplete="off"
                          @if($proposal->ketua_jurusan)
                            value="{{ $proposal->ketua_jurusan }}"
                          @endif
                          >
                          @error('ketua_jurusan')
                            <p class="text-danger">{{ $message }}</p>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="nip_ketua_jurusan" class="col-sm-3 col-form-label">NIP Ketua Jurusan</label>
                      <div class="col-sm-9">
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="nip_ketua_jurusan" id="nip_ketua_jurusan" placeholder="NIP Ketua Jurusan" required autocomplete="off"
                          @if($proposal->nip_ketua_jurusan)
                            value="{{ $proposal->nip_ketua_jurusan }}"
                          @endif
                          >
                          @error('nip_ketua_jurusan')
                            <p class="text-danger">{{ $message }}</p>
                          @enderror
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endif

            </div>

            {{-- Content (NOT USED) --}}
            <div class="tab-pane fade" id="nav-content" role="tabpanel" aria-labelledby="nav-content-tab">
              <textarea 
                name="content"
                id="content"
                cols="120"
                rows="10"
                @if ($proposal->content)
                  value="{{ $proposal->content }}"
                @endif>
                @if($proposal->content)
                  {{ $proposal->content }}
                @else
                  <ol type="A">
                    <li>
                      <h3>Latar Belakang Kegiatan</h3>
                      <p>Latar belakang Kegiatan berisi informasi yang menjelaskan konteks atau alasan di balik kegiatan yang diajukan. Tujuan dari bagian latar belakang kegiatan adalah untuk memberikan pemahaman tentang masalah, kebutuhan, atau peluang yang ada, sehingga pembaca proposal dapat mengerti mengapa kegiatan tersebut perlu dilakukan</p>
                    </li>
                    <li>
                      <h3>Nama Kegiatan</h3>
                      <p>Nama kegiatan berisi judul atau nama yang mencerminkan secara ringkas dan jelas tentang kegiatan yang diusulkan. </p>
                    </li>
                    <li>
                      <h3>Tema Kegiatan</h3>
                      <p>Tema kegiatan berisi topik atau fokus utama yang ingin diangkat atau dijelajahi melalui kegiatan yang diusulkan.</p>
                    </li>
                    <li>
                      <h3>Tujuan Kegiatan</h3>
                      <p>Tujuan kegiatan berisi tujuan yang ingin dicapai melalui pelaksanaan kegiatan yang diusulkan.</p>
                    </li>
                    <li>
                      <h3>Target</h3>
                      <p>Target kegiatan berisi kelompok sasaran atau audiens yang akan diuntungkan atau terlibat dalam pelaksanaan kegiatan yang diusulkan. </p>
                    </li>
                    <li>
                      <h3>Konsep</h3>
                      <p>Konsep kegiatan berisi rincian tentang jenis kegiatan yang akan dilakukan dalam rangka mencapai tujuan yang telah ditetapkan.</p>
                    </li>
                    <li>
                      <h3>Waktu dan Tempat Pelaksanaan</h3>
                      <p>Hari       : </p>
                      <p>Tanggal    : </p>
                      <p>Waktu      : </p>
                      <p>Tempat     : </p>
                    </li>
                    <li>
                      <h3>Susunan Kegiatan</h3>
                      <p><i>(Terlampir I)</i></p>
                    </li>
                    <li>
                      <h3>Susunan Kepanitiaan</h3>
                      <p><i>(Terlampir II)</i></p>
                    </li>
                    <li>
                      <h3>Rencana Anggaran Biaya</h3>
                      <p><i>(Terlampir III)</i></p>
                    </li>
                    <li>
                      <h3>Penutup</h3>
                      <p>Penutup berisi rangkuman singkat dari proposal yang diajukan, pengingat tentang manfaat dan relevansi proposal tersebut, serta permohonan atau harapan untuk mendapatkan persetujuan atau dukungan dari pihak yang menerima proposal</p>
                    </li>
                  </ol>
                  <ul>
                    <li>
                      <i>Lampiran I</i>
                      <h3 style="text-align: center">SUSUNAN KEGIATAN</h3>
                      <table style="border-collapse: collapse; width: 99.9616%; height: 201.6px;" border="1"><colgroup><col style="width: 19.9616%;"><col style="width: 19.9616%;"><col style="width: 19.9616%;"><col style="width: 19.9616%;"><col style="width: 19.9616%;"></colgroup>
                        <tbody>
                        <tr style="height: 22.4px;">
                        <td style="height: 22.4px; text-align: center;"><strong>Hari/Tanggal</strong></td>
                        <td style="height: 22.4px; text-align: center;"><strong>Waktu</strong></td>
                        <td style="height: 22.4px; text-align: center;"><strong>Kegiatan</strong></td>
                        <td style="height: 22.4px; text-align: center;"><strong>Tempat</strong></td>
                        <td style="height: 22.4px; text-align: center;"><strong>Penanggungjawab</strong></td>
                        </tr>
                        <tr style="height: 22.4px;">
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        </tr>
                        <tr style="height: 22.4px;">
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        </tr>
                        <tr style="height: 22.4px;">
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        </tr>
                        <tr style="height: 22.4px;">
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        </tr>
                        <tr style="height: 22.4px;">
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        </tr>
                        <tr style="height: 22.4px;">
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        </tr>
                        <tr style="height: 22.4px;">
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        </tr>
                        <tr style="height: 22.4px;">
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        <td style="height: 22.4px;">&nbsp;</td>
                        </tr>
                        </tbody>
                      </table>
                    </li>
                    <li>
                      <i>Lampiran II</i>
                      <h3 style="text-align: center">SUSUNAN KEPANITIAAN KEGIATAN</h3>
                      <p>Ketua Pelaksana            :</p>
                      <p>Wakil Ketua Pelaksana      :</p>
                      <p>Sekretaris                 :</p>
                      <p>Bendahara                  :</p>
                      <p>Div. Acara                 :</p>
                      <p>Div. Humas                 :</p>
                      <p>Div. Konsumsi              :</p>
                      <p>Div. Logistik & Keamanan   :</p>
                      <p>Div. Pubdekdok             :</p>
                      <p>Div. Koordinator Lapangan  :</p>
                    </li>
                    <li>
                      <i>Lampiran III</i>
                      <h3 style="text-align: center">RENCANA ANGGARAN BIAYA</h3>
                      <table style="border-collapse: collapse; width: 99.9616%;" border="1"><colgroup><col style="width: 16.6987%;"><col style="width: 16.6987%;"><col style="width: 16.6987%;"><col style="width: 16.6987%;"><col style="width: 16.6987%;"><col style="width: 16.6987%;"></colgroup>
                        <tbody>
                        <tr>
                        <td style="text-align: center;"><strong>No</strong></td>
                        <td style="text-align: center;"><strong>Keterangan</strong></td>
                        <td style="text-align: center;"><strong>QTY</strong></td>
                        <td style="text-align: center;"><strong>Satuan</strong></td>
                        <td style="text-align: center;"><strong>Harga</strong></td>
                        <td style="text-align: center;"><strong>Jumlah</strong></td>
                        </tr>
                        <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        </tr>
                        <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        </tr>
                        <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        </tr>
                        <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        </tr>
                        <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        </tr>
                        <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        </tr>
                        </tbody>
                      </table>
                    </li>
                  </ul>
                @endif
              </textarea>
            </div>

            {{-- Latar Belakang --}}
            <div class="tab-pane fade" id="nav-latar" role="tabpanel" aria-labelledby="nav-latar-tab">
              <h2>Latar Belakang</h2>
              <textarea 
                name="latar_belakang"
                id="latar_belakang"
                cols="120"
                rows="10"
                @if ($proposal->latar_belakang)
                  value="{{ $proposal->latar_belakang }}"
                @endif>
                @if($proposal->latar_belakang)
                  {{ $proposal->latar_belakang }}
                @else
                  <p>Latar belakang Kegiatan berisi informasi yang menjelaskan konteks atau alasan di balik kegiatan yang diajukan. Tujuan dari bagian latar belakang kegiatan adalah untuk memberikan pemahaman tentang masalah, kebutuhan, atau peluang yang ada, sehingga pembaca proposal dapat mengerti mengapa kegiatan tersebut perlu dilakukan</p>
                @endif
              </textarea>
              <h2 class="mt-5">Komentar</h2>
              <textarea 
                name="komentar_latar_belakang"
                id="komentar_latar_belakang"
                cols="120"
                rows="10"
                class="komentar"
                @if ($proposal->komentar_latar_belakang)
                  value="{{ $proposal->komentar_latar_belakang }}"
                @endif>
                @if($proposal->komentar_latar_belakang)
                  {{ $proposal->komentar_latar_belakang }}
                @else
                  
                @endif
              </textarea>

            </div>

            {{-- Nama --}}
            <div class="tab-pane fade" id="nav-nama" role="tabpanel" aria-labelledby="nav-nama-tab">
              <h2>Nama</h2>
              <textarea 
                name="nama"
                id="nama"
                cols="120"
                rows="10"
                @if ($proposal->nama)
                  value="{{ $proposal->nama }}"
                @endif>
                @if($proposal->nama)
                  {{ $proposal->nama }}
                @else
                  <p>Nama kegiatan berisi judul atau nama yang mencerminkan secara ringkas dan jelas tentang kegiatan yang diusulkan. </p>
                @endif
              </textarea>
              <h2 class="mt-5">Komentar</h2>
              <textarea 
                name="komentar_nama"
                id="komentar_nama"
                cols="120"
                rows="10"
                class="komentar"
                @if ($proposal->komentar_nama)
                  value="{{ $proposal->komentar_nama }}"
                @endif>
                @if($proposal->komentar_nama)
                  {{ $proposal->komentar_nama }}
                @else
                  
                @endif
              </textarea>
            </div>

            {{-- Tema --}}
            <div class="tab-pane fade" id="nav-tema" role="tabpanel" aria-labelledby="nav-tema-tab">
              <h2>Tema</h2>
              <textarea 
                name="tema"
                id="tema"
                cols="120"
                rows="10"
                @if ($proposal->tema)
                  value="{{ $proposal->tema }}"
                @endif>
                @if($proposal->tema)
                  {{ $proposal->tema }}
                @else
                  <p>Tema kegiatan berisi topik atau fokus utama yang ingin diangkat atau dijelajahi melalui kegiatan yang diusulkan.</p>
                @endif
              </textarea>
              <h2 class="mt-5">Komentar</h2>
              <textarea 
                name="komentar_tema"
                id="komentar_tema"
                cols="120"
                rows="10"
                class="komentar"
                @if ($proposal->komentar_tema)
                  value="{{ $proposal->komentar_tema }}"
                @endif>
                @if($proposal->komentar_tema)
                  {{ $proposal->komentar_tema }}
                @else
                  
                @endif
              </textarea>
            </div>

            {{-- Tujuan --}}
            <div class="tab-pane fade" id="nav-tujuan" role="tabpanel" aria-labelledby="nav-tujuan-tab">
              <h2>Tujuan</h2>
              <textarea 
                name="tujuan"
                id="tujuan"
                cols="120"
                rows="10"
                @if ($proposal->tujuan)
                  value="{{ $proposal->tujuan }}"
                @endif>
                @if($proposal->tujuan)
                  {{ $proposal->tujuan }}
                @else
                  <p>Tujuan kegiatan berisi tujuan yang ingin dicapai melalui pelaksanaan kegiatan yang diusulkan.</p>
                @endif
              </textarea>
              <h2 class="mt-5">Komentar</h2>
              <textarea 
                name="komentar_tujuan"
                id="komentar_tujuan"
                cols="120"
                rows="10"
                class="komentar"
                @if ($proposal->komentar_tujuan)
                  value="{{ $proposal->komentar_tujuan }}"
                @endif>
                @if($proposal->komentar_tujuan)
                  {{ $proposal->komentar_tujuan }}
                @else
                  
                @endif
              </textarea>
            </div>

            {{-- Target --}}
            <div class="tab-pane fade" id="nav-target" role="tabpanel" aria-labelledby="nav-target-tab">
              <h2>Target</h2>
              <textarea 
                name="target"
                id="target"
                cols="120"
                rows="10"
                @if ($proposal->target)
                  value="{{ $proposal->target }}"
                @endif>
                @if($proposal->target)
                  {{ $proposal->target }}
                @else
                  <p>Target kegiatan berisi kelompok sasaran atau audiens yang akan diuntungkan atau terlibat dalam pelaksanaan kegiatan yang diusulkan. </p>
                @endif
              </textarea>
              <h2 class="mt-5">Komentar</h2>
              <textarea 
                name="komentar_target"
                id="komentar_target"
                cols="120"
                rows="10"
                class="komentar"
                @if ($proposal->komentar_target)
                  value="{{ $proposal->komentar_target }}"
                @endif>
                @if($proposal->komentar_target)
                  {{ $proposal->komentar_target }}
                @else
                  
                @endif
              </textarea>
            </div>

            {{-- Konsep --}}
            <div class="tab-pane fade" id="nav-konsep" role="tabpanel" aria-labelledby="nav-konsep-tab">
              <h2>Konsep</h2>
              <textarea 
                name="konsep"
                id="konsep"
                cols="120"
                rows="10"
                @if ($proposal->konsep)
                  value="{{ $proposal->konsep }}"
                @endif>
                @if($proposal->konsep)
                  {{ $proposal->konsep }}
                @else
                  <p>Konsep kegiatan berisi rincian tentang jenis kegiatan yang akan dilakukan dalam rangka mencapai tujuan yang telah ditetapkan.</p>
                @endif
              </textarea>
              <h2 class="mt-5">Komentar</h2>
              <textarea 
                name="komentar_konsep"
                id="komentar_konsep"
                cols="120"
                rows="10"
                class="komentar"
                @if ($proposal->komentar_konsep)
                  value="{{ $proposal->komentar_konsep }}"
                @endif>
                @if($proposal->komentar_konsep)
                  {{ $proposal->komentar_konsep }}
                @else
                  
                @endif
              </textarea>
            </div>

            {{-- Waktu dan Tempat --}}
            <div class="tab-pane fade" id="nav-waktu" role="tabpanel" aria-labelledby="nav-waktu-tab">
              <h2>Waktu dan Tempat</h2>
              <textarea 
                name="waktu"
                id="waktu"
                cols="120"
                rows="10"
                @if ($proposal->waktu)
                  value="{{ $proposal->waktu }}"
                @endif>
                @if($proposal->waktu)
                  {{ $proposal->waktu }}
                @else
                  <p>Hari       : </p>
                  <p>Tanggal    : </p>
                  <p>Waktu      : </p>
                  <p>Tempat     : </p>
                @endif
              </textarea>
              <h2 class="mt-5">Komentar</h2>
              <textarea 
                name="komentar_waktu"
                id="komentar_waktu"
                cols="120"
                rows="10"
                class="komentar"
                @if ($proposal->komentar_waktu)
                  value="{{ $proposal->komentar_waktu }}"
                @endif>
                @if($proposal->komentar_waktu)
                  {{ $proposal->komentar_waktu }}
                @else
                  
                @endif
              </textarea>
            </div>

            {{-- Susunan Kegiatan --}}
            <div class="tab-pane fade" id="nav-kegiatan" role="tabpanel" aria-labelledby="nav-kegiatan-tab">
              <h2>Susunan Kegiatan</h2>
              <textarea 
                name="susunan_kegiatan"
                id="susunan_kegiatan"
                cols="120"
                rows="10"
                @if ($proposal->susunan_kegiatan)
                  value="{{ $proposal->susunan_kegiatan }}"
                @endif>
                @if($proposal->susunan_kegiatan)
                  {{ $proposal->susunan_kegiatan }}
                @else
                  <i>Lampiran I</i>
                  <h3 style="text-align: center">SUSUNAN KEGIATAN</h3>
                  <table style="border-collapse: collapse; width: 99.9616%; height: 201.6px;" border="1"><colgroup><col style="width: 19.9616%;"><col style="width: 19.9616%;"><col style="width: 19.9616%;"><col style="width: 19.9616%;"><col style="width: 19.9616%;"></colgroup>
                    <tbody>
                    <tr style="height: 22.4px;">
                    <td style="height: 22.4px; text-align: center;"><strong>Hari/Tanggal</strong></td>
                    <td style="height: 22.4px; text-align: center;"><strong>Waktu</strong></td>
                    <td style="height: 22.4px; text-align: center;"><strong>Kegiatan</strong></td>
                    <td style="height: 22.4px; text-align: center;"><strong>Tempat</strong></td>
                    <td style="height: 22.4px; text-align: center;"><strong>Penanggungjawab</strong></td>
                    </tr>
                    <tr style="height: 22.4px;">
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    </tr>
                    <tr style="height: 22.4px;">
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    </tr>
                    <tr style="height: 22.4px;">
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    </tr>
                    <tr style="height: 22.4px;">
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    </tr>
                    <tr style="height: 22.4px;">
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    </tr>
                    <tr style="height: 22.4px;">
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    </tr>
                    <tr style="height: 22.4px;">
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    </tr>
                    <tr style="height: 22.4px;">
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    <td style="height: 22.4px;">&nbsp;</td>
                    </tr>
                    </tbody>
                  </table>
                @endif
              </textarea>
              <h2 class="mt-5">Komentar</h2>
              <textarea 
                name="komentar_susunan_kegiatan"
                id="komentar_susunan_kegiatan"
                cols="120"
                rows="10"
                class="komentar"
                @if ($proposal->komentar_susunan_kegiatan)
                  value="{{ $proposal->komentar_susunan_kegiatan }}"
                @endif>
                @if($proposal->komentar_susunan_kegiatan)
                  {{ $proposal->komentar_susunan_kegiatan }}
                @else
                  
                @endif
              </textarea>
            </div>

            {{-- Susunan Kepanitiaan --}}
            <div class="tab-pane fade" id="nav-kepanitiaan" role="tabpanel" aria-labelledby="nav-kepanitiaan-tab">
              <h2>Susunan Kepanitiaan</h2>
              <textarea 
                name="susunan_kepanitiaan"
                id="susunan_kepanitiaan"
                cols="120"
                rows="10"
                @if ($proposal->susunan_kepanitiaan)
                  value="{{ $proposal->susunan_kepanitiaan }}"
                @endif>
                @if($proposal->susunan_kepanitiaan)
                  {{ $proposal->susunan_kepanitiaan }}
                @else
                  <i>Lampiran II</i>
                  <h3 style="text-align: center">SUSUNAN KEPANITIAAN KEGIATAN</h3>
                  <p>Ketua Pelaksana            :</p>
                  <p>Wakil Ketua Pelaksana      :</p>
                  <p>Sekretaris                 :</p>
                  <p>Bendahara                  :</p>
                  <p>Div. Acara                 :</p>
                  <p>Div. Humas                 :</p>
                  <p>Div. Konsumsi              :</p>
                  <p>Div. Logistik & Keamanan   :</p>
                  <p>Div. Pubdekdok             :</p>
                  <p>Div. Koordinator Lapangan  :</p>
                @endif
              </textarea>
              <h2 class="mt-5">Komentar</h2>
              <textarea 
                name="komentar_susunan_kepanitiaan"
                id="komentar_susunan_kepanitiaan"
                cols="120"
                rows="10"
                class="komentar"
                @if ($proposal->komentar_susunan_kepanitiaan)
                  value="{{ $proposal->komentar_susunan_kepanitiaan }}"
                @endif>
                @if($proposal->komentar_susunan_kepanitiaan)
                  {{ $proposal->komentar_susunan_kepanitiaan }}
                @else
                  
                @endif
              </textarea>
            </div>

            {{-- RAB --}}
            <div class="tab-pane fade" id="nav-rab" role="tabpanel" aria-labelledby="nav-rab-tab">
              <h2>Rencana Anggaran Biaya</h2>
              <textarea 
                name="rab"
                id="rab"
                cols="120"
                rows="10"
                @if ($proposal->rab)
                  value="{{ $proposal->rab }}"
                @endif>
                @if($proposal->rab)
                  {{ $proposal->rab }}
                @else
                  <i>Lampiran III</i>
                  <h3 style="text-align: center">RENCANA ANGGARAN BIAYA</h3>
                  <table style="border-collapse: collapse; width: 99.9616%;" border="1"><colgroup><col style="width: 16.6987%;"><col style="width: 16.6987%;"><col style="width: 16.6987%;"><col style="width: 16.6987%;"><col style="width: 16.6987%;"><col style="width: 16.6987%;"></colgroup>
                    <tbody>
                    <tr>
                    <td style="text-align: center;"><strong>No</strong></td>
                    <td style="text-align: center;"><strong>Keterangan</strong></td>
                    <td style="text-align: center;"><strong>QTY</strong></td>
                    <td style="text-align: center;"><strong>Satuan</strong></td>
                    <td style="text-align: center;"><strong>Harga</strong></td>
                    <td style="text-align: center;"><strong>Jumlah</strong></td>
                    </tr>
                    <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    </tr>
                    <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    </tr>
                    <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    </tr>
                    <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    </tr>
                    <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    </tr>
                    <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    </tr>
                    </tbody>
                  </table>
                @endif
              </textarea>
              <h2 class="mt-5">Komentar</h2>
              <textarea 
                name="komentar_rab"
                id="komentar_rab"
                cols="120"
                rows="10"
                class="komentar"
                @if ($proposal->komentar_rab)
                  value="{{ $proposal->komentar_rab }}"
                @endif>
                @if($proposal->komentar_rab)
                  {{ $proposal->komentar_rab }}
                @else
                  
                @endif
              </textarea>
            </div>

            {{-- Penutup --}}
            <div class="tab-pane fade" id="nav-penutup" role="tabpanel" aria-labelledby="nav-penutup-tab">
              <h2>Penutup</h2>
              <textarea 
                name="penutup"
                id="penutup"
                cols="120"
                rows="10"
                @if ($proposal->penutup)
                  value="{{ $proposal->penutup }}"
                @endif>
                @if($proposal->penutup)
                  {{ $proposal->penutup }}
                @else
                  <p>Penutup berisi rangkuman singkat dari proposal yang diajukan, pengingat tentang manfaat dan relevansi proposal tersebut, serta permohonan atau harapan untuk mendapatkan persetujuan atau dukungan dari pihak yang menerima proposal</p>
                @endif
              </textarea>
              <h2 class="mt-5">Komentar</h2>
              <textarea 
                name="komentar_penutup"
                id="komentar_penutup"
                cols="120"
                rows="10"
                class="komentar"
                @if ($proposal->komentar_penutup)
                  value="{{ $proposal->komentar_penutup }}"
                @endif>
                @if($proposal->komentar_penutup)
                  {{ $proposal->komentar_penutup }}
                @else
                  
                @endif
              </textarea>
            </div>

          </div>
          <input type="hidden" name="proposal_id" value="{{ $proposal->id }}">
          <input type="hidden" name="tipe" id="tipeBtn" value="">

          @if(auth()->user()->role() == 'sekretaris_proker')
            <button type="submit" class="btn btn-primary mt-3" id="btnSimpan">Simpan</button>
            <button type="submit" class="btn btn-primary mt-3" id="btnAjukan">Ajukan</button>
          @elseif(auth()->user()->role() == 'pembina')
            <button type="submit" class="btn btn-primary mt-3">Beri Komentar</button>
          @endif
          <a href="{{ route('proposal.index') }}" class="btn btn-light mt-3">Batal</a>
        </form>

      </div>
    </div>
  </div>
</div>

{{-- IF PEMBINA --}}
@if(auth()->user()->role() == 'pembina')

  <script>
    tinymce.init({
      selector: 'textarea.komentar',
      height:300,
    });

    tinymce.init({
      selector: 'textarea',
      readonly: true,
      height: 1000,
    });

    $('input').attr('disabled', true);
    $('select').attr('disabled', true);
    $('textarea').attr('disabled', true);
    $('textarea.komentar').attr('disabled', false);

    $('form').submit(function() {
      $('input').attr('disabled', false);
      $('select').attr('disabled', false);
    });
    
  </script>

{{-- IF SEKPRO --}}
@elseif(auth()->user()->role() == 'sekretaris_proker')

  <script>

    tinymce.init({
      selector: 'textarea.komentar',
      readonly: true,
      height: 300,
    });

    tinymce.init({
      selector: 'textarea',
      height: 1000,
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
      images_file_types: 'jpg,svg,webp,png',
      file_picker_types: 'file image media',
      mergetags_list: [
        { value: 'First.Name', title: 'First Name' },
        { value: 'Email', title: 'Email' },
      ]
    });

  </script>

{{-- IF ADMIN --}}
@else

  <script>
    tinymce.init({
        selector: 'textarea.komentar',
        readonly: true,
        height: 300,
      });

    tinymce.init({
      selector: 'textarea',
      readonly: true,
      height: 1000,
    });

    $('input').attr('disabled', true);
    $('select').attr('disabled', true);
    $('textarea').attr('disabled', true);
  </script>

@endif

{{-- SIMPAN OR AJUKAN --}}
<script>
  $('#btnSimpan').click(function() {
    $('#tipeBtn').val('simpan');
  });

  $('#btnAjukan').click(function() {
    $('#tipeBtn').val('ajukan');
  });
</script>

{{-- SIDEBAR --}}
<script>
  setTimeout(function() {
    $('.nav-item.active').removeClass('active');
  
    $('ul').find('li:contains("Proposal")').addClass('active');

  }, 300);
</script>

<script>
  function previewImage(){
    const image = document.querySelector('#cover');
    const imgPreview = document.querySelector('.img-preview');

    imgPreview.style.display = 'block';

    const oFReader = new FileReader();
    oFReader.readAsDataURL(image.files[0]);

    oFReader.onload = function(oFREvent){
      imgPreview.src = oFREvent.target.result;
    }
  }
</script>

@endsection
