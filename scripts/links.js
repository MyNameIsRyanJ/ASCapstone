let homeClick = document.querySelector(`.home-click`)
let accountClick = document.querySelector(`.account-click`)
let clashClick = document.querySelector(`#clash-link`)
let guessClick = document.querySelector(`#guess-link`)
let matchingClick = document.querySelector(`#matching-link`)

let genreSelectors = document.querySelectorAll(`.genre-selector`)
let genreSelectorRandom = document.querySelector(`#genre-selector-last`)

homeClick.addEventListener(`click`, (e) => {
    window.location.href = "index.php"
});

accountClick.addEventListener(`click`, (e) => {
    window.location.href = "account.php"
});

if (clashClick != null)
{
    clashClick.addEventListener(`click`, (e) => {
        window.location.href = "genre-selection.php?clash"
    });
}

if (guessClick != null)
{
    guessClick.addEventListener(`click`, (e) => {
        window.location.href = "genre-selection.php?guess"
    });
}

if (matchingClick != null)
{
    matchingClick.addEventListener(`click`, (e) => {
        window.location.href = "genre-selection.php?matching"
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

if (genreSelectors != null)
{
    for (let selector = 0; selector < genreSelectors.length; selector++)
    {
        genreSelectors[selector].addEventListener(`click`, (e) => {
            if (queryString == "?clash")
            {
                window.location.href = `clash.php?${e.target.innerHTML}`
            }
            else if (queryString == "?guess")
            {
                window.location.href = `guess.php?${e.target.innerHTML}`
            }
            else if (queryString == "?matching")
            {
                window.location.href = `matching.php?${e.target.innerHTML}`
            }
        });
    }
    genreSelectorRandom.addEventListener(`click`, (e) => {
        let randomSelection = Math.floor(Math.random() * 8);
        let selection = genreSelectors[randomSelection].innerHTML;
        if (queryString == "?clash")
        {
            window.location.href = `clash.php?${selection}`
        }
        else if (queryString == "?guess")
        {
            window.location.href = `guess.php?${selection}`
        }
        else if (queryString == "?matching")
        {
            window.location.href = `matching.php?${selection}`
        }
    });
}