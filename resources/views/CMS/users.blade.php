<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upravljanje Korisnicima</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

@include('navbar')

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
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
