<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upravljanje novinarima</title>
</head>
<body>
    @include('navbar')
    @foreach ($novinari as $novinar)
        Ime:{{$novinar['name']}}
        Rubrika:{{$novinar['name']}}
    @endforeach
</body>
</html>