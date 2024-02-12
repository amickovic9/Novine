
var quill = new Quill('#editor', {
    theme: 'snow' // Postavi temu editora
});

// Kada se forma pošalje, postavi sadržaj editora u skriveno polje
var form = document.querySelector('form');
form.onsubmit = function() {
    // Postavi HTML sadržaj iz Quill editora u skriveno polje
    var tekst = document.querySelector('input[name=tekst]');
    tekst.value = quill.root.innerHTML;
};


