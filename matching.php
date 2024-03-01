<?php
session_start();

if (!(isset($_SESSION["username"])))
{
    header('Location: index.php');
}
else
{
    $accessToken = $_SESSION["accessToken"];
    $genre = strtolower($_GET["genre"]);
    include "recommendationsToAlbumsTracks.php";
}

?>

<!DOCTYPE html>
<html lang="en" style="overflow: hidden;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album Matching</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="nav">
        <div class="nav-item home-click">
            <img src="images/logo.svg" alt="logo" class="logo-img">
            <h1 id="logo-text"><strong class="text-color-primary">Album</strong> <strong class="text-color-secondary">Matching</strong></h1>
        </div>
        <div class="nav-item account-click">
            <h2 id="username"><?=$_SESSION["username"];?></h2>
            <img src="<?=$_SESSION["userImg"];?>" alt="logo" class="logo-img">
        </div>
    </div>
    <div id="matching-content">
        <div id="album-matching">
            <div class="album-matching-section">
                <div class="album-matching-img-title">
                    <div class="album-matching-img"></div>
                    <div class="matching-title-area">
                        
                    </div>
                </div>
                <div class="album-matching-guesses"></div>
            </div>
            <div class="album-matching-section">
                <div class="album-matching-img-title">
                    <div class="album-matching-img"></div>
                    <div class="matching-title-area">
                        
                    </div>
                </div>
                <div class="album-matching-guesses"></div>
            </div>
        </div>
        <div id="album-matching-stage-1-options">

        </div>
    </div>
    <script src="scripts/links.js"></script>
</body>
</html>