<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Moji članci</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
       @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');


*{
     margin: 0;
     padding: 0;
     box-sizing: border-box;
     font-family: 'Montserrat', sans-serif;
}
.btn-success1{
        margin-bottom: 10px;
        color: white;
        padding: 9px 15px;
        border-radius: 5px;
        transition: all ease-in-out 0.2s;
        border: none;
        background-color: #17a2b8;
    }
    .btn-success1:hover{
            background-color: #365486;
            color: white;
            transform: scale(1.1);
            text-decoration: none;
        }
      
</style>
<body>
@include('navbar')
    <div class="container mt-4">
        <h1>Moji članci</h1>
        @foreach ($articles as $article)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{$article->naslov}}</h5>
                <a href="/cms-journalist/article/{{$article->id}}" class="btn-success1">Detalji</a>
            </div>
        </div>
        @endforeach
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
