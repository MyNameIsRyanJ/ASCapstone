<?php
session_start();

if (!(isset($_SESSION["username"])))
{
    header('Location: index.php');
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/recommendations/available-genre-seeds');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $_SESSION["accessToken"]
]);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$genresObj = json_decode($response, true);
$startInd = rand(0, count($genresObj["genres"])-8);
$genresArray = [];
for ($i = $startInd; $i < $startInd+8; $i++)
{
    array_push($genresArray, $genresObj["genres"][$i]);
}
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