<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Prijava | Registracija</title>
  <link href="/css/login.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   
</head>
@include('navbar')
<body>

<div class="container" id="container">
 
        <div class="form-container sign-in">
          <form method = "POST" action="/login">
            @csrf
            <h1 class="h1-text">Prijava </h1 class="h1-text">
            <br/>
              <input type="text" id="email" placeholder="Unesite email " name ="email" required>
              <input type="password" id="password" placeholder="Unesite lozinku" name="password" required>
              <button type="submit">Prijavite se</button>
          </form>
        </div>
          <div class="toggle-container">
        <div class="toggle">
          <div class="toggle-panel toggle-right">
            <h1 class="h1-text">Dobrodošao nazad!</h1 class="h1-text">
            <p>
              Unesi svoje podatke, kako bi mogao da koristiš sve mogućnosti
              našeg sajta
            </p>
          </div>
        </div>
      </div>
    </div> 
      <script src="/js/script.js"></script>
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
