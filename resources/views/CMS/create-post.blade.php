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
        <button type="submit" class="btn btn-primary">Kreiraj objavu</button> 
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
