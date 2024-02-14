<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Početna</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }
        body{
             min-height:90vh;
        }

        .custom-btn-primary,
        .custom-btn-primary1 {
            background-color:#17a2b8 ;
            color: white;
            padding: 9px 15px;
            border-radius: 5px;
            transition: all ease-in-out 0.5s;
            border: none;
        }

        .custom-btn-primary:hover {
            background-color: #2780ba;
            color: white;
            transform: scale(1.03);
            text-decoration: none
        }

        .custom-btn-primary1:hover {
            background-color: #2780ba;
            color: white;
            transform: scale(1.03);
            text-decoration: none
        }
        .card-title  { 
            height: 6rem; 
            overflow:hidden;
        }

        .card-title:hover {
            color: red;
            transform: scale(1.02);
            transition: all ease-in-out 0.5s;
        }

        .naslov {
            margin-top: 10px;
            font-size: 1.8rem;
        }

        .custom-btn-primary {
            display: block;
            width: 90%;
            margin-top: 10px;
        }

        .pagination {
            justify-content: center;
        }

        .page-link {
            color: #17a2b8;
            margin-bottom: 3rem;
        }

        .page-item.active .page-link {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        .page-link:hover {
            color: #2780ba;
        }
        .image-container {
             position: relative;
             height: 10rem;
             overflow: hidden;
             
            }

        .category-badge {
            position: absolute;
            top: 5px;
            right: 5px;
            padding: 5px 10px;
            background-color: rgba(39,128,186, 0.6);
 
            color: #fff;
            font-size: 12px;
            border-radius: 12px 3px;
        }

    </style>
</head>
<body>
    @include('navbar')

    <div class="container">
    <form action="" method="GET">
    <div class="form-row align-items-end mt-3">
        <div class="col-md-3 mb-3 input">
            <input type="text" class="form-control" name="pretraga" placeholder="Pretraži najnovije vesti" value="{{ request()->input('pretraga') }}">
        </div>
        <div class="col-md-3 mb-3 input">
            <input type="date" class="form-control" name="date" value="{{ request()->input('date') }}">
        </div>
        <div class="col-md-2 mb-3">
            <button type="submit" class="btn btn-primary" style="background-color: #17a2b8; border-color: #17a2b8;">
                <i class="fas fa-search" style="color: white;"></i> 
            </button>
        </div>
    </div>
</form>

        <div class="row mt-4">
            @foreach ($news as $article)
            <div class="col-md-3 mb-4">
                <div class="card">
                    @if ($article['naslovna'])
                    <div class="image-container">
                        <div class="category-badge">{{ $article->category->category }}</div>
                        <img src="{{ asset('storage/naslovne/' . $article['naslovna']) }}" class="card-img-top" alt="Naslovna slika">
                    </div>

                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $article['naslov'] }}</h5>
                        <a href="/article/{{ $article['id'] }}" class="custom-btn-primary">Pročitaj više</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        @if ($news->previousPageUrl())
            <li class="page-item">
                <a class="page-link" style="background-color: #17a2b8; border-color: #17a2b8; color:white;" href="{{ $news->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo; Nazad</span>
                </a>
            </li>
        @endif
        
        @php
            $currentPage = $news->currentPage();
            $lastPage = $news->lastPage();
        @endphp
        
        @for ($i = max(1, $currentPage - 1); $i <= min($lastPage, $currentPage + 1); $i++)
            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                <a class="page-link" style="background-color: #17a2b8; border-color: #17a2b8; color:white;" href="{{ $news->url($i) }}">{{ $i }}</a>
            </li>
        @endfor
        
        @if ($news->nextPageUrl())
            <li class="page-item">
                <a class="page-link" style="background-color: #17a2b8; border-color: #17a2b8; color:white;" href="{{ $news->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true"> Napred &raquo;</span>
                </a>
            </li>
        @endif
    </ul>
</nav>


    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
   
</body>
 @include('footer')
</html>
