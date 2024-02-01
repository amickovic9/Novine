<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CMS</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navbar')

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <h3>Zahtevi za brisanje:</h3>
                <span>{{$deleteRequests}}</span>
                @if ($deleteRequests > 0)
                    <a href="/cms-editor/delete-requests" class="btn btn-primary mt-2">Vidi zahteve</a>
                @endif
            </div>

            <div class="col-md-6 text-md-right">
                <h3 class="mt-4 mt-md-0">Zahtevi za izmenu:</h3>
                @if ($updateRequests > 0)
                    <a href="/cms-editor/edit-requests" class="btn btn-primary">{{ $updateRequests }} Vidi zahteve</a>
                @else
                    <span>0</span>
                @endif
            </div>
        </div>

        <a href="/cms-editor/create" class="btn btn-success mt-3">Kreiraj objavu</a>
    </div>

    <div class="container mt-4">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Slika</th>
                        <th>Naslov</th>
                        <th>Kategorija</th>
                        <th>Draft</th>
                        <th>Kreirano</th>
                        <th>Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <td>{{ $article->id }}</td>
                            <td>
                                <img src="{{ asset('storage/naslovne/' . $article->naslovna) }}" alt="" class="img-thumbnail" style="max-width: 100px;">
                            </td>
                            <td>{{ $article->naslov }}</td>
                            <td>{{ $article->category->category }}</td>
                            <td>{{ $article->draft }}</td>
                            <td>{{ $article->created_at }}</td>
                            <td>
                                @if ($article->draft == 1)
                                    <a href="/cms-editor/draft/{{$article->id}}" class="btn btn-info">Pogledaj draft</a>
                                @else
                                    <a href="/cms-editor/article/{{$article->id}}" class="btn btn-info">Pogledaj artikl</a>
                                @endif
                                <a href="/cms-editor/delete/{{$article->id}}" class="btn btn-danger">Izbrisi</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="container mt-4">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Ime</th>
                    <th>Email</th>
                    <th>Kategorije</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($journalists as $journalist)
                    <tr>
                        <td>{{ $journalist['name'] }}</td>
                        <td>{{ $journalist['email'] }}</td>
                        <td>
                            <form action="/cms-editor/{{$journalist['id']}}/categories-update" method="post">
                                @csrf
                                @foreach ($categories as $category)
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" name="categories[]" value="{{ $category['id'] }}"
                                               @if(in_array($category['id'], $journalist['categoryIds'])) checked @endif>
                                        <label class="form-check-label">{{ $category['category'] }}</label>
                                    </div>
                                @endforeach
                        </td>
                        <td>
                                <button type="submit" class="btn btn-primary mt-2">Azuriraj</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>
</html>
