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
    <table class="table">
        <thead>
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
                    <a href="/cms/delete-user/{{$user['id']}}" class="btn btn-danger">Izbrisi</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
