<?php
use App\Services\TextFormattingService;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kreiraj objavu</title>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
         @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

            * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }
        .custom-btn-primary {
            background-color: #17a2b8;
            color:white;
            padding: 10px 15px;
            border-radius: 5px; 
            transition:all ease-in-out 0.5s;
            border:none;
        }

        .custom-btn-primary:hover {
            background-color: #2780ba;
            color:white;
            transform:scale(1.1);
        }
    </style>
</head>

<body>

@include('navbar')

<div class="container mt-4">
    <form action="/cms/create-post" method="POST" enctype="multipart/form-data">
        @csrf 
        <div class="form-group">
            <input type="text" name="naslov" required placeholder="Naslov članka" class="form-control"> 
        </div>
        <div>
            <input type="file" name = "naslovna">
        </div>
        <div class="form-group">
            <br>
            <label for="tekst">Tekst članka</label>
            <div id="editor"></div> 
            <input type="hidden" name="tekst">
        </div>
        <div class="form-group">
            <select name="rubrika" class="form-control">
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->category}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <input type="text" name="tagovi" id="tagovi" class="form-control" placeholder="Tagovi">
        </div>
        <div class="form-group">
            Foto/video
                
            <input type="file" name="files[]" id="files" multiple>
        </div>

        <button type="submit" class=" custom-btn-primary">Kreiraj objavu</button> 
    </form>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script >
var quill = new Quill('#editor', {
    theme: 'snow'
});

var form = document.querySelector('form');
form.onsubmit = function() {
    var tekstInput = document.querySelector('input[name=tekst]');
    tekstInput.value = JSON.stringify(quill.getContents());
};
</script>
</body>
</html>
