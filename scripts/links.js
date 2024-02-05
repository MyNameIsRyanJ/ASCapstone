let homeClick = document.querySelector(`.home-click`)
let accountClick = document.querySelector(`.account-click`)
let clashClick = document.querySelector(`#clash-link`)
let guessClick = document.querySelector(`#guess-link`)
let matchingClick = document.querySelector(`#matching-link`)

homeClick.addEventListener(`click`, (e) => {
    window.location.href = "index.html"
});

accountClick.addEventListener(`click`, (e) => {
    window.location.href = "account.html"
});

if (clashClick != null)
{
    clashClick.addEventListener(`click`, (e) => {
        window.location.href = "genre-selection.html?clash"
    });
}

if (guessClick != null)
{
    guessClick.addEventListener(`click`, (e) => {
        window.location.href = "genre-selection.html?guess"
    });
}

if (matchingClick != null)
{
    matchingClick.addEventListener(`click`, (e) => {
        window.location.href = "genre-selection.html?matching"
    });    
}

const queryString = window.location.search;
if (queryString == "?clash")
{
    document.querySelector(`#logo-text`).innerHTML = `<strong class="text-color-primary">Music</strong> <strong class="text-color-secondary">Clash</strong>`;
}
else if (queryString == "?guess")
{
    document.querySelector(`#logo-text`).innerHTML = `<strong class="text-color-primary">Guess</strong> <strong class="text-color-secondary">The Lyric</strong>`;
}
else if (queryString == "?matching")
{
    document.querySelector(`#logo-text`).innerHTML = `<strong class="text-color-primary">Album</strong> <strong class="text-color-secondary">Matching</strong>`;
}