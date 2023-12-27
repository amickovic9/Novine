<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Article</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navbar')
    <div class="container mt-4">
        <h1>Izmeni clanak</h1>
        <form action="" method="POST">
            @csrf
            <div class="form-group">
                <label for="naslov">Naslov članka</label>
                <input type="text" class="form-control" id="naslov" name="naslov" value="{{$article->naslov}}">
            </div>
            <div class="form-group">
                <label for="tekst">Tekst članka</label>
                <textarea class="form-control" id="tekst" name="tekst" rows="5">{{$article->tekst}}</textarea>
            </div>
            <div class="form-group">
                <label for="tag">Taggovi članka</label>
                <textarea class="form-control" id="tag" name="tag" >@foreach($article->tags as $tag){{$tag->name }} @endforeach</textarea>
            </div>
            <div class="form-group">
                <label for="rubrika">Odaberi rubriku</label>
                <select name="rubrika" class="form-control">
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}" @if ($category->id == $article->rubrika) selected @endif>
                            {{$category->category}}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
        </form>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
