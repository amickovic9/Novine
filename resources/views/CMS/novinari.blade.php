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
    <!DOCTYPE html>
<html lang="en">
<head>
    <!-- Ostatak head dela kao prethodno -->
</head>
<body>
    @include('navbar')
    <div class="container mt-4">
        @foreach($novinari as $novinar)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Ime: {{ $novinar->name }}</h5>
                    <a href="/cms/update-journalist/{{$novinar->id}}">Uredi</a>
                </div>
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Rubrike:</h6>
                    <ul class="list-group">
                        @foreach($novinar->categories as $category)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $category->category }}
                                 
                                <form method="get" action="/cms/remove-category-from-journalist">
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

    <!-- Ostatak body dela kao prethodno -->
</body>
</html>


    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</body>
</html>
