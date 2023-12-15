<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kreiraj objavu</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

@include('navbar')

<div class="container mt-4">
    <form action="/cms-journalist/create-post" method="POST">
        @csrf 
        <div class="form-group">
            <label for="naslov">Naslov članka</label>
            <input type="text" name="naslov" required class="form-control" id="naslov"> 
        </div>
        <div class="form-group">
            <label for="tekst">Tekst članka</label>
            <textarea name="tekst" required class="form-control" id="tekst"></textarea>
        </div>
        <div class="form-group">
            <label for="rubrika">Odaberi rubriku</label>
            <select name="rubrika" class="form-control" id="rubrika">
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->category}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <input type="text" name="tagovi" id="tagovi" class="form-control" placeholder="Tagovi">
        </div>
        <button type="submit" class="btn btn-primary mt-2">Kreiraj objavu</button> 
    </form>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
