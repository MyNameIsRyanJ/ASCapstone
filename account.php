<?php
session_start();
if (!(isset($_SESSION["username"])))
{
    header('Location: index.php');
}

include_once 'models/db.php';

$user_id = $_SESSION["user_id"];

$music_clash_games = count(searchUserPlayedMusicClashGames($user_id)); /*history */
$album_matching_games = count(searchUserPlayedAlbumMatching($user_id));
$guess_the_lyric_games = count(searchUserPlayedGuessTheLyric($user_id));

$total_score_album_matching = getUserScoreAlbumMatching($user_id);
$total_score_guess_the_lyric = getUserScoreGuessTheLyric($user_id);

?>
<!DOCTYPE html>
<html lang="en" style="height: 100%; overflow: hidden;">
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
    
    <!-- main content section -->
    <div class="content">
        <!-- guess the lyric section -->
        <div id="guess-history-link">
            <a href="guess-history.php">
                <h3>Guess The Lyric</h3>
                <img src="images/note.svg" alt="Guess The Lyric logo">
                <h3>Total Score: <?=$total_score_guess_the_lyric;?></h3>
            </a>
        </div>
        <!-- album matching section -->
        <div id="matching-history-link">
            <a href="matching-history.php">
                <h3>Album Matching</h3>
                <img src="images/card.svg" alt="Album Matching logo">
                <h3>Total Score: <?=$total_score_album_matching;?></h3>
            </a>
        </div>
    </div>
    <script src="scripts/links.js"></script>
</body>
</html>
