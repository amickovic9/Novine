<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CMS</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/jouranlist/cms.css">
</head>
<style>
    
    .h1-text {
    margin-bottom: 20px;
    font-size: 2rem;
    }
    .btn-success2
    ,.btn-success1{
        margin-bottom: 10px;
        color: white;
        padding: 9px 15px;
        border-radius: 5px;
        transition: all ease-in-out 0.2s;
        border: none;
    }
    .btn-success1{ 
        background-color:#17a2b8 ;
    }
    .btn-success2{ 
        background-color:red ;
        
    }

        .btn-success1:hover{
            background-color: #2780ba;
            color: white;
            transform: scale(1.1);
            text-decoration: none;
        }
        .btn-success2:hover { 
            text-decoration: none;
            color: white;
            background-color: #cc0000;

        }

        .form-row{ 
            margin-top: 20px;
        }
        .thead-dark1 { 
            background: #2780ba;
            color:white; 
        }
</style> 
<body>
    @include('navbar')
    <div class="container mt-4">
    <h1 class="h1-text">Kontrolna tabla</h1>
    
<div class="mb-3">
            <a href="/cms-journalist/create-post" class="btn-success1">Novi članak</a>
           
        </div>
    <form action="" method="GET">
        
    <form class="form-inline" action="" method="get">
    <div class="form-row align-items-center">
        <div class="col-md-4 mb-3">
            <input type="text" class="form-control" name="naslov" placeholder="Naslov" value="{{ request('naslov') }}">
        </div>
        <div class="col-md-4 mb-3">
            <input type="text" class="form-control" name="rubrika" placeholder="Naziv rubrike" value="{{ request('rubrika') }}">
        </div>
        <div class="col-md-3 mb-3">
            <select name="draft" class="form-control">
                <option value="" {{ (request('draft') == '') ? 'selected' : '' }}>Svi članci</option>
                <option value="1" {{ (request('draft') == '1') ? 'selected' : '' }}>Samo draft članci</option>
                <option value="0" {{ (request('draft') == '0') ? 'selected' : '' }}>Samo objavljeni članci</option>
            </select>
        </div>
        <div class="col-md-1 mb-2">
            <button type="submit" class="btn btn-success1" style="background-color: #17a2b8;">
                <i class="fas fa-search" style="color: white;"></i>
            </button>
        </div>
    </div>
</form>


    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark1">
                <tr>
                    <th>ID</th>
                    <th>Slika</th>
                    <th>Naslov</th>
                    <th>Kategorija</th>
                    <th>Draft</th>
                    <th>Kreirano</th>
                    <th>Akcije</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articles as $article)
                    <tr>
                        <td>{{ $article->id }}</td>
                        <td>
                        <img src="{{ asset('storage/naslovne/' . $article->naslovna) }}" alt="Slika" class="img-thumbnail" style="max-width: 100px;">

                        </td>
                        <td>{{ $article->naslov }}</td>
                        <td>{{ $article->category->category }}</td>
                        <td>{{ $article->draft }}</td>
                        <td>{{ $article->created_at }}</td>
                        <td>
                            @if ($article->draft)
                                <a href="/cms-journalist/edit/{{$article->id}}" class="btn-success1">Izmeni</a>
                                <a href="/cms-journalist/delete/{{$article->id}}" class="btn-success2">Izbrisi</a>
                            @else
                                @if ($article->deleteRequestSent)
                                    <p class="text-danger">Zahtev za brisanje je već poslat!</p>
                                @else
                                    <a href="/cms-journalist/article/{{$article->id}}/request-delete" class="btn-success2">Zahtev za brisanje</a>
                                @endif
                                
                                @if ($article->updateRequestSent)
                                    <p class="text-danger">Zahtev za izmenu je već poslat!</p>
                                @else
                                    <a href="/cms-journalist/article/{{$article->id}}" class="btn-success2">Zahtev za izmenu</a>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        @if ($articles->previousPageUrl())
            <li class="page-item">
                <a class="page-link" style="background-color: #17a2b8; border-color: #17a2b8; color:white;" href="{{ $articles->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo; Nazad</span>
                </a>
            </li>
        @endif

        @php
            $currentPageArticles = $articles->currentPage();
            $lastPageArticles = $articles->lastPage();
        @endphp

        @for ($i = max(1, $currentPageArticles - 1); $i <= min($lastPageArticles, $currentPageArticles + 1); $i++)
            <li class="page-item {{ $i == $currentPageArticles ? 'active' : '' }}">
                <a class="page-link" style="background-color: #17a2b8; border-color: #17a2b8; color:white;" href="{{ $articles->url($i) }}">{{ $i }}</a>
            </li>
        @endfor

        @if ($articles->nextPageUrl())
            <li class="page-item">
                <a class="page-link" style="background-color: #17a2b8; border-color: #17a2b8; color:white;" href="{{ $articles->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true"> Napred &raquo;</span>
                </a>
            </li>
        @endif
    </ul>
</nav>
    </div>
</div>

        
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
@include('footer')
</html>
