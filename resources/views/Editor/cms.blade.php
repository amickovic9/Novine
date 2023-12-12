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
        <h3>Upravljanje rubrikama:</h3>
        @foreach ($categories as $category)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{$category->category}}</h5>
                    <a href="/cms-editor/drafts/{{$category->id}}" class="btn btn-sm btn-outline-primary mr-2">Draftovi</a>
                    <a href="/cms-editor/articles/{{$category->id}}" class="btn btn-sm btn-outline-primary">Članci</a>
                </div>
            </div>
        @endforeach
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>
</html>
