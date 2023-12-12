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
        <h1>Upravljanje člancima</h1>
        <div class="mb-3">
            <a href="/cms-journalist/drafts" class="btn btn-primary mr-2">Moji draftovi</a>
            <a href="/cms-journalist/create-post" class="btn btn-success">Novi članak</a>
            <a href="/cms-journalist/articles" class="btn btn-secondary">Moji članci</a>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
