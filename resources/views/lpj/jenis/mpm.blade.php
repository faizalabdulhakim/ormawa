<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ $lpj->judul }}</title>
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
    <img src="{{ public_path('storage\\' . $lpj->cover) }}" alt="Cover Image">
  </div>

  <div class="content">
    <h3 style="text-align: center; margin-bottom: 10px;">LEMBAR PENGESAHAN <br> {{ strtoupper($lpj->proker->nama) }}</h3>
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
            Sekretaris Proker,<br>
            <br>
            <br>
            <br>
            <br>
            <span class="nama">{{ $sekpro->nama }}</span><br>
            <span class="nim">{{ $sekpro->nim }}</span><br>
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

  <section class="page-break">
    {!! $lpj->kata_pengantar !!}
  </section>

  <div style="page-break-before: always;"></div>

  <section class="page-break">
    <div>
      <h3 style="text-align: center">PENDAHULUAN</h3>
      <ol type="A" style="padding-left: 80px;">
        <li>
          <h3>Latar Belakang</h3>
          {!! $lpj->latar_belakang !!}
        </li>
        <li>
          <h3>Nama Kegiatan</h3>
          {!! $lpj->nama !!}
        </li>
        <li>
          <h3>Tema Kegiatan</h3>
          {!! $lpj->tema !!}
        </li>
        <li>
          <h3>Tujuan</h3>
          {!! $lpj->tujuan !!}
        </li>
        <li>
          <h3>Sasaran</h3>
          {!! $lpj->sasaran !!}
        </li>
        <li>
          <h3>Waktu dan Tempat Pelaksanaan</h3>
          {!! $lpj->waktu !!}
        </li>
        <li>
          <h3>Kendala & Evaluasi</h3>
          {!! $lpj->kendala !!}
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
        <li>
          <h3>Bukti Transaksi</h3>
          <p><i>(Terlampir IV)</i></p>
        </li>
        <li>
          <h3>Dokumentasi</h3>
          <p><i>(Terlampir V)</i></p>
        </li>
      </ol>
      <div style="page-break-before: always;"></div>

      <ul>
        <li>
          {!! $lpj->susunan_kegiatan !!}
        </li>

        <div style="page-break-before: always;"></div>

        <li>
          {!! $lpj->susunan_kepanitiaan !!}
        </li>

        <div style="page-break-before: always;"></div>

        <li>
          {!! $lpj->rab !!}
        </li>

        <div style="page-break-before: always;"></div>

        <li>
          <i>Lampiran IV</i>
          <h3 style="text-align: center;">BUKTI TRANSAKSI</h3>

          <div style="padding-left: 80px;">
            @foreach ($buktis as $bukti)
              <img src="{{ public_path('storage\\' . $bukti) }}" alt="bukti" width="auto" height="400"> <br>
            @endforeach
          </div>

        </li>

        <div style="page-break-before: always;"></div>

        <li>
          <i>Lampiran V</i>
          <h3 style="text-align: center;">DOKUMENTASI</h3>

          <div style="padding-left: 80px;">
            @foreach ($dokumentasis as $dokumentasi)
              <img src="{{ public_path('storage\\' . $dokumentasi) }}" alt="dokumentasi" width="auto" height="400"> <br>
            @endforeach
          </div>
        </li>

      </ul>
    </div>
  </section>

  <div style="page-break-before: always;"></div>

  <section class="page-break">
    {!! $lpj->penutup !!}
  </section>

</body>

</html>
