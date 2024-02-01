<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Article</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>
<body>
    @include('navbar')
    <div class="container mt-4">
        <h1>Izmeni članak</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="naslov">Naslov članka</label>
                <input type="text" class="form-control" id="naslov" name="naslov" value="{{$article->naslov}}">
            </div>
             <div class="form-group">
                <label for="naslovna">Izmeni naslovnu sliku</label>
                <input type="file" class="form-control-file" id="naslovna" name="naslovna">
                <img src="{{ asset('storage/naslovne/' . $article->naslovna) }}" alt="Naslovna slika">
            </div>
            <div class="form-group">
                <label for="tekst">Tekst artikla</label>
                <div id="editor"></div>
                <input type="hidden" id="tekst" name="tekst" value="{{$article->tekst}}">
            </div>
            <div class="form-group">
                <label for="tag">Tagovi članka</label>
                <textarea class="form-control" id="tag" name="tag">@foreach($article->tags as $tag){{$tag->name}} @endforeach</textarea>
            </div>
            <div class="form-group">
                <label for="rubrika">Odaberi rubriku</label>
                <select name="rubrika" class="form-control">
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}" @if ($category->id == $article->rubrika) selected @endif>
                            {{$category->category}}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
        </form>
    </div>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        var quill = new Quill('#editor', {
            theme: 'snow' // Postavi temu editora
        });

        // Postavljanje JSON sadržaja u Quill editor
        var tekst = document.querySelector('input[name=tekst]').value;
        quill.setContents(JSON.parse(tekst));
        
        // Kada se forma pošalje, konvertuj HTML sadržaj iz Quill editora u JSON i postavi ga u skriveno polje
        var form = document.querySelector('form');
        form.onsubmit = function() {
            var tekst = document.querySelector('input[name=tekst]');
            tekst.value = JSON.stringify(quill.getContents());
        };
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
