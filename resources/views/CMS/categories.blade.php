<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rubrike</title>
    <link href="/css/CMS/rubrike.css" rel="stylesheet">
</head>
<body>

@include('navbar')

<div class="container ">
    <div class="row1">
        <div class="">
            <h1 class="naslov1">Dodaj Rubriku</h1>
            <form action="/cms/add-category" method="POST">
                @csrf 
                <div class="form-group">
                    <label for="categoryName">Naziv Rubrike:</label>
                    <input type="text" class="form-control" id="categoryName" name="category" required>
                </div>
                <button type="submit" class="dodaj-btn">Dodaj Rubriku</button>
            </form>
        </div>
    </div>

    <hr>

    <h1 class="naslov1">Rubrike</h1>
    <div class="row1">
        @foreach ($categories as $category)
        <div class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="naziv">Naziv rubrike:</h5>
                    <form action="/cms/edit-category/{{$category['id']}}" method="POST">
                        @csrf
                        <div class="input-group1">
                            <input type="text" class="input-box" value="{{$category['category']}}" name='nameOfCategory'>
                            <div class="input-group-append1">
                                <button class="izmeni-btn-naziv" type="submit">Izmeni naziv</button>
                                <a href="/cms/delete-category/{{$category['id']}}" class="izbrisi-rubriku-btn">Izbrisi rubriku</a>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
</body>
</html>
