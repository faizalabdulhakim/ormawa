<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Proposal</title>
  <style>

    @page {
      size: A4;
      margin: 0;
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

    section {
      padding: 1cm;
    }

    section img {
      width: 300px;
      height: 300px;
      object-fit: cover;
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

  <section>
    {!! $proposal->content !!}
  </section>

</body>

</html>