<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Početna</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navbar')
    
    <div class="container">
        @foreach ($news as $article)
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Naslov: {{$article['naslov']}}</h5>
                <a href="/article/{{$article['id']}}" class="btn btn-primary">Više</a>
            </div>
        </div>
        @endforeach
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
