<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CMS</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/CMS/cms.css">
</head>
<style> 
     .btn-success1{
        margin-left:10px;
        color: white;
        padding: 9px 15px;
        border-radius: 5px;
        transition: all ease-in-out 0.2s;
        border: none;
        background-color:#17a2b8 ;
        border: 1px solid white;
        font-size: 14px;
    }
     .btn-success1:hover{
            background-color: #2780ba;
            color: white;
            transform: scale(1.1);
            text-decoration: none;
        }
    .thead { 
            background: #2780ba;
            color:white; 
        }
    input[type="checkbox"] {
            accent-color:#17a2b8 ;    
        }
    .naslov { 
            font-size: 1.5rem;
    }
    .dugme-container {
            display: flex;
            justify-content: space-between;
        }

        .dugme {
            width: 50%;
            }
        .dugme.active {
            background-color: #365487; }
            th:nth-child(4),
        td:nth-child(4) {
            max-width: 180px;
            overflow: hidden; 
            text-overflow: ellipsis;
            white-space: nowrap;
        }

</style> 
<body>
    @include('navbar')
    <div class="content container">
    <div class="dugme-container">
    <a href="#" class="dugme  btn-block mb-2" onclick="toggleEditUserContainer(this); setActiveButton(this)">Upravljanje korisnicima</a>
    <a href="#" class="dugme  btn-block" onclick="toggleTableArticle(this); setActiveButton(this)">Upravljanje člancima</a>
</div>


 </div>
 <div id="table-article" class="container" style="display: none;">
<h1 class="naslov">Upravljanje člancima</h1>
    <div class="container mt-4">
    <div class="row">
    <div class="col-md-6">
        <h3 class="mt-4 mt-md-0" style="border-radius: 5px; margin: 10px; background-color: #17a2b8; color: white; display: flex; justify-content: center; align-items: center; height: 4rem;font-size:20px; padding-top: 10px;">Zahtevi za brisanje: <span>{{$deleteRequests}}</span>@if ($deleteRequests > 0)
            <a href="/cms-editor/delete-requests" class="btn-success1">Vidi zahteve</a>
        @endif</h3>
        
    </div>
    <div class="col-md-6">
        <h3 class="mt-4 mt-md-0" style="border-radius: 5px; margin: 10px; background-color: #17a2b8; color: white; display: flex; justify-content: center; align-items: center; height: 4rem;font-size:20px; padding-top: 10px;">Zahtevi za izmenu: <span>{{$updateRequests}}</span> @if ($updateRequests > 0)
            <a href="/cms-editor/edit-requests" class="btn-success1"> Vidi zahteve</a>
        @endif</h3>
       
    </div>
</div>


            <br>
        <a href="/cms-editor/create" class="btn-success1">Kreiraj objavu</a>
    </div>

    <div class="container mt-4 md-4 ">
    <form class="form-inline mt-2 mb-2" action="" method="get">
    <div class="form-group mr-2">
        <input type="text" class="form-control" name="naslov" value="{{ request()->input('naslov') }}" placeholder="Unesite naslov">
    </div>
    <div class="form-group mr-2">
        <select class="form-control" name="draft">
            <option value="">Sve objave</option>
            <option value="0" {{ request()->input('draft') === '0' ? 'selected' : '' }}>Članak</option>
            <option value="1" {{ request()->input('draft') === '1' ? 'selected' : '' }}>Draft</option>
        </select>
    </div>
    <div class="form-group mr-2">
        <select class="form-control" name="rubrika">
            <option value="">Sve kategorije</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request()->input('rubrika') == $category->id ? 'selected' : '' }}>{{ $category->category }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary" style="background-color: #17a2b8; border-color: #17a2b8;">
        <i class="fas fa-search" style="color: white;"></i> 
    </button>
</form>



        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead">
                    <tr>
                        <th>ID</th>
                        <th>Korisnik</th>
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
                            <td>{{ $article->user->name }}</td>

                            <td>
                                <img src="{{ asset('storage/naslovne/' . $article->naslovna) }}" alt="" class="img-thumbnail" style="max-width: 100px;">
                            </td>
                            <td>{{ $article->naslov }}</td>
                            <td>{{ $article->category->category }}</td>
                            <td>{{ $article->draft }}</td>
                            <td>{{ $article->created_at }}</td>
                            <td style="height: auto;">
    @if ($article->draft == 1)
        <a href="/cms-editor/draft/{{$article->id}}" class="btn btn-info btn-block mb-2">Pogledaj draft</a>
        <a href="/cms-editor/draft/{{$article->id}}/allow" class="btn btn-info btn-block mb-2">Prebaci u članke</a>
    @else
        <a href="/cms-editor/article/{{$article->id}}" class="btn btn-info btn-block mb-2">Pogledaj članak</a>
        <a href="/cms-editor/article/{{$article->id}}/draft" class="btn btn-info btn-block mb-2">Prebaci u draftove</a>
    @endif
    <a href="/cms-editor/delete/{{$article->id}}" class="btn btn-danger btn-block">Izbriši</a>
</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <div id="container-edit-user" class="container" style="display: none;">
    <h1 class="naslov">Upravljanje Korisnicima</h1>


    <div class="container mt-4">
    <form action="" method="GET">
    <div class="form-row">
    <div class="col-md-4 mb-3">
        <label for="searchName">Ime:</label>
        <input type="text" class="form-control" name="name" value="{{ request()->input('name') }}">
    </div>
    <div class="col-md-4 mb-3">
        <label for="searchEmail">Email:</label>
        <input type="text" class="form-control" name="email" value="{{ request()->input('email') }}">
    </div>
    <div class="col-md-4 mb-3" style="display: flex; align-items: flex-end;">
    <button class="btn btn-primary form-control" type="submit" style="height: 38px; width: 38px; background-color: #17a2b8; border-color: #17a2b8;">
        <i class="fas fa-search" style="color: white;"></i>
    </button>
</div>
</div>

</form>

        <table class="table">
            <thead class="thead">
                <tr>
                    <th>Ime</th>
                    <th>Email</th>
                    <th>Kategorije</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($journalists as $journalist)
                    <tr>
                        <td>{{ $journalist['name'] }}</td>
                        <td>{{ $journalist['email'] }}</td>
                        <td>
                            <form action="/cms-editor/{{$journalist['id']}}/categories-update" method="post">
                                @csrf
                                @foreach ($categories as $category)
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" name="categories[]" value="{{ $category['id'] }}"
                                               @if(in_array($category['id'], $journalist['categoryIds'])) checked @endif>
                                        <label class="form-check-label">{{ $category['category'] }}</label>
                                    </div>
                                @endforeach
                        </td>
                        <td>
                                <button type="submit" class="btn-success1">Azuriraj</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="/js/script.js"></script>
</body>
@include('footer')
</html>
