//skripta za tabove na CMS-u
function toggleEditUserContainer() {
    document.getElementById('container-edit-user').style.display = 'block';
    document.getElementById('table-article').style.display = 'none';
    localStorage.setItem('activeTab', 'container-edit-user');
}

function toggleTableArticle() {
    document.getElementById('table-article').style.display = 'block';
    document.getElementById('container-edit-user').style.display = 'none';
    localStorage.setItem('activeTab', 'table-article');
}

window.onload = function() {
    var activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
        if (activeTab === 'container-edit-user') {
            toggleEditUserContainer();
        } else if (activeTab === 'table-article') {
            toggleTableArticle();
        }
    }
}
function setActiveButton(clickedButton) {
    var buttons = document.querySelectorAll('.dugme');
    buttons.forEach(function(button) {
        button.classList.remove('active');
    });
    clickedButton.classList.add('active');
}

//skripta za galeriju

document.addEventListener('DOMContentLoaded', function () {
    var scrollLeftButton = document.getElementById('scrollLeft');
    var scrollRightButton = document.getElementById('scrollRight');
    var imageTrack = document.getElementById('image-track');
    var largeImage = document.querySelector('.large-image');
    var firstImage = imageTrack.querySelector('img');

    if (firstImage) {
        largeImage.src = firstImage.src;
        firstImage.classList.add('selected-image');
    }

    scrollLeftButton.addEventListener('click', function() {
        imageTrack.scrollLeft -= imageTrack.clientWidth; 
    });

    scrollRightButton.addEventListener('click', function() {
        imageTrack.scrollLeft += imageTrack.clientWidth; 
    });

    imageTrack.addEventListener('click', function (event) {
        if (event.target.tagName === 'IMG') {
            var selectedImage = document.querySelector('.selected-image');
            if (selectedImage) {
                selectedImage.classList.remove('selected-image');
            }

            event.target.classList.add('selected-image');
            largeImage.src = event.target.src;
        }
    });
});



//skripta za tagove i njegove boje 

var tagColors = {};

document.getElementById("tagovi").addEventListener("input", function() {
    var tagInput = this.value.trim().split(" "); 
    var coloredTags = tagInput.map(function(word) {
        if (!tagColors[word]) {
            tagColors[word] = getRandomDarkColor();
        }
        return '<div class="tag-box" style="background-color: ' + tagColors[word] + ';">#' + word + '</div>';
    });
    document.getElementById("tagsContainer").innerHTML = '<div class="tags-frame">' + coloredTags.join(" ") + '</div>';
});
function getRandomDarkColor() {
    var letters = "0123456789ABCDEF";
    var color = "#";
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 6) + 10];
    }
    return color;
}

