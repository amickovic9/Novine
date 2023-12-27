<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zahtevi za izmene</title>
</head>
<body>
    @include('navbar')
    <div class="container mt-4">
        
        <form action="" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Pretraga po naslovu" name="search" value="{{ request()->get('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Pretraži</button>
                </div>
            </div>
        </form>
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
                    <p>Stari Tagovi:
                        @foreach ($editRequest->news->tags as $tag)
                            {{ $tag->name }}
                        @endforeach
                    </p>
                    <p>
                        Novi Tagovi: @foreach ($editRequest->tags as $tag)
                        {{$tag->name}}
                    @endforeach
                    <p>

                    <a href="/cms/edit-request/{{$editRequest->id}}/allow" class="btn btn-success mr-2">Odobri izmene</a>
                    <a href="/cms/edit-request/{{$editRequest->id}}/decline" class="btn btn-danger">Odbij izmene</a>
                </div>
            </div>
        @endforeach
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</html>