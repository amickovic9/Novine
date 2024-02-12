<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Uredi novinara</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style> 
  input[type="checkbox"] {
    accent-color:#17a2b8 ;    
}
</style> 
</head>

<body>
    @include('navbar')
    <div class="container mt-4">
        <form method="POST" action="">
            @csrf
            <h3>{{ $journalist->name }} - rubrike</h3>
            <div class="row">
                @foreach($allCategories as $category)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                        <label class="list-group-item">
                            <input type="checkbox" 
                                   name="categories[]" 
                                   value="{{ $category->id }}" 
                                   {{ in_array($category->id, $userCategories) ? 'checked' : '' }}
                            >
                            {{ $category->category }}
                        </label>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary mt-3" style="background-color: #17a2b8; border-color: #17a2b8;">Sačuvaj</button>
        </form>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</body>
</html>
