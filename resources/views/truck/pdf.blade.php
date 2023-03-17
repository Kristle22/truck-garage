<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ ucfirst($truck->maker) }}-{{ $truck->make_year }}</title>
    <style>
        @font-face {
            font-family: 'Roboto Slab';
            src: url({{ asset('fonts/RobotoSlab-Regular.ttf') }});
            font-weight: normal;
        }

        @font-face {
            font-family: 'Roboto Slab';
            src: url({{ asset('fonts/RobotoSlab-Bold.ttf') }});
            font-weight: bold;
        }

        body {
            font-family: 'Roboto Slab';
        }

        div {
            margin: 7px;
            padding: 7px;
        }

        .main {
            font-size: 18px;
        }

        .about {
            font-size: 11px;
            color: gray;
        }

        .img img {
            height: 200px;
            width: auto;
        }
    </style>

</head>

<body>
    <h1>{{ $truck->maker }}</h1>
    <div class="img">
        @if ($truck->photo)
            <img src="{{ $truck->photo }}" alt="{{ $truck->maker }}">
        @else
            <img src="{{ asset('img/no-img.png') }}" alt="{{ $truck->maker }}">
        @endif
    </div>
    <div class="main">Mechanic: {{ $truck->getMechanic->name }} {{ $truck->getMechanic->surname }}</div>
    <div class="basic">Plate: <b>{{ $truck->plate }}</b> Make Year: <b>{{ $truck->make_year }}</b></div>
    <div class="about">{!! $truck->mechanic_notices !!}</div>

</body>

</html>
