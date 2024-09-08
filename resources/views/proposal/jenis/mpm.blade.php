<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ $proposal->judul }}</title>
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
    <img src="{{ public_path('storage\\' . $proposal->cover) }}" alt="Cover Image">
  </div>  

  <div class="content">
    <h3 style="text-align: center; margin-bottom: 10px;">LEMBAR PENGESAHAN <br> {{ strtoupper($proposal->proker->nama) }}</h3>
    <br>
    <br>
    <br>
    <table>
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
            Ketua Pelaksana,<br>
            <br>
            <br>
            <br>
            <br>
            <span class="nama">{{ $proposal->ketua_pelaksana }}</span><br>
            <span class="nim">{{ $proposal->nim_ketua_pelaksana }}</span><br>
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
    <div>
      <ol type="A">
        <li>
          <h3>Latar Belakang Kegiatan</h3>
          {!! $proposal->latar_belakang !!}
        </li>
        <li>
          <h3>Nama Kegiatan</h3>
          {!! $proposal->nama !!}
        </li>
        <li>
          <h3>Tema Kegiatan</h3>
          {!! $proposal->tema !!}
        </li>
        <li>
          <h3>Tujuan Kegiatan</h3>
          {!! $proposal->tujuan !!}
        </li>
        <li>
          <h3>Target</h3>
          {!! $proposal->target !!}
        </li>
        <li>
          <h3>Konsep</h3>
          {!! $proposal->konsep !!}
        </li>
        <li>
          <h3>Waktu dan Tempat Pelaksanaan</h3>
          {!! $proposal->waktu !!}
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
          {!! $proposal->penutup !!}
        </li>
      </ol>
      
      <div style="page-break-before: always;"></div>

      <ul>
        <li>
          {!! $proposal->susunan_kegiatan !!}
        </li>

        <div style="page-break-before: always;"></div>

        <li>
          {!! $proposal->susunan_kepanitiaan !!}
        </li>

        <div style="page-break-before: always;"></div>

        <li>
          {!! $proposal->rab !!}
        </li>
      </ul>
    </div>
  </section>
  
</body>

</html>