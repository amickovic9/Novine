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
<style>
     .custom-btn-primary {
            background-color: #17a2b8;
            color:white;
            padding: 10px 15px;
            border-radius: 5px; 
            transition:all ease-in-out 0.5s;
            border:none;
            margin-bottom:20px
        }

        .custom-btn-primary:hover {
            background-color: #2780ba;
            color:white;
            transform:scale(1.1);
        }
        #tagsContainer { 
            margin-top: 10px;
            font-size:12px;

        }
        .tag-box {
            display: inline-block;
            padding: 5px;
            margin: 5px;
            border-radius: 5px;
            color: black;
        }

        .tags-frame {
            padding: 5px;
            border-radius: 5px;
        }
</style>
<body>

@include('navbar')

<div class="container mt-4">
    <form action="" method="POST" onsubmit="submitForm()" enctype="multipart/form-data">
        @csrf 
        <div class="form-group">
            <label for="naslov">Naslov članka</label>
            <input type="text" name="naslov" required class="form-control" id="naslov"> 
        </div>
        <div>
            <input type="file" name = "naslovna">
        </div>
       <div class="form-group">
            <label for="tekst" name="tekst">Tekst članka</label>
            <div id="editor" name="tekst"></div> 
            <input type="hidden" name="tekst" name ="tekst">
        </div>
        
        <div class="form-group">
            <label for="rubrika">Odaberi rubriku</label>
            <select name="rubrika" class="form-control" id="rubrika">
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->category}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
             <input id="tagovi" class="form-control" placeholder="Tagovi" name="tagovi">
         <div id="tagsContainer"></div>
        <div class="form-group">
            Foto/video
                
            <input type="file" name="files[]" id="files" multiple>
        </div>

        <button type="submit" class=" custom-btn-primary">Kreiraj objavu</button> 
    </form>
</div>
<script src="/js/script.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script> <!-- Skripta za Quill -->
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
