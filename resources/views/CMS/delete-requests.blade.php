<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zahtevi za brisanje</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navbar')

    <div class="container mt-4">
        <h1>Zahtevi za brisanje</h1>
        <form action="" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Pretraga po naslovu" name="search" value="{{ request()->get('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Pretraži</button>
                </div>
            </div>
        </form>
        <div class="col-md-8">
            @foreach ($deleteRequests as $deleteRequest)
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="card-text">Naslov: {{ $deleteRequest->news->naslov }}</p>
                        <a href="/article/{{ $deleteRequest->news->id }}" class="btn btn-primary mr-2">Vidi članak</a>
                        <a href="/cms/delete-request/{{ $deleteRequest->id }}/allow" class="btn btn-success mr-2">Dozvoli zahtev za brisanje</a>
                        <a href="/cms/delete-request/{{ $deleteRequest->id }}/decline" class="btn btn-danger">Odbij zahtev za brisanje</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</body>
</html>
