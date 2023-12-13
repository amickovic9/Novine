<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zahtevi za izmenu</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navbar')
    <div class="container mt-4">
        @foreach ($editRequests as $editRequest)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Zahtev za izmenu</h5>
                    <p>Stari naslov: {{$editRequest->news ? $editRequest->news->naslov : 'Nije pronađeno'}}</p>
                    <p>Novi naslov: {{$editRequest->naslov}}</p>
                    <p>Stari tekst: {{$editRequest->news ? $editRequest->news->tekst : 'Nije pronađeno'}}</p>
                    <p>Novi tekst: {{$editRequest->tekst}}</p>
                    <p>Stara Rubrika: {{$editRequest->news ? $editRequest->news->rubrika : 'Nije pronađeno'}}</p>
                    <p>Nova Rubrika: {{$editRequest->rubrika}}</p>
                    <a href="/cms-editor/edit-request/{{$editRequest->id}}/allow" class="btn btn-success mr-2">Odobri izmene</a>
                    <a href="/cms-editor/edit-request/{{$editRequest->id}}/decline" class="btn btn-danger">Odbij izmene</a>
                </div>
            </div>
        @endforeach
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>
</html>
