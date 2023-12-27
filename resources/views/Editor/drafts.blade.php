<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Draftovi</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navbar')
    <div class="container mt-4">
        <h1>Upravljanje rubrikom: {{ $category->category }} - draftovi</h1>
        <form action="">
            @csrf
            <input type="text">
            <button type="submit">Pretrazi</button>
        </form>
        <div class="list-group mt-4">
            @foreach ($drafts as $draft)
                <a href="/cms-editor/draft/{{$draft->id}}" class="list-group-item list-group-item-action">
                    {{$draft->naslov}}
                    <span class="float-right">Detalji</span>
                </a>
            @endforeach
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
