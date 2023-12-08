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
    <h1>Upravljanje</h1>
    <a href="/cms/create-post" class="btn btn-primary btn-lg btn-block mb-3">Dodaj objavu</a>
    <a href="/cms/users" class="btn btn-primary btn-lg btn-block mb-3">Upravljanje korisnicima</a>
    <a href="/cms/novinari" class="btn btn-primary btn-lg btn-block mb-3">Upravljanje novinarima</a>
    <a href="/cms/urednici" class="btn btn-primary btn-lg btn-block mb-3">Upravljanje urednicima</a>
    <a href="/cms/categories" class="btn btn-primary btn-lg btn-block mb-3">Upravljanje rubrikama</a>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
