@extends('layouts.main')

@section('title')
    Si Ormawa - LPJ Akhir Ormawa
@endsection

@section('content')
<div class="row">
  
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">

        {{-- Header --}}
        <div class="row justify-content-between align-items-center mx-1 mb-5">
          <div>
            <h2>LPJ Akhir {{ $ormawa->nama }} - {{ $ormawa->angkatan }}</h2>
          </div>

          <a href="{{ route('ormawa.index') }}" class="btn btn-primary items-center"id="btnKembali">
            <i class="mdi mdi-arrow-left"></i>
            Kembali
          </a>
        </div>

        @if (session()->has('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
        @endif

        @if (session()->has('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
        @endif

        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-cover-tab" data-toggle="tab" data-target="#nav-cover" type="button" role="tab" aria-controls="nav-cover" aria-selected="true">Cover</button>
            @if($ormawa->jenis == "HMJ")
            <button class="nav-link" id="nav-pengesahan-tab" data-toggle="tab" data-target="#nav-pengesahan" type="button" role="tab" aria-controls="nav-pengesahan" aria-selected="false">Lembar Pengesahan</button>
            @endif
            <button class="nav-link" id="nav-pengantar-tab" data-toggle="tab" data-target="#nav-pengantar" type="button" role="tab" aria-controls="nav-pengantar" aria-selected="false">Kata Pengantar</button>
            <button class="nav-link" id="nav-bab1-tab" data-toggle="tab" data-target="#nav-bab1" type="button" role="tab" aria-controls="nav-bab1" aria-selected="false">Bab 1</button>
            <button class="nav-link" id="nav-bab2-tab" data-toggle="tab" data-target="#nav-bab2" type="button" role="tab" aria-controls="nav-bab2" aria-selected="false">Bab 2</button>
            <button class="nav-link" id="nav-admin-tab" data-toggle="tab" data-target="#nav-admin" type="button" role="tab" aria-controls="nav-admin" aria-selected="false">Laporan Administrasi</button>
            <button class="nav-link" id="nav-keuangan-tab" data-toggle="tab" data-target="#nav-keuangan" type="button" role="tab" aria-controls="nav-keuangan" aria-selected="false">Laporan Keuangan</button>
            <button class="nav-link" id="nav-bab3-tab" data-toggle="tab" data-target="#nav-bab3" type="button" role="tab" aria-controls="nav-bab3" aria-selected="false">Bab 3</button>
            <button class="nav-link" id="nav-bukti-tab" data-toggle="tab" data-target="#nav-bukti" type="button" role="tab" aria-controls="nav-bukti" aria-selected="false">Bukti Transaksi</button>
            <button class="nav-link" id="nav-dokumentasi-tab" data-toggle="tab" data-target="#nav-dokumentasi" type="button" role="tab" aria-controls="nav-dokumentasi" aria-selected="false">Dokumentasi</button>
          </div>
        </nav>

        <form action="{{ route('ormawa.create.lpj', ['id' => $ormawa->id]) }}" method="post" enctype="multipart/form-data">
          @csrf
          @method('PATCH')
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
                        @if($ormawa->cover)
                          <img id="cover-img" src="{{  asset('storage/' . $ormawa->cover)  }}" class="img-fluid img-thumbnail img-preview" style="width: 200px; height: 200px;">
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
                      <img id="cover-img" src="{{ asset('images/cover/cover-lpj-akhir.jpg') }}" class="img-fluid img-thumbnail" style="width: 300px; height: 400px;">
                      <p class="muted-text">
                        *Konten yang berada dicontoh cover wajib untuk dicantumkan <br>
                        *Penempatan konten bersifat opsional sesuai dengan kebutuhan
                      </p>
                    </div>
                  </div>
                </div>         

            </div>

            {{-- Lembar Pengesahan --}}
            @if($ormawa->jenis == "HMJ")
            <div class="tab-pane fade" id="nav-pengesahan" role="tabpanel" aria-labelledby="nav-pengesahan-tab">

                <div class="row">
                  <div class="col-6">
                    <div class="form-group row">
                      <label for="ketua_jurusan" class="col-sm-3 col-form-label">Ketua Jurusan</label>
                      <div class="col-sm-9">
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="ketua_jurusan" id="ketua_jurusan" placeholder="Ketua Jurusan" required autocomplete="off"
                          @if($ormawa->ketua_jurusan)
                            value="{{ $ormawa->ketua_jurusan }}"
                          @endif>
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
                          @if($ormawa->nip_ketua_jurusan)
                            value="{{ $ormawa->nip_ketua_jurusan }}"
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
                
                
              </div>
              @endif

            {{-- Kata Pengantar --}}
            <div class="tab-pane fade" id="nav-pengantar" role="tabpanel" aria-labelledby="nav-pengantar-tab">
              <textarea name="kata_pengantar" id="kata_pengantar" cols="80" rows="10"
                @if ($ormawa->kata_pengantar)
                  value="{{ $ormawa->kata_pengantar }}"
                @endif
                >
                @if ($ormawa->kata_pengantar)
                  {{ $ormawa->kata_pengantar }}
                @else
                  <h3 style="text-align: center">KATA PENGANTAR</h3>
                  <p style="padding-left: 80px;"><< content >></p>
                @endif
                  
              </textarea>
            </div>

            {{-- Bab 1 --}}
            <div class="tab-pane fade" id="nav-bab1" role="tabpanel" aria-labelledby="nav-bab1-tab">
              <textarea name="bab1" id="bab1" cols="150" rows="10"
                @if ($ormawa->bab1)
                  value="{{ $ormawa->bab1 }}"
                @endif
              >
                @if ($ormawa->bab1)
                  {{ $ormawa->bab1 }}
                @else
                  <h3 style="text-align: center">BAB I <br> PENDAHULUAN</h3>
                  <ol type="A" style="padding-left: 80px;">
                    <li>
                      <h4>Latar Belakang</h4>
                      <p><< content >></p>
                    </li>
                    <li>
                      <h4>Visi dan Misi</h4>
                      <p><< content >></p>
                    </li>
                    <li>
                      <h4>Struktur Kepengurusan</h4>
                      <p><< content >></p>
                    </li>
                  </ol>
                @endif
                
              </textarea>
            </div>

            {{-- Bab 2 --}}
            <div class="tab-pane fade" id="nav-bab2" role="tabpanel" aria-labelledby="nav-bab2-tab">
              <textarea name="bab2" id="bab2" cols="500" rows="10"
                @if ($ormawa->bab2)
                  value="{{ $ormawa->bab2 }}"
                @endif
              >
                @if ($ormawa->bab2)
                  {{ $ormawa->bab2 }}
                @else
                  <h3 style="text-align: center;">BAB II <br>LAPORAN PERTANGGUNGJAWABAN <br>PROGRAM KERJA</h3>

                  <ul style="padding-left: 80px;">
                    <li>
                      <table style="border-collapse: collapse; width: 99.9818%; height: 160px;" border="1"><colgroup><col style="width: 5.28143%;"><col style="width: 47.3507%;"><col style="width: 47.3507%;"></colgroup>
                        <tbody>
                        <tr style="height: 92.8px;">
                        <td style="height: 92.8px; text-align: left;">No</td>
                        <td style="height: 92.8px; text-align: left;" colspan="2">
                        <p>Nama Proker :</p>
                        <p>Nama Kegiatan :</p>
                        </td>
                        </tr>
                        <tr style="height: 22.4px;">
                        <td style="height: 22.4px; text-align: left;" rowspan="9">1.</td>
                        <td style="height: 22.4px; text-align: left;">Penanggung Jawab</td>
                        <td style="text-align: left;">
                        <p>Nama :</p>
                        <p>NIM :</p>
                        <p>Jabatan :</p>
                        </td>
                        </tr>
                        <tr style="height: 22.4px;">
                        <td style="height: 22.4px; text-align: left;">Latar Belakang</td>
                        <td style="text-align: left;">&nbsp;</td>
                        </tr>
                        <tr style="height: 22.4px;">
                        <td style="height: 22.4px; text-align: left;">Waktu dan Tempat Pelaksanaan</td>
                        <td style="text-align: left;">
                        <p>Hari :</p>
                        <p>Waktu :&nbsp;</p>
                        <p>Tempat :</p>
                        </td>
                        </tr>
                        <tr>
                        <td style="text-align: left;">Sasaran</td>
                        <td style="text-align: left;">
                        <p>&nbsp;</p>
                        </td>
                        </tr>
                        <tr>
                        <td style="text-align: left;">Indikator Keberhasilan</td>
                        <td style="text-align: left;">
                        <p>&nbsp;</p>
                        </td>
                        </tr>
                        <tr>
                        <td style="text-align: left;">Anggaran</td>
                        <td style="text-align: left;">
                        <p>&nbsp;</p>
                        </td>
                        </tr>
                        <tr>
                        <td style="text-align: left;">Kendala/Hambatan</td>
                        <td style="text-align: left;">
                        <p>&nbsp;</p>
                        </td>
                        </tr>
                        <tr>
                        <td style="text-align: left;">Solusi</td>
                        <td style="text-align: left;">
                        <p>&nbsp;</p>
                        </td>
                        </tr>
                        <tr>
                        <td style="text-align: left;">Pencapaian</td>
                        <td style="text-align: left;">
                        <p>&nbsp;</p>
                        </td>
                        </tr>
                        </tbody>
                      </table>
                    </li>
                    <p>&nbsp;</p>
                    <li>
                      <table style="border-collapse: collapse; width: 99.9818%;" border="1"><colgroup><col style="width: 5.19037%;"><col style="width: 44.35%;"><col style="width: 50.4426%;"></colgroup>
                        <tbody>
                        <tr>
                        <td style="text-align: center;" colspan="3"><strong>Program Kerja Tidak Terlaksana</strong></td>
                        </tr>
                        <tr>
                        <td style="text-align: center;"><strong>No.</strong></td>
                        <td style="text-align: center;"><strong>Nama Kegitan</strong></td>
                        <td style="text-align: center;"><strong>Keterangan</strong></td>
                        </tr>
                        <tr>
                        <td style="text-align: center;"><strong>&nbsp;</strong></td>
                        <td style="text-align: center;"><strong>&nbsp;</strong></td>
                        <td style="text-align: center;"><strong>&nbsp;</strong></td>
                        </tr>
                        <tr>
                        <td style="text-align: center;"><strong>&nbsp;</strong></td>
                        <td style="text-align: center;"><strong>&nbsp;</strong></td>
                        <td style="text-align: center;"><strong>&nbsp;</strong></td>
                        </tr>
                        </tbody>
                      </table>
                    </li>
                  </ul>


                @endif
              </textarea>
            </div>

            {{-- Laporan Administrasi --}}
            <div class="tab-pane fade" id="nav-admin" role="tabpanel" aria-labelledby="nav-admin-tab">
              <textarea name="laporan_admin" id="laporan_admin" cols="60" rows="10"
                @if ($ormawa->laporan_admin)
                  value="{{ $ormawa->laporan_admin }}"
                @endif
              >
                @if ($ormawa->laporan_admin)
                  {{ $ormawa->laporan_admin }}
                @else
                  <h3 style="text-align: center;">LAPORAN ADMINISTRASI</h3>
                  <ol style="padding-left: 80px;" type="A">
                    <li>
                    <h4>Surat Keluar</h4>
                    <table style="border-collapse: collapse; width: 99.9804%;" border="1"><colgroup><col style="width: 25.0245%;"><col style="width: 25.0245%;"><col style="width: 25.0245%;"><col style="width: 25.0245%;"></colgroup>
                      <tbody>
                      <tr>
                      <td style="text-align: center;"><strong>No.</strong></td>
                      <td style="text-align: center;"><strong>Nomor Surat</strong></td>
                      <td style="text-align: center;"><strong>Perihal</strong></td>
                      <td style="text-align: center;"><strong>Tujuan</strong></td>
                      </tr>
                      <tr>
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
                      </tr>
                      </tbody>
                    </table>
                    <p>&nbsp;</p>
                    <table style="border-collapse: collapse; width: 99.9804%;" border="1"><colgroup><col style="width: 49.9902%;"><col style="width: 49.9902%;"></colgroup>
                      <tbody>
                      <tr>
                      <td style="text-align: center;" colspan="2"><strong>Akumulasi Surat Keluar</strong></td>
                      </tr>
                      <tr>
                      <td style="text-align: center;"><strong>Nama Surat</strong></td>
                      <td style="text-align: center;"><strong>Jumlah</strong></td>
                      </tr>
                      <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                      <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                      <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                      <tr>
                      <td style="text-align: center;"><strong>Total</strong></td>
                      <td>&nbsp;</td>
                      </tr>
                      </tbody>
                    </table>
                    </li>
                    <li>
                    <h4>Surat Masuk</h4>
                    <table style="border-collapse: collapse; width: 99.9804%;" border="1"><colgroup><col style="width: 25.0245%;"><col style="width: 25.0245%;"><col style="width: 25.0245%;"><col style="width: 25.0245%;"></colgroup>
                      <tbody>
                      <tr>
                      <td style="text-align: center;"><strong>No.</strong></td>
                      <td style="text-align: center;"><strong>Nomor Surat</strong></td>
                      <td style="text-align: center;"><strong>Perihal</strong></td>
                      <td style="text-align: center;"><strong>Asal Surat</strong></td>
                      </tr>
                      <tr>
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
                      </tr>
                      </tbody>
                    </table>
                    <p>&nbsp;</p>
                    <table style="border-collapse: collapse; width: 99.9804%;" border="1"><colgroup><col style="width: 49.9902%;"><col style="width: 49.9902%;"></colgroup>
                      <tbody>
                      <tr>
                      <td style="text-align: center;" colspan="2"><strong>Akumulasi Surat Masuk</strong></td>
                      </tr>
                      <tr>
                      <td style="text-align: center;"><strong>Nama Surat</strong></td>
                      <td style="text-align: center;"><strong>Jumlah</strong></td>
                      </tr>
                      <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                      <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                      <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                      <tr>
                      <td style="text-align: center;"><strong>Total</strong></td>
                      <td>&nbsp;</td>
                      </tr>
                      </tbody>
                    </table>
                    </li>
                  </ol>
                @endif
              </textarea>
              
            </div>

            {{-- Laporan Keuangan --}}
            <div class="tab-pane fade" id="nav-keuangan" role="tabpanel" aria-labelledby="nav-keuangan-tab">
              <textarea name="laporan_keuangan" id="laporan_keuangan" cols="60" rows="10"
                @if ($ormawa->laporan_keuangan)
                  value="{{ $ormawa->laporan_keuangan }}"
                @endif
              >
                @if ($ormawa->laporan_keuangan)
                  {{ $ormawa->laporan_keuangan }}
                @else
                  <h3 style="text-align: center;">LAPORAN ADMINISTRASI</h3>
                  <ul>
                    <li>
                    <h4>Laporan Uang Masuk dan Keluar Periode Bulan Januari - Desember</h4>
                    <table style="border-collapse: collapse; width: 99.9811%;" border="1"><colgroup><col style="width: 14.2587%;"><col style="width: 14.2587%;"><col style="width: 14.2587%;"><col style="width: 14.2587%;"><col style="width: 14.2587%;"><col style="width: 14.2587%;"><col style="width: 14.2587%;"></colgroup>
                      <tbody>
                      <tr>
                      <td>No.</td>
                      <td>Tanggal</td>
                      <td>Nama Kegiatan</td>
                      <td>Keterangan</td>
                      <td>Debit (Rp)</td>
                      <td>Kredit (Rp)</td>
                      <td>Saldo (Rp)</td>
                      </tr>
                      <tr>
                      <td>&nbsp;</td>
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
                      <td>&nbsp;</td>
                      </tr>
                      <tr>
                      <td>&nbsp;</td>
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
                      <td>&nbsp;</td>
                      </tr>
                      </tbody>
                    </table>
                    </li>
                  </ul>
                  
                @endif
              </textarea>
            </div>

            {{-- Bab 3 --}} 
            <div class="tab-pane fade" id="nav-bab3" role="tabpanel" aria-labelledby="nav-bab3-tab">
              <textarea name="bab3" id="bab3" cols="60" rows="10"
                @if ($ormawa->bab3)
                  value="{{ $ormawa->bab3 }}"
                @endif
              >
                @if ($ormawa->bab3)
                  {{ $ormawa->bab3 }}
                @else
                  <h3 style="text-align: center">BAB III <br> PENUTUP</h3>
                  <p style="padding-left: 80px;"><< content >></p>
                @endif
              </textarea>
            </div>

            {{-- Bukti Transaksi --}}
            <div class="tab-pane fade" id="nav-bukti" role="tabpanel" aria-labelledby="nav-bukti-tab">
              <textarea name="bukti_transaksi" id="bukti" cols="80" rows="10" class="image">
              @if($ormawa->bukti_transaksi)
                {{ $ormawa->bukti_transaksi }}
              @else
                <h3 style="text-align: center">BUKTI TRANSAKSI</h3>
              @endif
              </textarea>
            </div>

            {{-- Dokumentasi --}}
            <div class="tab-pane fade" id="nav-dokumentasi" role="tabpanel" aria-labelledby="nav-dokumentasi-tab">
              <textarea name="dokumentasi" id="dokumentasi" cols="80" rows="10" class="image">
              @if($ormawa->dokumentasi)
                {{ $ormawa->dokumentasi }}
              @else
                <h3 style="text-align: center">DOKUMENTASI</h3>
              @endif
              </textarea>
            </div>

          </div>

          <div class="row mt-3">
            <div class="col-12">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <a href="{{ route('ormawa.index') }}" class="btn btn-light">Batal</a>
            </div>
          </div>
        </form>
        
      </div>
    </div>
  </div>
</div>

<script>

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

<script>
  setTimeout(function() {
    $('.nav-item.active').removeClass('active');
  
    $('ul').find('li:contains("Ormawa")').addClass('active');

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
