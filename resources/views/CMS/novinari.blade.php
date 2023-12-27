<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upravljanje novinarima</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navbar')
    <div class="container mt-4">
        <form class="form-inline mb-4">
            <input type="text" class="form-control mr-2" name='name' placeholder="Pretraži po imenu" value={{request()->input('name')}}>
            <input type="submit" value="Pretraži" class="btn btn-primary">
        </form>
        @foreach($novinari as $novinar)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ime: {{ $novinar->name }}</h5>
                    <a href="/cms/update-journalist/{{$novinar->id}}" class="btn btn-primary btn-sm">Uredi</a>
                </div>
                <div class="card-body">
                    <h6 class="card-subtitle mb-3 text-muted">Rubrike:</h6>
                    <ul class="list-group">
                        @foreach($novinar->categories as $category)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $category->category }}
                                <form method="get" action="/cms/remove-category-from-journalist" class="ml-auto">
                                    @csrf
                                    <input type="hidden" name="userCategoryId" value="{{ $category->pivot->id }}">
                                    <button type="submit" class="btn btn-danger btn-sm">Ukloni</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
