<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CMS</title>
    
    <link rel="stylesheet" href="css/CMS/cms.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .menu-container {
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .menu-item {
            margin-bottom: 15px;
        }
        .naslov { 
            font-size: 1.5rem;
        }
        
        .thead { 
            background-color: #2780ba;
            color: white;
        }
        .td-naslov {
            width:200px;
        }
        .h1-text { 
            color:black;
        }
        

    </style>
</head>
<body>
    @include('navbar')
<div class="content container">
<div class="dugme-container">
    <a href="#" class="dugme  btn-block mb-2" onclick="toggleEditUserContainer(this); setActiveButton(this)">Upravljanje korisnicima</a>
    <a href="#" class="dugme btn-block" onclick="toggleTableArticle(this); setActiveButton(this)">Upravljanje člancima</a>
</div>

 </div> 
    <div id="container-edit-user" class="container" style="display: none;">
    <h1 class="naslov">Upravljanje Korisnicima</h1>
    <form action="" class="form-inline">
    <div class="row align-items-end">
        <div class="col-md-3 mb-3">
            <input type="text" class="form-control mr-3 mb-2" placeholder="Ime:" id="inputName" name="name" value="{{ request()->input('name') }}">
        </div>
        <div class="col-md-3 mb-3">
            <input type="text" class="form-control mr-3 mb-2" placeholder="Email:" id="inputEmail" name="email" value="{{ request()->input('email') }}">
        </div>
        <div class="col-md-3 mb-3">
            <input type="text" class="form-control mr-3 mb-2" placeholder="Rola:" id="inputRole" name="role" value="{{ request()->input('role') }}">
        </div>
        <div class="col-md-3 mb-3">
            <button class="custom-btn-primary ml-2 mb-2" type="submit">
                <i class="fas fa-search" style="color: white;"></i>
            </button>
        </div>
    </div>
</form>


    <a href="/cms/create-user" class="custom-btn-primary">Registruj korisnika</a>
    
    <table class="table mt-4">
        <thead class="thead">
            <tr>
                <th>Ime</th>
                <th>Email</th>
                <th>Role</th>
                <th>Akcije</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user['name'] }}</td>
                <td>{{ $user['email'] }}</td>
                <td>{{ $user['role'] }}</td>
                <td>
                    <a href="/cms/edit-user/{{ $user['id'] }}" class="custom-btn-primary">Izmeni</a>
                    <a href="/cms/delete-user/{{ $user['id'] }}" class="btn btn-danger">Izbriši</a>
                    @if ($user['role'] > 1)
                        <a href="/cms/edit-user/{{ $user['id'] }}/categories" class="custom-btn-secondary">Kategorije</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        @if ($users->previousPageUrl())
            <li class="page-item">
                <a class="page-link" style="background-color: #17a2b8; border-color: #17a2b8; color:white;" href="{{ $users->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo; Nazad</span>
                </a>
            </li>
        @endif
        
        @php
            $currentPageUsers = $users->currentPage();
            $lastPageUsers = $users->lastPage();
        @endphp
        
        @for ($i = max(1, $currentPageUsers - 1); $i <= min($lastPageUsers, $currentPageUsers + 1); $i++)
            <li class="page-item {{ $i == $currentPageUsers ? 'active' : '' }}">
                <a class="page-link" style="background-color: #17a2b8; border-color: #17a2b8; color:white;" href="{{ $users->url($i) }}">{{ $i }}</a>
            </li>
        @endfor
        
        @if ($users->nextPageUrl())
            <li class="page-item">
                <a class="page-link" style="background-color: #17a2b8; border-color: #17a2b8; color:white;" href="{{ $users->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true"> Napred &raquo;</span>
                </a>
            </li>
        @endif
    </ul>
</nav>
</div>

<div id="table-article" class="container" style="display: none;">
<h1 class="naslov">Upravljanje člancima</h1>
<div class="dugme-container">
        <a href="/cms/create-post" class="dugme btn-block mb-2">Dodaj objavu</a>
        <a href="/cms/categories" class="dugme btn-block mb-2">Upravljanje rubrikama</a>
        <a href="/cms/delete-requests" class="dugme btn-block mb-2">Upravljanje zahtevima za brisanje</a>
        <a href="/cms/edit-requests" class="dugme btn-block" >Upravljanje zahtevima za izmene</a>
        </div>
        <form action="" class="form-inline">
    <div class="row align-items-end">
        <div class="col-md-4 mr-4 mb-3">
            <label for="inputName">Naslov:</label>
            <input type="text" class="form-control mr-2 mb-2" id="inputName" name="naslov" value="{{ request()->input('naslov') }}">
        </div>
        <div class="col-md-3 mr-3 mb-3">
            <label for="rubrika">Rubrika:</label>
            <select name="rubrika" class="form-control mr-2 mb-2">
                <option value="">Izaberi</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @if ($category->id == request()->input('rubrika')) selected @endif>{{ $category->category }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 mr-3 mb-3">
            <button class="custom-btn-primary ml-2 mb-2" type="submit">
                <i class="fas fa-search" style="color: white;"></i>
            </button>
        </div>
    </div>
</form>

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
            @foreach ($posts as $post)
            <tr class="visina-reda">
                <td>{{ $post->id }}</td>
                <td>{{ $post->user->name }}</td>


                <td>
                    <img src="{{ asset('storage/naslovne/' . $post->naslovna) }}" alt="" class="img-thumbnail" style="max-width: 100px;">
                </td>
                <td class="td-naslov">{{ $post->naslov }}</td>
                <td>{{ $post->category->category }}</td>
                <td>{{ $post->draft }}</td>
                <td>{{ $post->created_at }}</td>
                <td>
                    <div class="button-container">
                    <a href="/cms/delete/{{ $post->id }}" class="btn btn-danger">Izbriši</a>
                    <a href="/cms/edit-article/{{ $post->id }}" class="custom-btn-primary">Izmeni</a>
                    @if (!$post->draft)
                        <a href="/cms/return-to-draft/{{ $post->id }}" class="custom-btn-secondary">Vrati u draft</a>
                    @else
                    <a href="/cms/allow/{{ $post->id }}" class="custom-btn-secondary">Prebaci u clanak</a>

                    @endif
        </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        @if ($posts->previousPageUrl())
            <li class="page-item">
                <a class="page-link" style="background-color: #17a2b8; border-color: #17a2b8; color:white;" href="{{ $posts->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo; Nazad</span>
                </a>
            </li>
        @endif
        
        @php
            $currentPagePosts = $posts->currentPage();
            $lastPagePosts = $posts->lastPage();
        @endphp
        
        @for ($i = max(1, $currentPagePosts - 1); $i <= min($lastPagePosts, $currentPagePosts + 1); $i++)
            <li class="page-item {{ $i == $currentPagePosts ? 'active' : '' }}">
                <a class="page-link" style="background-color: #17a2b8; border-color: #17a2b8; color:white;" href="{{ $posts->url($i) }}">{{ $i }}</a>
            </li>
        @endfor
        
        @if ($posts->nextPageUrl())
            <li class="page-item">
                <a class="page-link" style="background-color: #17a2b8; border-color: #17a2b8; color:white;" href="{{ $posts->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true"> Napred &raquo;</span>
                </a>
            </li>
        @endif
    </ul>
</nav>
</div>

    <script src="/js/script.js"></script>
</body>
@include('footer')
</html>
