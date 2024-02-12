<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zahtevi za izmenu</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
                    <p><b>Stara Naslovna:</b> 
                        <img src="{{ asset('storage/naslovne/' . $editRequest->news->naslovna) }}" alt="Stara Naslovna">
                    </p>

                    <p><b>Nova Naslovna:</b> 
                        @if($editRequest->naslovna == NULL)
                        <p>Ista je</p>
                        @else
                        <img src="{{ asset('storage/naslovne/' . $editRequest->naslovna) }}" alt="Nova Naslovna">

                       @endif 
                    </p>

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
            <img src="{{ asset('storage/gallery/' . $galleryItem->photo_video) }}" alt="Stara Galerija">
        @endforeach
    @else
        Nije pronađeno
    @endif
</p>

<p><b>Nova Galerija:</b></p>
@if ($editRequest->gallery && $editRequest->gallery->isNotEmpty())
    @foreach ($editRequest->gallery as $galleryItem)
        @if (Str::endsWith($galleryItem->photo_video, ['.jpg', '.jpeg', '.png', '.gif']))
            <img src="{{ asset('storage/gallery/' . $galleryItem->photo_video) }}" alt="Nova Galerija">
        @elseif (Str::endsWith($galleryItem->photo_video, ['.mp4', '.avi', '.mov', '.wmv']))
            <video controls>
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
