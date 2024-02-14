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
    <link rel="icon" href="public/images/2965879.png" type="image/x-icon">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');


        *{
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
        .like-button, .dislike-button {
        display: inline-block;
        padding: 10px 20px;
       
        border: 1px solid #ccc;
        border-radius: 5px;
        text-decoration: none;
        color: #333;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    .like-button:hover{
        background-color: #eee;
        text-decoration: none;
        color:green;
    }
    .dislike-button:hover {
        background-color: #eee;
        text-decoration: none;
        color:red
    }
    .like-button.liked {
        background-color: #4CAF50s;
        color: #fff;
        border-color: #4CAF50;
    }

    .dislike-button.disliked {
        background-color: #f44336;
        color: #fff;
        border-color: #f44336;
    }
    .naslov {
         font-size: 1.5rem;
    }

.likedislike {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #f0f0f0;
    padding: 10px 20px;
    border-radius: 5px;
    font-family: Arial, sans-serif;
}

.likedislike span {
    font-weight: bold;
    margin: 0 10px;
    color: #333;
}

.likedislike span:nth-child(odd) {
    color: #007bff;
}

.likedislike span:nth-child(even) {
    color: #dc3545;
}
.tagovi {
    display: flex;
    flex-wrap: wrap;
}

.tagovi a {
    display: inline-block;
    background-color: #17a2b8;
    color: #fff; 
    padding: 5px 10px; 
    border-radius: 5px; 
    margin-right: 5px; 
    margin-bottom: 5px; 
    text-decoration: none;
    font-size: 14px; 
}
.card-body {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-start;
}

.komentar {
    flex: 1;
}

.dugmici-lajk {
    margin-left: auto;
    display: flex; 
}
.dugmici-lajk form button {
    margin-left: 10px;
    background-color: #17a2b8;
}
.dugmici-lajk form button:hover {
   background-color:#2780ba;
}

.nav-button {
  background-color: #17a2b8;
  color: white;
  border: none; 
  padding: 10px 15px; 
  font-size: 16px; 
  cursor: pointer; 
  border-radius: 5px; 
    }
.nav-button:hover {
  background-color: white;
  color: #17a2b8;
  border: 2px solid #17a2b8;
}


.large-image-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 90vh; 
  width: 90%; 
  margin: auto;
  overflow: hidden;
}

.large-image {
  width: 100%;
  height: 100%;
  object-fit: cover; 
}

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
  flex-direction:column;
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



    </style>
</head>
<body>
    @include('navbar')  
    <div class="container mt-4">
    <div>
        <h1>{{$article['naslov']}}</h1>
        @if ($article['naslovna'])
            <div class="d-flex justify-content-center align-items-center" style="height: 65vh;">
                <div style="background-image: url('{{ asset('storage/naslovne/' . $article['naslovna']) }}'); background-size: contain; background-repeat: no-repeat; background-position: center; width: 100%; height: 60vh;"></div>
            </div>
        @endif
    </div>
    <div id="formatted-text">
        {!! TextFormattingService::renderFormattedText($article['tekst']) !!}
    </div>
    <div class="gallery">
    @if (count($article->gallery) > 0)
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
        <div class="large-image-wrapper">
            <button id="scrollLeft" class="nav-button"><i class="fas fa-chevron-left"></i></button>
            <img class="large-image" src="{{ asset('storage/gallery/' . $article->gallery[0]->photo_video) }}" alt="{{ $article->gallery[0]->photo_video }}" />
            <button id="scrollRight" class="nav-button"><i class="fas fa-chevron-right"></i></button>
        </div>
    @endif
</div>

    <div>
        <br>
        <br>
        <p>Iz rubrike: <a href="{{ route('home', ['pretraga' => $article->category->category]) }}">{{ $article->category->category }}</a></p>
        <div class="tagovi">
            @foreach ($article->tags as $tag)
                <a href="{{ route('home', ['pretraga' => $tag->name]) }}">#{{ $tag->name }}</a>
            @endforeach
        </div>
        <div class="likedislike">
            <div class="dugmici-lajk">
                <form action="/article/{{ $article->id }}/like" method="POST">
                    @csrf
                    @if ($liked)
                        <button type="submit" class="like-button button">
                            <i class="fa fa-thumbs-up" style="color: green;"></i>
                        </button>
                    @else
                        <button type="submit" class="like-button button">
                            <i class="fa fa-thumbs-up" style="color: white;"></i> 
                        </button>
                    @endif
                </form>
                <form action="/article/{{ $article->id }}/dislike" method="POST">
                    @csrf
                    @if ($disliked)
                        <button type="submit" class="dislike-button button">
                            <i class="fa fa-thumbs-down" style="color: red;"></i> 
                        </button>
                    @else
                        <button type="submit" class="dislike-button button">
                            <i class="fa fa-thumbs-down" style="color: white;"></i> 
                        </button>
                    @endif
                </form>
            </div>
            <div>
                Svidjanja: {{ $likeCount }}
                Nesvidjanja: {{ $dislikeCount }}
            </div>
        </div>
    </div>
    <div style="width: 100%; margin: 0 auto;">
        <h1 class="mt-4 naslov">Komentari</h1>
        <form action="/add-comment" method="post" class="mt-3">
            @csrf
            <input type="number" name="article_id" hidden value="{{$article['id']}}">   
            <div class="form-group">
                <input type="text" required class="form-control" placeholder="Ime" name="user_name">    
            </div>
            <div class="form-group">
                <textarea class="form-control" required placeholder="Komentar" name="comment"></textarea> 
            </div>
            <button type="submit" class="custom-btn-primary">Dodaj komentar</button>    
        </form>
        <div class="mt-4">
            @foreach ($comments as $comment)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="komentar">
                            <p class="card-text">Korisnik: {{ $comment->user_name }}</p>
                            <p class="card-text">Komentar: {{ $comment->comment }}</p>
                            <p class="card-text">Vreme: {{ $comment->created_at }}</p>
                        </div>
                        <div class="dugmici-lajk">
                            <form action="/like-comment/{{ $comment->id }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="background-color: {{ $comment->liked ? 'green' : '#17a2b8' }}; border-color: #17a2b8;">
                                    <i class="fa fa-thumbs-up" style="color: white;">     {{ $comment->likeCount }}</i>
                                </button>
                            </form>
                            <form action="/dislike-comment/{{ $comment->id }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger" style="background-color: {{ $comment->disliked ? 'red' : '' }};">
                                    <i class="fa fa-thumbs-down" style="color: white;">    {{ $comment->dislikeCount }}</i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
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
    <script src="/js/script.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>