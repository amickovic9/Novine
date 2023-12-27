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
        <a href="/cms/posts" class="btn btn-secondary btn-block menu-item">Upravljanje artiklima</a>
        <a href="/cms/drafts" class="btn btn-secondary btn-block menu-item">Upravljanje draftovima</a>
        <a href="/cms/users" class="btn btn-secondary btn-block menu-item">Upravljanje korisnicima</a>
        <a href="/cms/journalist" class="btn btn-secondary btn-block menu-item">Upravljanje novinarima</a>
        <a href="/cms/editors" class="btn btn-secondary btn-block menu-item">Upravljanje urednicima</a>
        <a href="/cms/categories" class="btn btn-secondary btn-block menu-item">Upravljanje rubrikama</a>
        <a href="/cms/delete-requests" class="btn btn-secondary btn-block menu-item">Upravljanje zahtevima za brisanje</a>
        <a href="/cms/edit-requests" class="btn btn-secondary btn-block menu-item">Upravljanje zahtevima za izmene</a>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
