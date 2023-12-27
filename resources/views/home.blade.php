<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Početna</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navbar')
    
    <div class="container">
        <h1>Najnoviji članci</h1>
        <form action="" method="GET">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="naslov">Naslov</label>
                    <input type="text" class="form-control" name="naslov" id="naslov" placeholder="Naslov" value="{{request()->input('naslov')}}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="tagovi">Tagovi</label>
                    <input type="text" class="form-control" name="tagovi" id="tagovi" placeholder="Tagovi" value="{{request()->input('tagovi')}}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="datum">Datum</label>
                    <input type="date" class="form-control" name="datum" id="datum" value="{{request()->input('datum')}}">
                </div>
                <div>
                    <select name="rubrika" id="">
                        <option value="">Izaberi</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}" @if ($category->id == request()->input('rubrika'))
                                selected
                            @endif>{{$category->category}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Pretraži</button>
        </form>
        <div class="row mt-4">
            @foreach ($news as $article)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Naslov: {{ $article['naslov'] }}</h5>
                        <a href="/article/{{ $article['id'] }}" class="btn btn-primary">Više</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
