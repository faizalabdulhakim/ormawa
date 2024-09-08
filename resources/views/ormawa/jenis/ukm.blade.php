<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>LPJ Akhir UKM</title>
  <style>

    @page {
      size: A4;
      margin: 1cm;
    }

    body {
      margin: 0;
      padding: 0;
    }

    .cover img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    section img {
      width: 300px;
      height: 300px;
      object-fit: cover;
    }

    .content {
      width: 100%;
      height: 100%;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    td {
      text-align: center;
    }

    .signature {
      vertical-align: middle;
    }

    hr.border {
      border-bottom: 1px solid black;
      border-radius: 0px;
    }
    
    .nama{
      font-weight: bold;
      border-bottom: 1px solid black;
    }

    .nim{
      font-weight: bold;
    }

    .page_break { 
      page-break-before: always; 
    }

  </style>
</head>

<body>
  <div class="cover">
    <img src="{{ public_path('storage\\' . $ormawa->cover) }}" alt="Cover Image">
  </div>  

  <div class="content">
    <h3 style="text-align: center; margin-bottom: 10px;">LEMBAR PENGESAHAN <br> {{ strtoupper($ormawa->nama) }}</h3>
    <br>
    <br>
    <br>
    <table>
      <tr>
        <td style="width: 50%;">
          <div class="signature">
            Ketua {{ $ormawa->nama }},<br>
            <br>
            <br>
            <br>
            <br>
            <span class="nama">{{ $ormawa->ketua->nama }}</span><br>
            <span class="nim">{{ $ormawa->ketua->nim }}</span><br>
          </div>
        </td>
        <td style="width: 50%;">
          <div class="signature">
            Sekretaris Umum,<br>
            <br>
            <br>
            <br>
            <br>
            <span class="nama">{{ $sekum->nama }}</span><br>
            <span class="nim">{{ $sekum->nim }}</span><br>
          </div>
        </td>
      </tr>
      <br>
      <br>
      <br>
      <tr>
        <td colspan="2" style="text-align: center;">
          Mengetahui,
        </td>
      </tr>
      <br>
      <br>
      <br>
      <tr>
        <td style="width: 50%;">
          <div class="signature">
            Ketua MPM-KEMA POLSUB,<br>
            <br>
            <br>
            <br>
            <br>
            <span class="nama">{{ $ketua_mpm->nama }}</span><br>
            <span class="nim">{{ $ketua_mpm->nim }}</span><br>
          </div>
        </td>
        <td style="width: 50%;">
          <div class="signature">
            Ketua BEM-KEMA POLSUB,<br>
            <br>
            <br>
            <br>
            <br>
            <span class="nama">{{ $ketua_bem->nama }}</span><br>
            <span class="nim">{{ $ketua_bem->nim }}</span><br>
          </div>
        </td>
      </tr>
      <br>
      <br>
      <tr>
        <td colspan="2">
          <div class="signature">
            Pembina {{ $ormawa->nama }},<br>
            <br>
            <br>
            <br>
            <br>
            <span class="nama">{{ $ormawa->pembina->nama }}</span><br>
            <span class="nim">{{ $ormawa->pembina->nim }}</span><br>
          </div>
        </td>
      </tr>
      <br>
      <br>
      <br>
      <tr>
        <td colspan="2" style="text-align: center;">
          Menyetujui,
        </td>
      </tr>
      <br>
      <br>
      <br>
      <tr>
        <td colspan="2">
          <div class="signature">
            Wakil Direktur 1 <br> Bidang Akademik dan Kemahasiswaan,<br>
            <br>
            <br>
            <br>
            <br>
            <span class="nama">{{ $wadir->nama }}</span><br>
            <span class="nim">{{ $wadir->nim }}</span><br>
          </div>
        </td>
      </tr>
    </table>
  </div>

  <section>
    {!! $ormawa->kata_pengantar !!}
  </section>

  <div style="page-break-before: always;"></div>

  <section>
    {!! $ormawa->bab1 !!}
  </section>

  <div style="page-break-before: always;"></div>

  <section class="page-break">
    {!! $ormawa->bab2 !!}
  </section>

  <div style="page-break-before: always;"></div>

  <section class="page-break">
    {!! $ormawa->laporan_admin !!}
  </section>

  <div style="page-break-before: always;"></div>

  <section class="page-break">
    {!! $ormawa->laporan_keuangan !!}
  </section>

  <div style="page-break-before: always;"></div>

  <section class="page-break">
    <h3 style="text-align: center;">LAMPIRAN</h3>
    <h3 style="text-align: center;">BUKTI TRANSAKSI</h3>

    <div style="padding-left: 80px;">
      @foreach ($buktis as $bukti)
        <img src="{{ public_path('storage\\' . $bukti) }}" alt="bukti" width="auto" height="400"> <br>
      @endforeach
    </div>
  </section>

  <div style="page-break-before: always;"></div>

  <section class="page-break">
    <h3 style="text-align: center;">LAMPIRAN</h3>
    <h3 style="text-align: center;">DOKUMENTASI KEGIATAN</h3>

    <div style="padding-left: 80px;">
      @foreach ($dokumentasis as $dokumentasi)
        <img src="{{ public_path('storage\\' . $dokumentasi) }}" alt="dokumentasi" width="auto" height="400"> <br>
      @endforeach
    </div>
  </section>

  <div style="page-break-before: always;"></div>

  <section class="page-break">
    {!! $ormawa->bab3 !!}
  </section>
  
</body>

</html>