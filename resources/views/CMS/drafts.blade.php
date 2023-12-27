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
        <div class="row mb-3">
            <div class="col-md-6">
                <form action="" method="GET">
                    <div class="form-row mb-3">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Pretraga naslova" name="naslov" value="{{ request()->get('naslov') }}">
                        </div>
                        <div class="col">
                            <input type="date" class="form-control" name="date" value="{{ request()->get('date') }}">
                        </div>
                        <div class="col">
                            <select class="custom-select" name="rubrika">
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}" @if (request()->input('rubrika')==$category->id) selected @endif>{{$category->category}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <button class="btn btn-outline-secondary" type="submit">Pretraži</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="container mt-4">
            @foreach ($drafts as $draft)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{$draft->naslov}}</h5>
                        <p class="card-text">{{$draft->tekst}}</p>
                        @foreach($draft->tags as $tag)
                            <span class="badge badge-primary">{{$tag->name}}</span>
                        @endforeach
                        <p>Rubrika: {{ $draft->rubrika }}</p>
                        <div class="mt-3">
                            <a href="/cms/delete-draft/{{$draft->id}}" class="btn btn-danger">Izbriši</a>
                            <a href="/cms/edit-draft/{{$draft->id}}" class="btn btn-primary">Izmeni</a>
                            <a href="/cms/allow-draft/{{$draft->id}}" class="btn btn-success">Dozvoli</a>
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
