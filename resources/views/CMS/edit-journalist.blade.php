<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Uredi novinara</title>
</head>
<body>
   @include('navbar')
<div class="container">
    <form method="POST" action="">
        @csrf
        <div class="row mt-4">
            <div class="col-md-6">
                <h3>{{ $journalist->name }} - rubrike</h3>
                <div class="list-group">
                    @foreach($allCategories as $category)
                        <label class="list-group-item">
                            <input type="checkbox" 
                                   name="categories[]" 
                                   value="{{ $category->id }}" 
                                   {{ in_array($category->id, $userCategories) ? 'checked' : '' }}
                            >
                            {{ $category->category }}
                        </label>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary mt-3">Sačuvaj</button>
            </div>
        </div>
    </form>
</div>

</body>
</html>