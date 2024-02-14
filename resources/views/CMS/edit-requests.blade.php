<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zahtevi za izmene</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

        * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Montserrat', sans-serif;
        }
        .custom-btn-primary {
            background-color: #17a2b8;
            color:white;
            padding: 9px 15px;
            border-radius: 5px; 
            transition:all ease-in-out 0.5s;
            border:none;
        }

        .custom-btn-primary:hover {
            background-color: #2780ba;
            color:white;
            transform:scale(1.1);
            text-decoration:none
        }
        .naslov { 
            font-size:1.5rem;
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
    <h1 class="naslov">Zahtevi za izmenu</h1>
    <form action="" method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Pretraga po naslovu" name="search" value="{{ request()->get('search') }}">
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit" style="background-color: #2780ba;">
                <i class="fas fa-search" style="color: white;"></i>
            </button>
        </div>
    </div>
</form>

        @foreach ($editRequests as $editRequest)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Zahtev za izmenu</h5>
                    <p>Stara Naslovna: 
                    <div class="image-container">
                        <img src="{{ asset('storage/naslovne/' . $editRequest->news->naslovna) }}" alt="Stara Naslovna" class="small-image1">
</div>
                    </p>

                    <p>Nova Naslovna: 
                        @if($editRequest->naslovna == NULL)
                        <p>Ista je</p>
                        @else
                        <div class="image-container">
                        <img src="{{ asset('storage/naslovne/' . $editRequest->naslovna) }}" alt="Nova Naslovna" class="small-image1">
                    </div>
                       @endif 
                    </p>
                    <p>Stari naslov: {{$editRequest->news ? $editRequest->news->naslov : 'Nije pronađeno'}}</p>
                    <p>Novi naslov: {{$editRequest->naslov}}</p>
                    <p>Stari tekst: {{$editRequest->news ? $editRequest->news->tekst : 'Nije pronađeno'}}</p>
                    <p>Novi tekst: {{$editRequest->tekst}}</p>
                    <p>Stara Rubrika: {{$editRequest->news ? $editRequest->news->rubrika : 'Nije pronađeno'}}</p>
                    <p>Nova Rubrika: {{$editRequest->rubrika}}</p>
                    <p>Stari Tagovi:
                        @foreach ($editRequest->news->tags as $tag)
                            {{ $tag->name }}
                        @endforeach
                    </p>
                    <p>
                        Novi Tagovi: @foreach ($editRequest->tags as $tag)
                        {{$tag->name}}
                    @endforeach
                    <p>
                    <p>Nova Galerija:</p>
@if ($editRequest->gallery && $editRequest->gallery->isNotEmpty())
    @foreach ($editRequest->gallery as $galleryItem)
        @if (Str::endsWith($galleryItem->photo_video, ['.jpg', '.jpeg', '.png', '.gif']))
            <img src="{{ asset('storage/gallery/' . $galleryItem->photo_video) }}" alt="Nova Galerija" class="small-image">
        @elseif (Str::endsWith($galleryItem->photo_video, ['.mp4', '.avi', '.mov', '.wmv']))
            <video controls class="small-image">
                <source src="{{ asset('storage/gallery/' . $galleryItem->photo_video) }}" type="video/mp4" >
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
                    <a href="/cms/edit-request/{{$editRequest->id}}/allow" class="custom-btn-primary">Odobri izmene</a>
                    <a href="/cms/edit-request/{{$editRequest->id}}/decline" class="btn btn-danger">Odbij izmene</a>
                </div>
            </div>
        @endforeach
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</html>