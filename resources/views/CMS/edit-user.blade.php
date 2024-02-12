<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uredi Korisnika</title>
    <link href="/css/CMS/edituser.css" rel="stylesheet">
</head>
<body>

@include('navbar')

<div class="container mt-4">
    <h1 class="naslov">Uredi Korisnika</h1>
    <form action="/cms/update-user/{{$user['id']}}" method="POST">
        @csrf 
        <div class="form-group">
            <label for="name">Ime:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{$user['name']}}">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="{{$user['email']}}">
        </div>
        <div class="form-group">
           <select class="form-control" id="role" name="role">
                <option value="1" @if($user['role'] == '1') selected @endif>1</option>
                <option value="2" @if($user['role'] == '2') selected @endif>2</option>
                <option value="3" @if($user['role'] == '3') selected @endif>3</option>
                <option value="4" @if($user['role'] == '4') selected @endif>4</option>
            </select>
        </div>
        <button type="submit">Ažuriraj Korisnika</button>
    </form>
</div>

</body>
</html>
