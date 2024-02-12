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
        .custom-btn-primary {
            background-color: #17a2b8;
            color:white;
            padding: 9px 15px;
            border-radius: 5px; 
            transition:all ease-in-out 0.2s;
            border:none;
            margin: 10px  0px;
            text-align:center;
        }

        .custom-btn-primary:hover {
            background-color: #365486;
            color:white;
            transform:scale(1.01);
            text-decoration:none;

        }
        .custom-btn-secondary {
            background-color: #365486;
            color:white;
            padding: 9px 15px;
            border-radius: 5px; 
            transition:all ease-in-out 0.5s;
            border:none;
            width:100%;
        }

        .custom-btn-secondary:hover {
            background-color: #365487;
            color:white;
            transform:scale(1.01);
            text-decoration:none
        }
        .thead { 
            background-color: #365486;
            color: white;
        }
        .td-naslov {
            width:200px;
        }
        .h1-text { 
            color:black;
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

    </style>
</head>
<body>
    @include('navbar')
<div class="content container">
<div class="dugme-container">
<a href="#" class="dugme" onclick="toggleEditUserContainer(this)">Upravljanje korisnicima</a>
<a href="#" class="dugme" onclick="toggleTableArticle(this)">Upravljanje člancima</a>

</div>
 </div> 
    <div id="container-edit-user" class="container" style="display: none;">
    <h1 class="naslov">Upravljanje Korisnicima</h1>
    <form action="">
        <div class="form-row">
            <div class="col-4 mb-3">
                <label for="inputName">Ime:</label>
                <input type="text" class="form-control" id="inputName" name="name" value="{{ request()->input('name') }}">
            </div>
            <div class="col-4 mb-3">
                <label for="inputEmail">Email:</label>
                <input type="text" class="form-control" id="inputEmail" name="email" value="{{ request()->input('email') }}">
            </div>
            <div class="col-4 mb-3">
                <label for="inputRole">Role:</label>
                <input type="text" class="form-control" id="inputRole" name="role" value="{{ request()->input('role') }}">
            </div>
        </div>
        <button class="custom-btn-primary" type="submit">Pretraži</button>
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
</div>

<div id="table-article" class="container" style="display: none;">
<h1 class="naslov">Upravljanje člancima</h1>
<div class="dugme-container">
        <a href="/cms/create-post" class="dugme">Dodaj objavu</a>
        <a href="/cms/categories" class="dugme">Upravljanje rubrikama</a>
        <a href="/cms/delete-requests" class="dugme">Upravljanje zahtevima za brisanje</a>
        <a href="/cms/edit-requests" class="dugme">Upravljanje zahtevima za izmene</a>
        </div>
<form action="">
        <div class="form-row">
            <div class="col-4 mb-3">
                <label for="inputName">Naslov:</label>
                <input type="text" class="form-control" id="inputName" name="naslov" value="{{ request()->input('naslov') }}">
            </div>
            <div class="col-md-3 mb-3">
                    <label for="rubrika">Rubrika</label>
                    <select name="rubrika" class="form-control">
                        <option value="">Izaberi</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if ($category->id == request()->input('rubrika')) selected @endif>{{ $category->category }}</option>
                        @endforeach
                    </select>
                </div>
            
        </div>
        <button class="custom-btn-primary" type="submit">Pretraži</button>
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
</div>

    <script src="/js/script.js"></script>
</body>

</html>
