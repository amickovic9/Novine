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
        <input type="text" name="naslov" required placeholder="Naslov članka" class="form-control mb-2"> 
        <textarea name="tekst" required placeholder="Tekst članka" class="form-control mb-2"></textarea> 
        <input type="text" name="rubrika" required placeholder="Rubrika" class="form-control mb-2">   
        
        <button type="submit" class="btn btn-primary mt-2">Kreiraj objavu</button> 
    </form>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
