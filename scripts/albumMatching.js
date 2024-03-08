var titles = document.querySelectorAll(`.matching-title`);
var tracks = document.querySelectorAll(`.matching-track`);
var titleAreas = document.querySelectorAll(`.matching-title-area`);
var trackAreas = document.querySelectorAll(`.album-matching-guesses`);
var selectionArea = document.querySelector(`#album-matching-stage-1-options`);
var album1Inp = document.querySelector(`#album1-title-guess`);
var album2Inp = document.querySelector(`#album2-title-guess`);
var album1trackGuess = document.querySelector(`#album1-song-guess`);
var album2trackGuess = document.querySelector(`#album2-song-guess`);
var album1trackGuessArray = [];
var album2trackGuessArray = [];
var albumGuessInps = [album1Inp, album2Inp];
var currentSelection = ``;
if (titles.length > 0)
{
    for (let i = 0; i < titles.length; i++)
    {
        titles[i].addEventListener("click", (e) => {
            for (let x = 0; x < titles.length; x++)
            {
                titles[x].style.color = `black`;
            }
            e.target.style.color = `#ff0000`;
            currentSelection = e.target;
        });
    }
    for (let i = 0; i < titleAreas.length; i++)
    {
        titleAreas[i].addEventListener(`click`, (e) => {
            if (currentSelection != ``)
            {
                titleAreas[i].appendChild(currentSelection);
                albumGuessInps[i].value = currentSelection.textContent;
            }
        });
    }
    selectionArea.addEventListener(`click`, (e) => {
        for (let i = 0; i < titleAreas.length; i++)
        {
            if (titleAreas[i].contains(currentSelection))
            {
                selectionArea.appendChild(currentSelection);
            }
        }
    });
}
else
{
    for (let i = 0; i < tracks.length; i++)
    {
        tracks[i].addEventListener("click", (e) => {
            for (let x = 0; x < tracks.length; x++)
            {
                tracks[x].style.color = `black`;
            }
            e.target.style.color = `#ff0000`;
            currentSelection = e.target;
        });
    }
    for (let i = 0; i < trackAreas.length; i++)
    {
        trackAreas[i].addEventListener(`click`, (e) => {
            tracksinAlbumArea = trackAreas[i].querySelectorAll(`.matching-track`);
            console.log(tracksinAlbumArea);
            if (currentSelection != `` && tracksinAlbumArea.length < 5)
            {
                trackAreas[i].appendChild(currentSelection);
                if (i == 0)
                {
                    album1trackGuessArray.push(currentSelection.textContent);
                    album1trackGuess.value = album1trackGuessArray.join(`*_*`);
                }
                else
                {
                    album2trackGuessArray.push(currentSelection.textContent);
                    album2trackGuess.value = album2trackGuessArray.join(`*_*`);
                }
            }
        });
    }
    selectionArea.addEventListener(`click`, (e) => {
        for (let i = 0; i < trackAreas.length; i++)
        {
            if (trackAreas[i].contains(currentSelection))
            {
                selectionArea.appendChild(currentSelection);
                if (i == 0)
                {
                    for (let x = 0; x < album1trackGuessArray.length; x++)
                    {
                        if (album1trackGuessArray[x] == currentSelection.textContent)
                        {
                            album1trackGuessArray.splice(x, 1);
                        }
                    }
                    album1trackGuess.value = album1trackGuessArray.join(`*_*`);
                }
                else
                {
                    for (let x = 0; x < album2trackGuessArray.length; x++)
                    {
                        if (album2trackGuessArray[x] == currentSelection.textContent)
                        {
                            album2trackGuessArray.splice(x, 1);
                        }
                    }
                    album2trackGuess.value = album2trackGuessArray.join(`*_*`);
                }
            }
        }
    });
}