<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Novosti</title>
</head>
<body>
    @include('navbar')  
    <h1>{{$article['naslov']}}</h1>
    <p>{{$article['tekst']}}</p>
    <p>Iz rubrike: {{$article['Rubrika']}}</p>

    <h1>Komentari</h1>
    <form action="/add-comment" method="post">
    @csrf
    <input type="number" name = "article_id" hidden value={{$article['id']}}>   
    <input type="text" required placeholder="Ime" name="user_name">    
    <input type="textarea" required placeholder="Komentar" name = "comment"> 
    <button type="submit">Dodaj komentar</button>    
    </form>
</body>
</html>