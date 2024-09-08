@extends('layouts.main')

@section('title')
    Si Ormawa - Edit Template LPJ
@endsection

@section('content')
<div class="row">

  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">

        <div class="row justify-content-between align-items-center mx-1 mb-5">
          <div>
            <h2>{{ $lpj->judul }}</h2>
          </div>

          <a href="{{ route('lpj.index') }}" class="btn btn-primary items-center"id="btnKembali">
            <i class="mdi mdi-arrow-left"></i>
            Kembali
          </a>
        </div>

        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-cover-tab" data-toggle="tab" data-target="#nav-cover" type="button" role="tab" aria-controls="nav-cover" aria-selected="true">Cover</button>
            <button class="nav-link" id="nav-pengantar-tab" data-toggle="tab" data-target="#nav-pengantar" type="button" role="tab" aria-controls="nav-pengantar" aria-selected="false">Kata Pengantar</button>
            <button class="nav-link" id="nav-latar-tab" data-toggle="tab" data-target="#nav-latar" type="button" role="tab" aria-controls="nav-latar" aria-selected="false">Latar Belakang</button>
            <button class="nav-link" id="nav-nama-tab" data-toggle="tab" data-target="#nav-nama" type="button" role="tab" aria-controls="nav-nama" aria-selected="false">Nama</button>
            <button class="nav-link" id="nav-tema-tab" data-toggle="tab" data-target="#nav-tema" type="button" role="tab" aria-controls="nav-tema" aria-selected="false">Tema</button>
            <button class="nav-link" id="nav-tujuan-tab" data-toggle="tab" data-target="#nav-tujuan" type="button" role="tab" aria-controls="nav-tujuan" aria-selected="false">Tujuan</button>
            <button class="nav-link" id="nav-sasaran-tab" data-toggle="tab" data-target="#nav-sasaran" type="button" role="tab" aria-controls="nav-sasaran" aria-selected="false">Sasaran</button>
            <button class="nav-link" id="nav-waktu-tab" data-toggle="tab" data-target="#nav-waktu" type="button" role="tab" aria-controls="nav-waktu" aria-selected="false">Waktu dan Tempat</button>
            <button class="nav-link" id="nav-kendala-tab" data-toggle="tab" data-target="#nav-kendala" type="button" role="tab" aria-controls="nav-kendala" aria-selected="false">Kendala & Evaluasi</button>
            <button class="nav-link" id="nav-kegiatan-tab" data-toggle="tab" data-target="#nav-kegiatan" type="button" role="tab" aria-controls="nav-kegiatan" aria-selected="false">Susunan Kegiatan</button>
            <button class="nav-link" id="nav-kepanitiaan-tab" data-toggle="tab" data-target="#nav-kepanitiaan" type="button" role="tab" aria-controls="nav-kepanitiaan" aria-selected="false">Susunan Kepanitiaan</button>
            <button class="nav-link" id="nav-rab-tab" data-toggle="tab" data-target="#nav-rab" type="button" role="tab" aria-controls="nav-rab" aria-selected="false">Realisasi Rencana Anggaran Biaya</button>
            <button class="nav-link" id="nav-penutup-tab" data-toggle="tab" data-target="#nav-penutup" type="button" role="tab" aria-controls="nav-penutup" aria-selected="false">Penutup</button>
            <button class="nav-link" id="nav-bukti-tab" data-toggle="tab" data-target="#nav-bukti" type="button" role="tab" aria-controls="nav-bukti" aria-selected="false">Bukti Transaksi</button>
            <button class="nav-link" id="nav-dokumentasi-tab" data-toggle="tab" data-target="#nav-dokumentasi" type="button" role="tab" aria-controls="nav-dokumentasi" aria-selected="false">Dokumentasi</button>
          </div>
        </nav>

        <form action="{{ route('lpj.print') }}" method="post" enctype="multipart/form-data">
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
                      @if($lpj->cover)
                        <img id="cover-img" src="{{  asset('storage/' . $lpj->cover)  }}" class="img-fluid img-thumbnail img-preview" style="width: 200px; height: 200px;">
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

            {{-- Kata Pengantar --}}
            <div class="tab-pane fade" id="nav-pengantar" role="tabpanel" aria-labelledby="nav-pengantar-tab">
              <textarea name="kata_pengantar" id="kata_pengantar" cols="80" rows="10">
                @if ($lpj->kata_pengantar)
                  {{ $lpj->kata_pengantar }}
                @else
                  <h3 style="text-align: center">KATA PENGANTAR</h3>
                  <p style="padding-left: 80px;"><< content >></p>
                @endif

              </textarea>

              <h2 class="mt-5">Komentar</h2>
              <textarea 
                name="komentar_kata_pengantar"
                id="komentar_kata_pengantar"
                cols="120"
                rows="10"
                class="komentar">
                @if($lpj->komentar_kata_pengantar)
                  {{ $lpj->komentar_kata_pengantar }}
                @endif
              </textarea>
            </div>

            {{-- Pendahuluan (NOT USED) --}}
            <div class="tab-pane fade" id="nav-pendahuluan" role="tabpanel" aria-labelledby="nav-pendahuluan-tab">
              <textarea name="" id="pendahuluan" cols="80" rows="10"
                @if ($lpj->pendahuluan)
                  value="{{ $lpj->pendahuluan }}"
                @endif>
                @if($lpj->pendahuluan)
                  {{ $lpj->pendahuluan }}
                @else
                  <h3 style="text-align: center">PENDAHULUAN</h3>
                  <ol type="A" style="padding-left: 80px;">
                    <li>
                      <h3>Latar Belakang</h3>
                      <p>Latar belakang berisi informasi yang menjelaskan konteks atau latar belakang dari kegiatan yang dilaporkan. </p>
                    </li>
                    <li>
                      <h3>Nama Kegiatan</h3>
                      <p>Nama kegiatan berisi nama kegiatan atau program yang telah dilaksanakan</p>
                    </li>
                    <li>
                      <h3>Tema Kegiatan</h3>
                      <p>Tema kegiatan berisi topik atau fokus utama yang ingin diangkat atau dijelajahi melalui kegiatan yang telah dilaksanakan</p>
                    </li>
                    <li>
                      <h3>Tujuan</h3>
                      <p>Tujuan kegiatan berisi tujuan yang ingin dicapai melalui pelaksanaan kegiatan yang telah dilaksanakan</p>
                    </li>
                    <li>
                      <h3>Sasaran</h3>
                      <p>Sasaran kegiatan berisi kelompok sasaran atau audiens yang akan diuntungkan atau terlibat dalam pelaksanaan kegiatan yang telah dilaksanakan.</p>
                    </li>
                    <li>
                      <h3>Waktu dan Tempat Pelaksanaan</h3>
                      <p>Hari     : </p>
                      <p>Tanggal  : </p>
                      <p>Waktu    : </p>
                      <p>Tempat   : </p>
                    </li>
                    <li>
                      <h3>Kendala & Evaluasi</h3>
                      <p>Kendala dan evaluasi mengacu pada analisis terhadap hambatan, tantangan, atau kendala yang dihadapi selama pelaksanaan kegiatan, serta penilaian terhadap hasil, keberhasilan, dan kegagalan kegiatan tersebut.</p>
                    </li>
                    <li>
                      <h3>Susunan Kegiatan</h3>
                      <p><i>(Terlampir I)</i></p>
                    </li>
                    <li>
                      <h3>Susunan Kepanitiaan Kegiatan</h3>
                      <p><i>(Terlampir II)</i></p>
                    </li>
                    <li>
                      <h3>Realisasi Penggunaan Anggaran Biaya</h3>
                      <p><i>(Terlampir III)</i></p>
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
                      <h3 style="text-align: center">REALISASI PENGGUNAAN ANGGARAN BIAYA</h3>
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
              <textarea
                name="latar_belakang"
                id="latar_belakang"
                cols="120"
                rows="10">
                @if($lpj->latar_belakang)
                  {{ $lpj->latar_belakang }}
                @else
                  <p>Latar belakang berisi informasi yang menjelaskan konteks atau latar belakang dari kegiatan yang dilaporkan. </p>
                @endif
              </textarea>

              <h2 class="mt-5">Komentar</h2>
              <textarea 
                name="komentar_latar_belakang"
                id="komentar_latar_belakang"
                cols="120"
                rows="10"
                class="komentar">
                @if($lpj->komentar_latar_belakang)
                  {{ $lpj->komentar_latar_belakang }}
                @endif
              </textarea>
            </div>

            {{-- Nama --}}
            <div class="tab-pane fade" id="nav-nama" role="tabpanel" aria-labelledby="nav-nama-tab">
              <textarea
                name="nama"
                id="nama"
                cols="120"
                rows="10">
                @if($lpj->nama)
                  {{ $lpj->nama }}
                @else
                  <p>Nama kegiatan berisi nama kegiatan atau program yang telah dilaksanakan</p>
                @endif
              </textarea>

              <h2 class="mt-5">Komentar</h2>
              <textarea 
                name="komentar_nama"
                id="komentar_nama"
                cols="120"
                rows="10"
                class="komentar">
                @if($lpj->komentar_nama)
                  {{ $lpj->komentar_nama }}                  
                @endif
              </textarea>
            </div>

            {{-- Tema --}}
            <div class="tab-pane fade" id="nav-tema" role="tabpanel" aria-labelledby="nav-tema-tab">
              <textarea
                name="tema"
                id="tema"
                cols="120"
                rows="10">
                @if($lpj->tema)
                  {{ $lpj->tema }}
                @else
                  <p>Tema kegiatan berisi topik atau fokus utama yang ingin diangkat atau dijelajahi melalui kegiatan yang telah dilaksanakan</p>
                @endif
              </textarea>

              <h2 class="mt-5">Komentar</h2>
              <textarea 
                name="komentar_tema"
                id="komentar_tema"
                cols="120"
                rows="10"
                class="komentar">
                @if($lpj->komentar_tema)
                  {{ $lpj->komentar_tema }}                  
                @endif
              </textarea>
            </div>

            {{-- Tujuan --}}
            <div class="tab-pane fade" id="nav-tujuan" role="tabpanel" aria-labelledby="nav-tujuan-tab">
              <textarea
                name="tujuan"
                id="tujuan"
                cols="120"
                rows="10">
                @if($lpj->tujuan)
                  {{ $lpj->tujuan }}
                @else
                  <p>Tujuan kegiatan berisi tujuan yang ingin dicapai melalui pelaksanaan kegiatan yang telah dilaksanakan</p>
                @endif
              </textarea>

              <h2 class="mt-5">Komentar</h2>
              <textarea 
                name="komentar_tujuan"
                id="komentar_tujuan"
                cols="120"
                rows="10"
                class="komentar">
                @if($lpj->komentar_tujuan)
                  {{ $lpj->komentar_tujuan }}                  
                @endif
              </textarea>
            </div>

            {{-- Sasaran --}}
            <div class="tab-pane fade" id="nav-sasaran" role="tabpanel" aria-labelledby="nav-sasaran-tab">
              <textarea
                name="sasaran"
                id="sasaran"
                cols="120"
                rows="10">
                @if($lpj->sasaran)
                  {{ $lpj->sasaran }}
                @else
                  <p>Sasaran kegiatan berisi kelompok sasaran atau audiens yang akan diuntungkan atau terlibat dalam pelaksanaan kegiatan yang telah dilaksanakan.</p>
                @endif
              </textarea>

              <h2 class="mt-5">Komentar</h2>
              <textarea 
                name="komentar_sasaran"
                id="komentar_sasaran"
                cols="120"
                rows="10"
                class="komentar">
                @if($lpj->komentar_sasaran)
                  {{ $lpj->komentar_sasaran }}                  
                @endif
              </textarea>
            </div>

            {{-- Konsep --}}
            <div class="tab-pane fade" id="nav-konsep" role="tabpanel" aria-labelledby="nav-konsep-tab">
              <textarea
                name="konsep"
                id="konsep"
                cols="120"
                rows="10">
                @if($lpj->konsep)
                  {{ $lpj->konsep }}
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
                class="komentar">
                @if($lpj->komentar_konsep)
                  {{ $lpj->komentar_konsep }}                  
                @endif
              </textarea>
            </div>

            {{-- Waktu dan Tempat --}}
            <div class="tab-pane fade" id="nav-waktu" role="tabpanel" aria-labelledby="nav-waktu-tab">
              <textarea
                name="waktu"
                id="waktu"
                cols="120"
                rows="10">
                @if($lpj->waktu)
                  {{ $lpj->waktu }}
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
                class="komentar">
                @if($lpj->komentar_waktu)
                  {{ $lpj->komentar_waktu }}                  
                @endif
              </textarea>
            </div>

            {{-- Kendala & Evaluasi --}}
            <div class="tab-pane fade" id="nav-kendala" role="tabpanel" aria-labelledby="nav-kendala-tab">
              <textarea
                name="kendala"
                id="kendala"
                cols="120"
                rows="10">
                @if($lpj->kendala)
                  {{ $lpj->kendala }}
                @else
                  <p>Kendala dan evaluasi mengacu pada analisis terhadap hambatan, tantangan, atau kendala yang dihadapi selama pelaksanaan kegiatan, serta penilaian terhadap hasil, keberhasilan, dan kegagalan kegiatan tersebut.</p>
                @endif
              </textarea>

              <h2 class="mt-5">Komentar</h2>
              <textarea 
                name="komentar_kendala"
                id="komentar_kendala"
                cols="120"
                rows="10"
                class="komentar">
                @if($lpj->komentar_kendala)
                  {{ $lpj->komentar_kendala }}                  
                @endif
              </textarea>
            </div>

            {{-- Susunan Kegiatan --}}
            <div class="tab-pane fade" id="nav-kegiatan" role="tabpanel" aria-labelledby="nav-kegiatan-tab">
              <textarea
                name="susunan_kegiatan"
                id="susunan_kegiatan"
                cols="120"
                rows="10">
                @if($lpj->susunan_kegiatan)
                  {{ $lpj->susunan_kegiatan }}
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
                class="komentar">
                @if($lpj->komentar_susunan_kegiatan)
                  {{ $lpj->komentar_susunan_kegiatan }}                  
                @endif
              </textarea>
            </div>

            {{-- Susunan Kepanitiaan --}}
            <div class="tab-pane fade" id="nav-kepanitiaan" role="tabpanel" aria-labelledby="nav-kepanitiaan-tab">
              <textarea
                name="susunan_kepanitiaan"
                id="susunan_kepanitiaan"
                cols="120"
                rows="10">
                @if($lpj->susunan_kepanitiaan)
                  {{ $lpj->susunan_kepanitiaan }}
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
                class="komentar">
                @if($lpj->komentar_susunan_kepanitiaan)
                  {{ $lpj->komentar_susunan_kepanitiaan }}                  
                @endif
              </textarea>
            </div>

            {{-- Realisasi RAB --}}
            <div class="tab-pane fade" id="nav-rab" role="tabpanel" aria-labelledby="nav-rab-tab">
              <textarea
                name="rab"
                id="rab"
                cols="120"
                rows="10">
                @if($lpj->rab)
                  {{ $lpj->rab }}
                @else
                  <i>Lampiran III</i>
                  <h3 style="text-align: center">REALISASI PENGGUNAAN ANGGARAN BIAYA</h3>
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
                class="komentar">
                @if($lpj->komentar_rab)
                  {{ $lpj->komentar_rab }}                  
                @endif
              </textarea>
            </div>

            {{-- Penutup --}}
            <div class="tab-pane fade" id="nav-penutup" role="tabpanel" aria-labelledby="nav-penutup-tab">
              <textarea name="penutup" id="penutup" cols="80" rows="10">
              @if($lpj->penutup)
                {{ $lpj->penutup }}
              @else
                <h3 style="text-align: center">PENUTUP</h3>
                <p style="padding-left: 80px;">Penutup berisi rangkuman singkat dari keseluruhan laporan, evaluasi terhadap kegiatan yang dilaporkan, ucapan terima kasih, dan harapan ke depan.</p>
              @endif
              </textarea>
              <h2 class="mt-5">Komentar</h2>
              <textarea 
                name="komentar_penutup"
                id="komentar_penutup"
                cols="120"
                rows="10"
                class="komentar">
                @if($lpj->komentar_penutup)
                  {{ $lpj->komentar_penutup }}                  
                @endif
              </textarea>
            </div>

            {{-- Bukti Transaksi --}}
            <div class="tab-pane fade" id="nav-bukti" role="tabpanel" aria-labelledby="nav-bukti-tab">
              <textarea name="bukti_transaksi" id="bukti" cols="80" rows="10" class="image">
              @if($lpj->bukti_transaksi)
                {{ $lpj->bukti_transaksi }}
              @else
                <h3 style="text-align: center">BUKTI TRANSAKSI</h3>
              @endif
              </textarea>

              <h2 class="mt-5">Komentar</h2>
              <textarea 
                name="komentar_bukti_transaksi"
                id="komentar_bukti_transaksi"
                cols="120"
                rows="10"
                class="komentar">
                @if($lpj->komentar_bukti_transaksi)
                  {{ $lpj->komentar_bukti_transaksi }}                  
                @endif
              </textarea>
            </div>

            {{-- Dokumentasi --}}
            <div class="tab-pane fade" id="nav-dokumentasi" role="tabpanel" aria-labelledby="nav-dokumentasi-tab">
              <textarea name="dokumentasi" id="dokumentasi" cols="80" rows="10" class="image">
              @if($lpj->dokumentasi)
                {{ $lpj->dokumentasi }}
              @else
                <h3 style="text-align: center">DOKUMENTASI</h3>
              @endif
              </textarea>

              <h2 class="mt-5">Komentar</h2>
              <textarea 
                name="komentar_dokumentasi"
                id="komentar_dokumentasi"
                cols="120"
                rows="10"
                class="komentar">
                @if($lpj->komentar_dokumentasi)
                  {{ $lpj->komentar_dokumentasi }}                  
                @endif
              </textarea>
            </div>

          </div>

          <input type="hidden" name="lpj_id" value="{{ $lpj->id }}">
          <input type="hidden" name="tipe" id="tipeBtn" value="">


          @if(auth()->user()->role() == 'sekretaris_proker')
            <button type="submit" class="btn btn-primary mt-3" id="btnSimpan">Simpan</button>
            <button type="submit" class="btn btn-primary mt-3" id="btnAjukan">Ajukan</button>
          @elseif(auth()->user()->role() == 'pembina')
            <button type="submit" class="btn btn-primary mt-3">Beri Komentar</button>
          @endif
          <a href="{{ route('lpj.index') }}" class="btn btn-light mt-3">Batal</a>

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
      selector: '.image',
      height: 1000,
      plugins: 'anchor autolink charmap codesample emoticons image link lists searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
      images_file_types: 'jpg,svg,webp,png',
      file_picker_types: 'file image media',
      mergetags_list: [
        { value: 'First.Name', title: 'First Name' },
        { value: 'Email', title: 'Email' },
      ],
      image_title: true,
      automatic_uploads: true,
      images_upload_url: '/upload/lpj',
      file_picker_types: 'image',
      file_picker_callback: function(cb, value, meta) {
          var input = document.createElement('input');
          input.setAttribute('type', 'file');
          input.setAttribute('accept', 'image/*');
          input.onchange = function() {
              var file = this.files[0];

              var reader = new FileReader();
              reader.readAsDataURL(file);
              reader.onload = function () {
                  var id = 'blobid' + (new Date()).getTime();
                  var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                  var base64 = reader.result.split(',')[1];
                  var blobInfo = blobCache.create(id, file, base64);
                  blobCache.add(blobInfo);
                  cb(blobInfo.blobUri(), { title: file.name });
              };
          };
          input.click();
      },
    });

    tinymce.init({
      selector: 'textarea',
      height: 1000,
      plugins: 'anchor autolink charmap codesample emoticons link lists searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
      mergetags_list: [
        { value: 'First.Name', title: 'First Name' },
        { value: 'Email', title: 'Email' },
      ],
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

    $('ul').find('li:contains("Laporan")').addClass('active');

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
