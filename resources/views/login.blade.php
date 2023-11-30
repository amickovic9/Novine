<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login i Registracija</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

@include('navbar')

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h2 class="card-title">Login</h2>
          <form method = "POST" action="/login">
            @csrf
            <div class="form-group">
              <input type="text" class="form-control" id="email" placeholder="Unesite email " name ="email" required>
            </div>
            <div class="form-group">
              <input type="password" class="form-control" id="password" placeholder="Unesite lozinku" name="password" required>
            </div>
            <button type="submit" class="btn btn-secondary">Prijavite se</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h2 class="card-title">Registracija</h2>
          <form method="POST" action="/register">
            @csrf
            <div class="form-group">
              <input type="text" class="form-control" id="fullname" name= "fullname" placeholder="Unesite ime i prezime" required>
            </div>
            <div class="form-group">
              <input type="email" class="form-control" id="reg_email" name="reg_email" placeholder="Unesite email adresu" email required>
            </div>
            <div class="form-group">
              <input type="password" class="form-control" id="reg_password" name="reg_password" placeholder="Unesite lozinku" required>
            </div>
            <button type="submit" class="btn btn-secondary">Registrujte se</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
