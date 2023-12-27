<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rubrike</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

@include('navbar')

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <h1>Dodaj Rubriku</h1>
            <form action="/cms/add-category" method="POST">
                @csrf 
                <div class="form-group">
                    <label for="categoryName">Naziv Rubrike:</label>
                    <input type="text" class="form-control" id="categoryName" name="category" required>
                </div>
                <button type="submit" class="btn btn-primary">Dodaj Rubriku</button>
            </form>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-6">
            <h2>Pretraži Rubrike</h2>
            <form action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="name" placeholder="Naziv rubrike" value="{{ request()->input('name') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Pretraži</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <hr>

    <h1>Rubrike</h1>
    <div class="row">
        @foreach ($categories as $category)
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Naziv rubrike:</h5>
                    <form action="/cms/edit-category/{{ $category['id'] }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" value="{{ $category['category'] }}" name="nameOfCategory">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Izmeni naziv</button>
                            </div>
                        </div>
                    </form>
                    <a href="/cms/delete-category/{{ $category['id'] }}" class="btn btn-danger">Izbriši rubriku</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
