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
<style> 
.gallery {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 20px;
}

#image-track {
  display: flex;
  flex-grow: 1;
  overflow-x: auto;
  justify-content:center;
}

.image {
  width: 200px; 
  height: 150px; 
  max-width: 100%; 
  max-height: 100%;
  cursor: pointer;
  margin-right: 2%;
  border: 2px solid #ddd;
  border-radius: 8px;
  image-rendering: pixelated;
}

.image:hover {
  border-color: #777;
}

.selected-image {
  border-color: #3C6A6F;
}

.large-image-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  border-radius: 5px;
}

.large-image {
  max-width: 100%;
  max-height: 60vh;
  position: cover;
  border-radius: 5px;
  margin: 5px 5px;
}

.gallery {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 20px;
}

#image-track {
  display: flex;
  overflow-x: auto;
  flex-grow: 1;
}

@media (max-width: 768px) {
  .image {
    width: 30%;
  }
}

@media (max-width: 576px) {
  .image {
    width: 45%;
  }
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
    <textarea id="tagovi" class="form-control" id="tag" name="tag">@foreach($article->tags as $tag){{$tag->name}} @endforeach</textarea>
    <div id="tagsContainer"></div>
                
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
            <div class="gallery">
    
    <div id="image-track" data-mouse-down-at="0" data-prev-percentage="0">
        @foreach ($article->gallery as $galleryItem)
            @if (Str::endsWith($galleryItem->photo_video, ['.mp4', '.mov', '.avi', '.mkv']))
                <video class="image" width="320" height="240" controls>
                    <source src="{{ asset('storage/gallery/' . $galleryItem->photo_video) }}" type="video/mp4">
                    Vaš pregledač ne podržava video element.
                </video>
            @else
                <img class="image" src="{{ asset('storage/gallery/' . $galleryItem->photo_video) }}" alt="{{ $galleryItem->photo_video }}">
            @endif
        @endforeach
    </div>
   
</div>
<div class="form-group">
            Foto/video
                
            <input type="file" name="files[]" id="files" multiple>
        </div>
            <button type="submit" class="btn btn-primary mb-2" style="background-color: #17a2b8; border-color: #17a2b8;" >Sačuvaj izmene</button>
        </form>
    </div>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        var quill = new Quill('#editor', {
            theme: 'snow'
        });
        var tekst = document.querySelector('input[name=tekst]').value;
        quill.setContents(JSON.parse(tekst));
        
    
        var form = document.querySelector('form');
        form.onsubmit = function() {
            var tekst = document.querySelector('input[name=tekst]');
            tekst.value = JSON.stringify(quill.getContents());
        };
    </script>
     <script src="/js/script.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
