<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" value="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    @include('mahasiswa.layouts._css')
</head>

<body>
    <div id="mahasiswa">
    </div>

    @include('mahasiswa.layouts._js')
</body>

</html>
