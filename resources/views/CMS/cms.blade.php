<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CMS</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .menu-container {
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .menu-item {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    @include('navbar')

    <div class="menu-container">
        <h1 class="text-center mb-4">Upravljanje</h1>
        <a href="/cms/create-post" class="btn btn-secondary btn-block menu-item">Dodaj objavu</a>
        <a href="/cms/categories" class="btn btn-secondary btn-block menu-item">Upravljanje rubrikama</a>
        <a href="/cms/delete-requests" class="btn btn-secondary btn-block menu-item">Upravljanje zahtevima za brisanje</a>
        <a href="/cms/edit-requests" class="btn btn-secondary btn-block menu-item">Upravljanje zahtevima za izmene</a>
    </div>
    <div class="container mt-4">
    <h1>Upravljanje Korisnicima</h1>
    <form action="">
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="inputName">Ime:</label>
                <input type="text" class="form-control" id="inputName" name="name" value="{{ request()->input('name') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="inputEmail">Email:</label>
                <input type="text" class="form-control" id="inputEmail" name="email" value="{{ request()->input('email') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="inputRole">Role:</label>
                <input type="text" class="form-control" id="inputRole" name="role" value="{{ request()->input('role') }}">
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Pretrazi</button>
    </form>
    <table class="table mt-4">
        <thead >
            <tr>
                <th>Ime</th>
                <th>Email</th>
                <th>Role</th>
                <th>Akcije</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{$user['name']}}</td>
                <td>{{$user['email']}}</td>
                <td>{{$user['role']}}</td>
                <td>
                    <a href="/cms/edit-user/{{$user['id']}}" class="btn btn-secondary">Izmeni</a>
                    <a href="/cms/delete-user/{{$user['id']}}" class="btn btn-danger">Izbriši</a>
                    @if ($user['role']>1)
                        <a href="/cms/edit-user/{{$user['id']}}/categories" class="btn btn-secondary">Kategorije</a>

                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
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
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>
                            <img src="{{ asset('storage/naslovne/' . $post->naslovna) }}" alt="" class="img-thumbnail" style="max-width: 100px;">
                        </td>
                        <td>{{ $post->naslov }}</td>
                        <td>{{ $post->category->category }}</td>
                        <td>{{ $post->draft }}</td>
                        <td>{{ $post->created_at }}</td>
                        <td>
                            <a href="/cms/delete/{{$post->id}}">Izbrisi</a>
                            <a href="/cms/edit-article/{{$post->id}}">Izmeni</a>
                            @if (!$post->draft)
                                <a href="/cms/return-to-draft/{{$post->id}}">Vrati u draft</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
