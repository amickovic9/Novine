@include('navbar')
<title>Registruj novog korisnikaa</title>
<link href="/css/register.css" rel="stylesheet">
<body>

<div class="form-container sign-up">
          
          <form method="POST" action="/cms/register">
            @csrf
            <h1 class="h1-text">Kreirajte nalog</h2>
          <br/>
              <input type="text" id="fullname" name= "fullname" placeholder="Unesite ime i prezime" required>
              <input type="email" id="reg_email" name="reg_email" placeholder="Unesite email adresu" email required>
              <input type="password" id="reg_password" name="reg_password" placeholder="Unesite lozinku" required>
            
            <button type="submit" class="sign-up-btn">Registrujte korisnika</button>
          </form>
        </div>
</body>