<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detalji</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navbar')
    <div class="container mt-4">
        <h1>Upravljanje artiklima</h1>
        <form action='' method='post' class="mt-3"  enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="naslov">Naslov</label>
                <input type="text" class="form-control" name="naslov" id="naslov" value="{{$article->naslov}}">
            </div>
            <div class="form-group">
                <label for="naslovna">Izmeni naslovnu sliku</label>
                <input type="file" class="form-control-file" id="naslovna" name="naslovna">
                <img src="{{ asset('storage/naslovne/' . $article->naslovna) }}" alt="Naslovna slika">
            </div>
            <div class="form-group">
                <label for="tekst">Tekst</label>
                <input type="text" class="form-control" name="tekst" id="tekst" value="{{$article->tekst}}">
            </div>
            <div class="form-group">
                <label for="tekst">Tagovi</label>
                <textarea type="text" class="form-control" name="tags" id="tekst" >@foreach ($article->tags as $tag ){{$tag->name}} @endforeach</textarea>
            </div>
            <div class="form-group">
                <label for="rubrika">Rubrika</label>
                <input type="text" class="form-control" name="rubrika" id="rubrika" value="{{$article->rubrika}}">
            </div>
            <button type="submit" class="btn btn-primary">Sačuvaj</button>
        </form>
        <div class="mt-3">
            <a href="/cms-editor/article/{{$article->id}}/draft" class="btn btn-danger">Vrati u draftove</a>

        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
