<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izmena Artikla</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navbar')
    <div class="container mt-4">
        <h1>Izmena Artikla</h1>
        <form action="/cms-journalist/article/{{$article->id}}/request-update" method="post">
            @csrf
            <div class="form-group">
                <label for="naslov">Naslov artikla</label>
                <input type="text" class="form-control" id="naslov" name="naslov" value="{{ $article->naslov }}">
            </div>
            <div class="form-group">
                <label for="tekst">Tekst artikla</label>
                <textarea class="form-control" id="tekst" name="tekst" rows="6">{{ $article->tekst }}</textarea>
            </div>
            <div class="form-group">
                <label for="rubrika">Rubrika</label>
                <select name="rubrika" class="form-control">
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}" @if ($category->id == $article->rubrika) selected @endif>
                            {{$category->category}}
                        </option>
                    @endforeach
                </select>
            </div>
            @if ($updateRequestSent)
                <p>Zahtev za izmenu je već poslat!</p>
            @else
                <button type="submit" class="btn btn-primary">Podnesi zahtev za izmenu</button>   
            @endif
        </form>
        
        @if ($deleteRequestSent)
            <p>Zahtev za brisanje je već poslat!</p>
        @else  
            <a href="/cms-journalist/article/{{$article->id}}/request-delete" class="mt-3 btn btn-danger">Podnesi zahtev za brisanje</a>
        @endif
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
