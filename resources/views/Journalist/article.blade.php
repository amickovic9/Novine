<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izmena Artikla</title>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navbar')
    <div class="container mt-4">
        <h1>Izmena Artikla</h1>
        <form action="/cms-journalist/article/{{$article->id}}/request-update" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="file" class="form-control-file" id="naslovna" name="naslovna">
                <img src="{{ asset('storage/naslovne/' . $article->naslovna) }}" alt="Naslovna slika">
            </div>
            <div class="form-group">
                <label for="naslov">Naslov artikla</label>
                <input type="text" class="form-control" id="naslov" name="naslov" value="{{ $article->naslov }}">
            </div>
            <div class="form-group">
                <label for="tekst">Tekst artikla</label>
                <div id="editor">
    {!! App\Services\TextFormattingService::renderFormattedText($article->tekst) !!}
</div>
                <input type="hidden" id="tekst" name="tekst">
            </div>
            <div class="form-group">
                <label for="tekst">Tagovi artikla</label>
                <textarea class="form-control" id="tekst" name="tags" rows="6">@foreach($tags as $tag){{$tag }} @endforeach</textarea>
            </div>
            <div class="form-group">
                <label for="rubrika">Rubrika</label>
                <select name="rubrika" class="form-control">
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}" @if ($category->id == $article->rubrika) selected @endif>
                            {{$category->category}}
                        </option>
                    @endforeach
                </select>
            </div>
            @if ($updateRequestSent)
                <p>Zahtev za izmenu je već poslat!</p>
            @else
                <button type="submit" class="btn btn-primary">Podnesi zahtev za izmenu</button>   
            @endif
        </form>
        
        
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
