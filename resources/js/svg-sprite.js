document.body.insertAdjacentHTML('afterbegin','<div class="svg-sprite"></div>');
fetch('/images/sprite.svg')
    .then(r => r.text())
    .then(response => {
        div = document.querySelector('.svg-sprite')
        div.innerHTML = response;
    })
    .catch(console.error.bind(console));

document.body.insertAdjacentHTML('afterbegin','<div class="svg-sprite-previews"></div>');
fetch('/images/sprite-previews.svg')
    .then(r => r.text())
    .then(response => {
        div = document.querySelector('.svg-sprite-previews')
        div.innerHTML = response;
    })
    .catch(console.error.bind(console));
