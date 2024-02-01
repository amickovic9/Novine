<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikli</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navbar')

    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col-md-6">
                <form action="" method="GET">
                    <div class="form-row">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Pretraga naslova" name="naslov" value="{{ request()->get('naslov') }}">
                        </div>
                        <div class='col'>

                        </div>
                        <div class="col">
                            <input type="date" class="form-control" name="date" value="{{ request()->get('date') }}">
                        </div>
                        <select name="rubrika" id="">
                            @foreach ($categories as $category)
                            <option value="">Izaberi</option>
                                <option value="{{$category->id}}"@if (request()->input('rubrika')==$category->id)
                                   selected
                                @endif>{{$category->category}}</option>
                            @endforeach
                        </select>
                        <div class="col">
                            <button class="btn btn-outline-secondary" type="submit">Pretraži</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{$post->naslov}}</h5>
                            <div>
                                <img src="{{ asset('storage/naslovne/' . $post->naslovna) }}" alt="Naslovna slika">
                            </div>
                            <p class="card-text">{{$post->tekst}}</p>
                            <div class="card-footer">
                                @foreach ($post->tags as $tag)
                                    <span class="badge badge-primary">{{$tag->name}}</span>
                                @endforeach
                            </div>
                             <div class="mt-2">
                                <a href="/cms/delete/{{$post->id}}" class="btn btn-danger">Izbriši</a>
                                <a href="/cms/edit-article/{{$post->id}}" class="btn btn-primary">Izmeni</a>
                                <a href="/cms/return-to-draft/{{$post->id}}" class="btn btn-secondary">Vrati u Draftove</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</body>
</html>
