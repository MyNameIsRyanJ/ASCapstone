let homeClick = document.querySelector(`.home-click`)
let accountClick = document.querySelector(`.account-click`)
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
if (queryString == "?matching")
{
    document.querySelector(`#genre-content`).style.backgroundColor = `#E6E1E0`;
    document.querySelector(`#logo-text`).innerHTML = `<strong class="text-color-primary">Album</strong> <strong class="text-color-secondary">Matching</strong>`;
}
else if (queryString == "?guess")
{
    document.querySelector(`#genre-content`).style.backgroundColor = `#DFE6E0`;
    document.querySelector(`#logo-text`).innerHTML = `<strong class="text-color-primary">Guess</strong> <strong class="text-color-secondary">The Lyric</strong>`;
}

if (genreSelectors[0] != null)
{
    console.log(genreSelectors[0]);
    for (let selector = 0; selector < genreSelectors.length; selector++)
    {
        genreSelectors[selector].addEventListener(`click`, (e) => {
            if (queryString == "?matching")
            {
                window.location.href = `matching.php?genre=${e.target.innerHTML}`
            }
            else if (queryString == "?guess")
            {
                window.location.href = `guess.php?genre=${e.target.innerHTML}`
            }
        });
    }
    genreSelectorRandom.addEventListener(`click`, (e) => {
        let randomSelection = Math.floor(Math.random() * 8);
        let selection = genreSelectors[randomSelection].innerHTML;
        if (queryString == "?guess")
        {
            window.location.href = `guess.php?genre=${selection}`
        }
        else if (queryString == "?matching")
        {
            window.location.href = `matching.php?genre=${selection}`
        }
    });
}