<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zahtevi za brisanje</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navbar')
    <div class="container mt-4">
        <div class="row">
            <h5 class="card-title">Članci za koje su podneti zahtevi za brisanje:</h5>

            <div class="col-md-8">
                @foreach ($deleteRequests as $deleteRequest)
                    <div class="card mb-3">
                        <div class="card-body">
                            <p class="card-text">Naslov: {{ $deleteRequest->news->naslov }}</p>
                            <a href="/article/{{ $deleteRequest->news->id }}" class="btn btn-primary mr-2">Vidi članak</a>
                            <a href="/cms-editor/delete-request/{{ $deleteRequest->id }}/allow" class="btn btn-success mr-2">Dozvoli zahtev za brisanje</a>
                            <a href="/cms-editor/delete-request/{{ $deleteRequest->id }}/decline" class="btn btn-danger">Odbij zahtev za brisanje</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
