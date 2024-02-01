@php
    use App\Services\TextFormattingService;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Novosti</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navbar')  
    <div class="container mt-4">
        <h1>{{$article['naslov']}}</h1>
         @if ($article['naslovna'])
            <img src="{{ asset('storage/naslovne/' . $article['naslovna']) }}" class="img-fluid" alt="Naslovna slika">
        @endif
        <div id="formatted-text">
    {!! TextFormattingService::renderFormattedText($article['tekst']) !!}
</div>


        <p>Iz rubrike: {{$article->category->category}}</p>
        @if ($liked)
            <a href="/article/{{$article->id}}/dislike">Ne svidja mi se</a>
        @else
            <a href="/article/{{$article->id}}/like">Svidja mi se</a>
        @endif
        
        <h1 class="mt-4">Komentari</h1>
        <form action="/add-comment" method="post" class="mt-3">
            @csrf
            <input type="number" name="article_id" hidden value="{{$article['id']}}">   
            <div class="form-group">
                <input type="text" required class="form-control" placeholder="Ime" name="user_name">    
            </div>
            <div class="form-group">
                <textarea class="form-control" required placeholder="Komentar" name="comment"></textarea> 
            </div>
            <button type="submit" class="btn btn-primary">Dodaj komentar</button>    
        </form>

        <div class="mt-4">
            @foreach ($comments as $comment)
            <div class="card mb-3">
                <div class="card-body">
                    <p class="card-text">Korisnik: {{$comment->user_name}}</p>
                    <p class="card-text">Komentar: {{$comment->comment}}</p>
                    <p class="card-text">Vreme: {{$comment->created_at}}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    var quill = new Quill('#editor', {
        theme: 'snow'
    });

    var form = document.querySelector('form');
    form.onsubmit = function() {
        var tekst = document.querySelector('input[name=tekst]');
        tekst.value = JSON.stringify(quill.getContents());
    };
</script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
