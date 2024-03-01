<?php
session_start();

if (!(isset($_SESSION["username"])))
{
    header('Location: index.php');
}

include "models/db.php";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/recommendations/available-genre-seeds');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $_SESSION["accessToken"]
]);

$needDB = False;

$response = curl_exec($ch);
if ($response == "Too many requests")
{
    $needDB = True;
}
if (curl_errno($ch)) {
    $needDB = True;
}
curl_close($ch);
$genresList = [];
if (!$needDB)
{
    $genresObj = json_decode($response, true);
    if (array_key_exists("error", $genresObj))
    {
        $needDB = True;
    }
}
if ($needDB)
{
    $genreDBList = getGenres();
    $genresList = [];
    for ($i = 0; $i < count($genreDBList); $i++)
    {
        array_push($genresList, $genreDBList[$i]["genre"]);
    }
}
else
{
    $not_include_array = ["acoustic", "ambient", "anime", "bossanova", "brazil", "breakbeat", "cantopop", "chicago-house",  "classical", "comedy", "detroit-techno", "dub", "dubstep", "edm", "electro", "electronic", "french", "german", "gospel", "guitar", "idm", "indian", "iranian", "j-dance", "j-idol", "j-pop", "j-rock", "k-pop", "latin", "latino", "malay", "mandopop", "minimal-techno", "mpb", "opera", "pagode", "philippines-opm", "piano", "post-dubstep", "rainy-day", "reggae", "reggaeton", "salsa", "samba", "sertanejo", "show-tunes", "ska", "sleep", "soundtracks", "spanish", "study", "swedish", "tango", "trance", "trip-hop", "turkish", "work-out", "world-music"];
    $genresObj = json_decode($response, true);
    for ($i = 0; $i < count($genresObj["genres"]); $i++)
    {
        if (!(in_array($genresObj["genres"][$i], $not_include_array)))
        {
            if (0 == count(searchGenresForExisting($genresObj["genres"][$i])))
            {
                addGenreData($genresObj["genres"][$i]);
            }
            array_push($genresList, $genresObj["genres"][$i]);
        }
    }
}
$startInd = rand(0, count($genresList)-8);
$genresArray = [];
$index = $startInd;
while (count($genresArray) < 8)
{
    array_push($genresArray, $genresList[$index]);
    $index++;
    if ($index > count($genresList))
    {
        $index=0;
    }
}
/*
for ($i = $startInd; $i < $startInd+8; $i++)
{
    array_push($genresArray, $genresObj["genres"][$i]);
}*/
?>

<!DOCTYPE html>
<html lang="en" style="overflow: hidden;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genre Selection</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="nav">
        <div class="nav-item home-click">
            <img src="images/logo.svg" alt="logo" class="logo-img">
            <h1 id="logo-text"><strong class="text-color-secondary">Music</strong> <strong class="text-color-primary">Madness</strong></h1>
        </div>
        <div class="nav-item account-click">
            <h2 id="username"><?=$_SESSION["username"];?></h2>
            <img src="<?=$_SESSION["userImg"];?>p" alt="logo" class="logo-img">
        </div>
    </div>
    <div id="genre-content">
        <div class="genre-row">
            <div id="genre-title">Pick A Genre</div>
        </div>
        <div class="genre-row">
            <div class="genre-col">
                <div class="genre-selector"><?=ucfirst($genresArray[0])?></div>
                <div class="genre-selector"><?=ucfirst($genresArray[1])?></div>
                <div class="genre-selector"><?=ucfirst($genresArray[2])?></div>
                <div class="genre-selector"><?=ucfirst($genresArray[3])?></div>
            </div>
            <div class="genre-col">
                <div class="genre-selector"><?=ucfirst($genresArray[4])?></div>
                <div class="genre-selector"><?=ucfirst($genresArray[5])?></div>
                <div class="genre-selector"><?=ucfirst($genresArray[6])?></div>
                <div class="genre-selector"><?=ucfirst($genresArray[7])?></div>
            </div>
        </div>
        <div class="genre-row">
            <div id="genre-selector-last">Random</div>
        </div>
    </div>
    <script src="scripts/links.js"></script>
</body>
</html>