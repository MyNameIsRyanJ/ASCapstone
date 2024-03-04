<?php
session_start();
include_once 'clash-functions.php';

if (!(isset($_SESSION["username"]))) {
    header('Location: index.php');
}

$genre = strtolower($_GET["genre"]);
$albums = recommendationsToAlbums($genre, $accessToken);

// first match
list($artist1, $song1) = getArtistAndSongNames($albums[0][0], $accessToken);
list($artist2, $song2) = getArtistAndSongNames($albums[1][0], $accessToken);

// second match
list($artist3, $song3) = getArtistAndSongNames($albums[2][0], $accessToken);
list($artist4, $song4) = getArtistAndSongNames($albums[3][0], $accessToken);

// third match
list($artist5, $song5) = getArtistAndSongNames($albums[4][0], $accessToken);
list($artist6, $song6) = getArtistAndSongNames($albums[5][0], $accessToken);

// fourth match
list($artist7, $song7) = getArtistAndSongNames($albums[6][0], $accessToken);
list($artist8, $song8) = getArtistAndSongNames($albums[7][0], $accessToken);

var_dump($artist1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Music Madness</title>
</head>
<body>
    <div id="nav">
        <div class="nav-item home-click">
            <img src="images/logo.svg" alt="logo-img" class="logo-img">
            <h1><strong class="text-color-primary">Music</strong> <strong class="text-color-secondary">Madness</strong></h1>
        </div>
        <div class="nav-item account-click">
            <h2 id="username"><?=$_SESSION["username"];?></h2>
            <img src="<?=$_SESSION["userImg"];?>" alt="logo" class="logo-img">
        </div>
    </div>
    <div id="clash-content">
        <!-- first row -->
        <div class="clash-square"></div>
        <div class="clash-square"><div class="artist1"><?php echo $artist1; ?></div></div>
        <div class="clash-square"></div>
        <div class="clash-square"></div>
        <div class="clash-square"></div>
        <div class="clash-square"></div>
        <div class="clash-square"><div class="artist2">artist</div></div>
        <div class="clash-square"></div>
        <!-- second row -->
        <div class="clash-square"></div>
        <div class="clash-square clash-left-top"></div>
        <div class="clash-square clash-connector-top"></div>
        <div class="clash-square"></div>
        <div class="clash-square"></div>
        <div class="clash-square clash-connector-top"></div>
        <div class="clash-square clash-right-top"></div>
        <div class="clash-square"></div>
        <!-- third row -->
        <div class="clash-square"></div>
        <div class="clash-square clash-left-bottom"></div>
        <div class="clash-square clash-connector-bottom"></div>
        <div class="clash-square clash-finals-left-top"></div>
        <div class="clash-square clash-finals-right"></div>
        <div class="clash-square clash-connector-bottom"></div>
        <div class="clash-square clash-right-bottom"></div>
        <div class="clash-square"></div>
        <!-- forth row -->
        <div class="clash-square"></div>
        <div class="clash-square"><div class="artist3">artist</div></div>
        <div class="clash-square"></div>
        <div class="clash-square clash-finals-left"></div>
        <div class="clash-square clash-finals-right"></div>
        <div class="clash-square"></div>
        <div class="clash-square"><div class="artist4">artist</div></div>
        <div class="clash-square"></div>
        <!-- fifth row -->
        <div class="clash-square"></div>
        <div class="clash-square"><div class="artist5">artist</div></div>
        <div class="clash-square"></div>
        <div class="clash-square clash-finals-left"></div>
        <div class="clash-square clash-finals-right"></div>
        <div class="clash-square"></div>
        <div class="clash-square"><div class="artist6">artist</div></div>
        <div class="clash-square"></div>
        <!-- sixth row -->
        <div class="clash-square"></div>
        <div class="clash-square clash-left-top"></div>
        <div class="clash-square clash-connector-top"></div>
        <div class="clash-square clash-finals-left"></div>
        <div class="clash-square clash-finals-right-bottom"></div>
        <div class="clash-square clash-connector-top"></div>
        <div class="clash-square clash-right-top"></div>
        <div class="clash-square"></div>
        <!-- seventh row -->
        <div class="clash-square"></div>
        <div class="clash-square clash-left-bottom"></div>
        <div class="clash-square clash-connector-bottom"></div>
        <div class="clash-square"></div>
        <div class="clash-square"></div>
        <div class="clash-square clash-connector-bottom"></div>
        <div class="clash-square clash-right-bottom"></div>
        <div class="clash-square"></div>
        <!-- eighth row -->
        <div class="clash-square"></div>
        <div class="clash-square"><div class="artist7">artist</div></div>
        <div class="clash-square"></div>
        <div class="clash-square"></div>
        <div class="clash-square"></div>
        <div class="clash-square"></div>
        <div class="clash-square"><div class="artist8">artist</div></div>
        <div class="clash-square"></div>
    </div>
    <script src="scripts/links.js"></script>
</body>
</html> 