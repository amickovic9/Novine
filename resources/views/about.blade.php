<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');


*{
     margin: 0;
     padding: 0;
     box-sizing: border-box;
     font-family: 'Montserrat', sans-serif;
}
        body {
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .grid-item {
            overflow: hidden;
        }

        .grid-item img {
            width: 100%;
            height: auto;
        }

        .services ul {
            margin:  50px 50px;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            
           
            
        }

        .services h2 {
            border-bottom: 1px solid #333;
            padding-bottom: 10px;
        }

        .services ul {
            list-style: none;
            padding: 0;
        }
        .services ul li p { 
            font-weight: 300;
        }

        .services ul li {
            margin: 10px 5px;
            display: flex;
            flex-direction: column; 
            align-items: center; 
            justify-content: center;
            border-radius: 15px;
            padding: 25px 15px;
            width: 25%;
            height: 30vh;
            background: linear-gradient(to right, #2780ba,#17a2b8);

        }
        .services ul li:hover { 
            transform:scale(1.03);
            transition:all ease-in-out 0.5s;
        }

        .fas {
            margin-right: 10px;
            font-size: 50px;
            color:white;
        }
        .map { 
            width: 80%;
        }
        #map {
            height: 400px;
            width: 100%;
        } 
         p{
            font-size:1rem;
        }
        .h1-naslov { 
            font-size:2rem;
            font-weight: 500;
            margin-top:40px;
        }
        .h2-naslov{
            font-size:1.4rem;
            margin-top:40px;
        }
        .text { 
            color: white;
            font-size:1.2rem;
            font-weight: bold;
        }
        .lokacija { 
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    @media screen and (max-width: 768px) {
    .container {
        padding: 10px;
    }
    .grid {
            grid-template-columns: repeat(1, 1fr);
        }
    .services ul {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .services ul li {
        display: flex; 
        flex-direction: column;
        align-items: center;
        text-align: center;
        width: 100%;
    }

    p { 
        font-size: 17px;
    }

    h1,h2 { 
        font-size:22px;
    }
}
    </style>
      

</head>
<body>
@include('navbar') 
    <div class="container">
        <section class="grid">
            <div class="grid-item">
                <img src="images/slika3.jpg" alt="Image 1">
            </div>
            <div class="grid-item">
                <h1 class="h1-naslov"> Dobrodošli u Novinsku Agenciju Može 6!</h1><br>
                <p>

                    Mi smo dinamična ekipa novinara, fotografa i istraživača koji su posvećeni pružanju najnovijih i najtačnijih informacija našoj publici. Sa strašću za istinom i profesionalnom etikom, mi smo vaša izvor pravih, relevantnih i relevantnih vesti.</p>
            </div>
            <div class="grid-item">
                <h2 class="h2-naslov">Naša ponuda usluga obuhvata sve aspekte novinarstva, uključujući:</h2>
                <br><p>

                    Novinske vijesti: Pratimo aktuelne događaje i pružamo tačne i relevantne vesti našoj publici.<br>
                    Izvještavanje uživo: Putem naših live prenosa, omogućavamo vam da budete u toku sa dešavanjima u realnom vremenu.<br>
                    Fotoreportaže: Naši fotografi beleže ključne trenutke i vizuelno predstavljaju priče naših članaka.<br>
                    Novinarske analize: Duboko se uranjamo u teme i pružamo objektivne analize i komentare o aktuelnim događajima i trendovima.</p>
            </div>
            <div class="grid-item">
                <img src="images/slika2.png" alt="Image 2">
            </div>
            <div class="grid-item">
                <img src="images/slika3.png" alt="Image 3">
            </div>
            <div class="grid-item">
                <br><p>Verujemo u moć novinarstva da informiše, obrazuje i osnažuje ljude. Naš cilj je da budemo vaš pouzdan izvor informacija i da vas podržimo u vašem putovanju kroz svet vesti i događaja.

                    Hvala vam što ste izabrali Novinsku Agenciju XYZ. Pratite nas kako biste ostali u toku sa najnovijim vestima i događajima.</p>
            </div>
        </section>
    </div>
    
    <div class="lokacija">
        
        <h2>Lokacija</h2><br>
    <section class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2869.1180265544244!2d20.90285717602273!3d44.01895547108717!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4757213a3f69a34f%3A0x9acc30ed949db9b7!2z0KTQsNC60YPQu9GC0LXRgiDQuNC90LbQtdGa0LXRgNGB0LrQuNGFINC90LDRg9C60LAg0KPQvdC40LLQtdGA0LfQuNGC0LXRgtCwINGDINCa0YDQsNCz0YPRmNC10LLRhtGD!5e0!3m2!1ssr!2srs!4v1707679286327!5m2!1ssr!2srs" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>    
    </section>
    </div>
    <div class="container">
        <section class="services">
            <h2 class="h2-naslov">Naše usluge</h2>
            <ul>
                <li><i class="fas fa-newspaper"></i><p class="text">Novinske vijesti</p></li>
                <li><i class="fas fa-microphone"></i> <p class="text">Izveštavanje uživo</p></li>
                <li><i class="fas fa-camera"></i><p class="text">Fotoreportaže</p> </li>
                <li><i class="fas fa-edit"></i><p class="text">Novinarske analize</p> </li>
            </ul>
        </section>
    </div>
</body>
@include('footer')
</html>
