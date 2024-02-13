<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detalji</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        #editor {
            border: 1px solid #ccc;
            min-height: 300px;
        }
        #tagsContainer { 
            margin-top: 10px;
            font-size:12px;

        }
        .tag-box {
            display: inline-block;
            padding: 5px;
            margin: 5px;
            border-radius: 5px;
            color: black;
        }

        .tags-frame {
            padding: 5px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    @include('navbar')
    <div class="container mt-4">
        <h1>Upravljanje člankom</h1>
        <form action='' method='post' class="mt-3"  enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="naslov">Izmeni naslov članka</label>
                <input type="text" class="form-control" name="naslov" id="naslov" value="{{$draft->naslov}}">
            </div>
            <div class="form-group">
                <label for="naslovna">Izmeni naslovnu sliku</label>
                <input type="file" class="form-control-file" id="naslovna" name="naslovna">
                <img src="{{ asset('storage/naslovne/' . $draft->naslovna) }}" alt="Naslovna slika">
            </div>
            <div class="form-group">
                <label for="tekst">Izmeni tekst članka</label>
                <div id="editor">
                    {!! App\Services\TextFormattingService::renderFormattedText($draft->tekst) !!}
                </div>
                <input type="hidden" id="tekst" name="tekst">
            </div>
            
            <div class="form-group">
                
                <label for="tekst">Tagovi</label>
                <textarea type="text" id="tagovi"  class="form-control" name="tags" id="tags">@foreach ($draft->tags as $tag ){{$tag->name}} @endforeach</textarea>
            <div id="tagsContainer"></div></div>
            <div class="form-group">
                <label for="rubrika">Odaberi rubriku</label>
                <select name="rubrika" class="form-control">
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}" @if ($category->id == $draft->rubrika) selected @endif>
                            {{$category->category}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                Foto/video
                <input type="file" name="files[]" id="files" multiple>
            </div>
            <div class="gallery">
                @foreach ($draft->gallery as $galleryItem)
                    @if (Str::endsWith($galleryItem->photo_video, ['.mp4', '.mov', '.avi', '.mkv']))
                        <video width="320" height="240" controls>
                            <source src="{{ asset('storage/gallery/' . $galleryItem->photo_video) }}" type="video/mp4">
                            Vaš pregledač ne podržava video element.
                        </video>
                    @else
                        <img src="{{ asset('storage/gallery/' . $galleryItem->photo_video) }}" alt="{{ $galleryItem->photo_video }}">
                    @endif
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary mb-2" style="background-color: #2780ba; border-color: #2780ba;">Sačuvaj</button>
        </form>
        
    </div>
    <script src="/js/script.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
</body>
</html>
