
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Početna</title>
</head>
<body>
@include('navbar')
@foreach ($news as $article)
    <div>
        Naslov: {{$article['naslov']}}
        <a href="/article/{{$article['id']}}">Vise</a>
    </div>
@endforeach

</body>
</html>