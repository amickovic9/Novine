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
    .button {
  position: relative;
  padding: 10px 22px;
  border-radius: 6px;
  border: none;
  color: #fff;
  cursor: pointer;
  background-color: #17a2b8;
  transition: all 0.2s ease;
}

.button:active {
  transform: scale(0.96);
}

.button:before,
.button:after {
  position: absolute;
  content: "";
  width: 150%;
  left: 50%;
  height: 100%;
  transform: translateX(-50%);
  z-index: -1000;
  background-repeat: no-repeat;
}

.button:hover:before {
  top: -70%;
  background-image: radial-gradient(circle, #17a2b8 20%, transparent 20%),
    radial-gradient(circle, transparent 20%, #17a2b8 20%, transparent 30%),
    radial-gradient(circle, #17a2b8 20%, transparent 20%),
    radial-gradient(circle, #17a2b8 20%, transparent 20%),
    radial-gradient(circle, transparent 10%, #17a2b8 15%, transparent 20%),
    radial-gradient(circle, #17a2b8 20%, transparent 20%),
    radial-gradient(circle, #17a2b8 20%, transparent 20%),
    radial-gradient(circle, #17a2b8 20%, transparent 20%),
    radial-gradient(circle, #17a2b8 20%, transparent 20%);
  background-size: 10% 10%, 20% 20%, 15% 15%, 20% 20%, 18% 18%, 10% 10%, 15% 15%,
    10% 10%, 18% 18%;
  background-position: 50% 120%;
  animation: greentopBubbles 0.6s ease;
}

@keyframes greentopBubbles {
  0% {
    background-position: 5% 90%, 10% 90%, 10% 90%, 15% 90%, 25% 90%, 25% 90%,
      40% 90%, 55% 90%, 70% 90%;
  }

  50% {
    background-position: 0% 80%, 0% 20%, 10% 40%, 20% 0%, 30% 30%, 22% 50%,
      50% 50%, 65% 20%, 90% 30%;
  }

  100% {
    background-position: 0% 70%, 0% 10%, 10% 30%, 20% -10%, 30% 20%, 22% 40%,
      50% 40%, 65% 10%, 90% 20%;
    background-size: 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%;
  }
}

.button:hover::after {
  bottom: -70%;
  background-image: radial-gradient(circle, #17a2b8 20%, transparent 20%),
    radial-gradient(circle, #17a2b8 20%, transparent 20%),
    radial-gradient(circle, transparent 10%, #17a2b8 15%, transparent 20%),
    radial-gradient(circle, #17a2b8 20%, transparent 20%),
    radial-gradient(circle, #17a2b8 20%, transparent 20%),
    radial-gradient(circle, #17a2b8 20%, transparent 20%),
    radial-gradient(circle, #17a2b8 20%, transparent 20%);
  background-size: 15% 15%, 20% 20%, 18% 18%, 20% 20%, 15% 15%, 20% 20%, 18% 18%;
  background-position: 50% 0%;
  animation: greenbottomBubbles 0.6s ease;
}

@keyframes greenbottomBubbles {
  0% {
    background-position: 10% -10%, 30% 10%, 55% -10%, 70% -10%, 85% -10%,
      70% -10%, 70% 0%;
  }

  50% {
    background-position: 0% 80%, 20% 80%, 45% 60%, 60% 100%, 75% 70%, 95% 60%,
      105% 0%;
  }

  100% {
    background-position: 0% 90%, 20% 90%, 45% 70%, 60% 110%, 75% 80%, 95% 70%,
      110% 10%;
    background-size: 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%;
  }
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

.dugmici-lajk form {
    display: flex;
}

.dugmici-lajk form button {
    margin-left: 5px;
}


    </style>
</head>
<body>
    @include('navbar')  
    <div class="container mt-4">
        <h1>{{$article['naslov']}}</h1>
        @if ($article['naslovna'])
    <div class="d-flex justify-content-center align-items-center" style="height: 65vh;">
        <div style="background-image: url('{{ asset('storage/naslovne/' . $article['naslovna']) }}'); background-size: contain; background-repeat: no-repeat; background-position: center; width: 100%; height: 60vh;">
      </div>
    </div>
@endif
        <div id="formatted-text">
            {!! TextFormattingService::renderFormattedText($article['tekst']) !!}
        </div>
        <br>
        <br>
        <p>Iz rubrike: <a href="{{ route('home', ['pretraga' => $article->category->category]) }}">{{ $article->category->category }}</a></p>
       
    
    <div class="gallery">
        @foreach ($article->gallery as $galleryItem)
            @if (Str::endsWith($galleryItem->photo_video, ['.mp4', '.mov', '.avi', '.mkv']))
                <video width="320" height="240" controls>
                    <source src="{{ asset('storage/gallery/' . $galleryItem->photo_video) }}" type="video/mp4">
                    Vaš pregledač ne podržava video element.
                </video>
            @else
                <img src="{{ asset('storage/gallery/' . $galleryItem->photo_video) }}" alt="{{ $galleryItem->photo_video }}">
            @endif
    </div>
@endforeach
        <div class="tagovi">
        @foreach ($article->tags as $tag)
            <a href="{{ route('home', ['pretraga' => $tag->name]) }}">{{ $tag->name }}</a>
        @endforeach
        </div> 

       

        <div class="likedislike">
        <div class="likedislike">
    <div>
        <form action="/article/{{ $article->id }}/like" method="POST">
            @csrf
            @if ($liked)
                <button type="submit" class="like-button button">
                    <i class="fa fa-thumbs-up" style="color: green;"></i> <!-- Zeleni prstić na gore ako je lajkovano -->
                </button>
            @else
                <button type="submit" class="like-button button">
                    <i class="fa fa-thumbs-up" style="color: white;"></i> <!-- Beli prstić na gore ako nije lajkovano -->
                </button>
            @endif
        </form>

        <form action="/article/{{ $article->id }}/dislike" method="POST">
            @csrf
            @if ($disliked)
                <button type="submit" class="dislike-button button">
                    <i class="fa fa-thumbs-down" style="color: red;"></i> <!-- Crveni prstić na dole ako je dislajkovano -->
                </button>
            @else
                <button type="submit" class="dislike-button button">
                    <i class="fa fa-thumbs-down" style="color: white;"></i> <!-- Beli prstić na dole ako nije dislajkovano -->
                </button>
            @endif
        </form>
    </div>
</div>


    
    <div>
        Svidjanja: {{ $likeCount }}
        Nesvidjanja: {{ $dislikeCount }}
    </div>
</div>

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
                <button type="submit" class="btn btn-primary"style="background-color: #17a2b8; border-color: #17a2b8;"><i class="fa fa-thumbs-up" style="color: white;" >     {{ $comment->likeCount }}</i></button>
            </form>
            <form action="/dislike-comment/{{ $comment->id }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger"><i class="fa fa-thumbs-down" style="color: white;">     {{ $comment->dislikeCount }}</i></button>
              </form>
          </div>
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
