function toggleEditUserContainer(clickedButton) {
    var editUserContainer = document.getElementById('container-edit-user');
    var tableArticleContainer = document.getElementById('table-article');
    
    if (editUserContainer.style.display === 'none') {
        editUserContainer.style.display = 'block';
        tableArticleContainer.style.display = 'none';
    } else {
        editUserContainer.style.display = 'none';
    }
    
    // Postavljamo aktivnu klasu na kliknuto dugme
    setActiveButton(clickedButton);
}

function toggleTableArticle(clickedButton) {
    var editUserContainer = document.getElementById('container-edit-user');
    var tableArticleContainer = document.getElementById('table-article');
    
    if (tableArticleContainer.style.display === 'none') {
        tableArticleContainer.style.display = 'block';
        editUserContainer.style.display = 'none';
    } else {
        tableArticleContainer.style.display = 'none';
    }
    
    setActiveButton(clickedButton);
}


function setActiveButton(clickedButton) {

    var buttons = document.querySelectorAll('.dugme');
    buttons.forEach(function(button) {
        button.classList.remove('active');
    });
    clickedButton.classList.add('active');
}
