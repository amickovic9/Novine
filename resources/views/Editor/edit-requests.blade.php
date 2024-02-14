<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zahtevi za izmenu</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<style> 
 @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');


        *{
             margin: 0;
             padding: 0;
             box-sizing: border-box;
             font-family: 'Montserrat', sans-serif;
        }
.image-container {
    display: inline-block;
    width: 400px;
    height: 300px;
    margin-right: 20px;
    overflow: hidden;
    border-radius: 10px;
}

.small-image1{
    max-width: 100%;
    max-height: 100%;
}
.small-image {
    max-width: 200px;
    max-height: 200px;
    margin-right: 10px;
}

.small-video {
    max-width: 200px;
    max-height: 200px;
    margin-right: 10px;
}


</style> 
</head>
<body>
    @include('navbar')
    <div class="container mt-4">
        @if ($editRequests->isEmpty())
        <h1>Nema novih zahteva za izmene</h1>
        @else
        
        @foreach ($editRequests as $editRequest)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Zahtev za izmenu</h5>
                    <div class="form-group">
                <p><b>Stara Naslovna:</b></p>
                <div class="image-container">
                    <img src="{{ asset('storage/naslovne/' . $editRequest->news->naslovna) }}" alt="Stara Naslovna" class="small-image1">
                </div>
            </div>

            <div class="form-group">
                <p><b>Nova Naslovna:</b></p>
                @if($editRequest->naslovna == NULL)
                    <p>Ista je</p>
                @else
                    <div class="image-container">
                        <img src="{{ asset('storage/naslovne/' . $editRequest->naslovna) }}" alt="Nova Naslovna" class="small-image1">
                    </div>
                @endif
            </div>

                    <p><b>Stari naslov:</b> {{$editRequest->news ? $editRequest->news->naslov : 'Nije pronađeno'}}</p>
                    <p><b>Novi naslov: </b>{{$editRequest->naslov}}</p>
                    <p><b>Stari tekst:</b> {!! \App\Services\TextFormattingService::renderFormattedText($editRequest->news ? $editRequest->news->tekst : '') !!}</p>
                    <p><b>Novi tekst:</b> {!! \App\Services\TextFormattingService::renderFormattedText($editRequest->tekst) !!}</p>
                    <p><b>Stara Rubrika:</b> {{$editRequest->news ? $editRequest->news->rubrika : 'Nije pronađeno'}}</p>
                    <p><b>Nova Rubrika:</b> {{$editRequest->rubrika}}</p>
                    <p><b>Stari Tagovi:</b>
                        @foreach ($editRequest->news->tags as $tag)
                            {{ $tag->name }}
                        @endforeach
                    </p>
                    <p><b>
                        Novi Tagovi:</b> @foreach ($editRequest->tags as $tag)
                        {{$tag->name}}
                    @endforeach
                        </p>
                <p><b>Stara Galerija: </b>
    @if ($editRequest->news && $editRequest->news->gallery->isNotEmpty())
        @foreach ($editRequest->news->gallery as $galleryItem)
            <img src="{{ asset('storage/gallery/' . $galleryItem->photo_video) }}" alt="Stara Galerija" class="small-image">
        @endforeach
    @else
        Nije pronađeno
    @endif
</p>

<p><b>Nova Galerija:</b></p>
@if ($editRequest->gallery && $editRequest->gallery->isNotEmpty())
    @foreach ($editRequest->gallery as $galleryItem)
        @if (Str::endsWith($galleryItem->photo_video, ['.jpg', '.jpeg', '.png', '.gif']))
            <img src="{{ asset('storage/gallery/' . $galleryItem->photo_video) }}" alt="Nova Galerija" class="small-image">
        @elseif (Str::endsWith($galleryItem->photo_video, ['.mp4', '.avi', '.mov', '.wmv']))
            <video controls class="small-video">
                <source src="{{ asset('storage/gallery/' . $galleryItem->photo_video) }}" type="video/mp4">
                Vaš pregledač ne podržava video zapise.
            </video>
        @else
            <p>Nepodržani format datoteke: {{ $galleryItem->photo_video }}</p>
        @endif
    @endforeach
@else
    <p>Nije pronađeno</p>
@endif

<br>
<br>
                    <a href="/cms-editor/edit-request/{{$editRequest->id}}/allow" class="btn btn-success mr-2">Odobri izmene</a>
                    <a href="/cms-editor/edit-request/{{$editRequest->id}}/decline" class="btn btn-danger">Odbij izmene</a>
                </div>
            </div>
        @endforeach
    </div>
    @endif
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>
</html>
