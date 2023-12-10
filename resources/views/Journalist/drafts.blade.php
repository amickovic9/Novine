<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Draftovi</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navbar')
    <div class="container mt-4">
        <h1>Upravljanje draftovima</h1>
        <ul class="list-group">
            @foreach ($drafts as $draft)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{$draft->naslov}}
                <div class="btn-group" role="group" aria-label="Upravljanje draftom">
                    <a href="/cms-journalist/delete/{{$draft->id}}" class="btn btn-danger">Izbriši</a>
                    <a href="/cms-journalist/edit/{{$draft->id}}" class="btn btn-warning">Izmeni</a>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
