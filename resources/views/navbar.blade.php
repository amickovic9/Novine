


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link rel="icon" href="images/fav-ico.ico" type="image/x-icon">

</head>
<style>
       @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');


*{
     margin: 0;
     padding: 0;
     box-sizing: border-box;
     font-family: 'Montserrat', sans-serif;
}
      .navbar { 
        background: #17a2b8;

      }
      .nav-link {
        background-color:#2780ba;
        border: 1px solid #2780ba;
        color:white;
        margin:5px 10px;
        padding: 10px 15px;
        border-radius: 5px;
        width:10rem;
        text-align:center;
      }
      .nav-link:hover { 
        border: 1px solid #fff;
        color:white;
        transition : all ease-in-out 0.3s;
      }
      .navbar-toggler{ 
        display:flex;
        justify-content:center;
        align-items:center;
      }
      

</style> 

<body>

<nav class="navbar navbar-expand-lg navbar">
<a class="navbar-brand" href="#">
    <img src="logo.png" alt="Logo" height="50">
</a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon" style="color: white;">
    <i class="fas fa-bars"></i>
</span>

  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/">Početna</a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="/about">O nama</a>
      </li>
      @if(Auth::check() && Auth::user()->role==4)
      <li class="nav-item">
        <a class="nav-link" href="/cms">CMS</a>
      </li>
      @endif
      @if(Auth::check() && Auth::user()->role==2)
      <li class="nav-item">
        <a class="nav-link" href="/cms-journalist">CMS</a>
      </li>
      @endif
      @if(Auth::check() && Auth::user()->role==3)
      <li class="nav-item">
        <a class="nav-link" href="/cms-editor">CMS</a>
      </li>
      @endif
      @auth
      <li class="nav-item">
        <a class="nav-link" href="/logout">Logout</a>
      </li>
      @else
      <li class="nav-item">
        <a class="nav-link" href="/login">Login</a>
      </li>
      @endauth
      
    </ul>
  </div>
</nav>
 @if(session('success'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
  @endif
  @if(session('danger'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('danger') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
  @endif

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
