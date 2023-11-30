
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pocetna</title>
</head>
<body>
@include('navbar')
@auth
    <p>cao</p>
@else
<p>nisi log</p>
@endauth
</body>
</html>