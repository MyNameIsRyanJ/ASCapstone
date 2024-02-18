<?php
session_start();
if (!(isset($_SESSION["username"])))
{
    header('Location: index.php');
}

include_once 'models/db.php';

$user_spotify_id = $_SESSION["spotify_id"];

$music_clash_games = count(searchUserPlayedMusicClashGames($user_spotify_id));
$album_matching_games = count(searchUserPlayedAlbumMatching($user_spotify_id));
$guess_the_lyric_games = count(searchUserPlayedGuessTheLyric($user_spotify_id));

$total_score_album_matching = getUserScoreAlbumMatching($user_spotify_id);
$total_score_guess_the_lyric = getUserScoreGuessTheLyric($user_spotify_id);

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
        <!-- music clash section -->
        <div id="clash-history-link">
            <h3>Music Clash</h3>
            <img src="images/trophy.svg" alt="Music Clash logo">
            <h3>Matches Played: 0</h3>
        </div>
        <!-- guess the lyric section -->
        <div id="guess-history-link">
            <h3>Guess The Lyric</h3>
            <img src="images/note.svg" alt="Guess The Lyric logo">
            <h3>Total Score: 0</h3>
        </div>
        <!-- album matching section -->
        <div id="matching-history-link">
            <h3>Album Matching</h3>
            <img src="images/card.svg" alt="Album Matching logo">
            <h3>Total Score: 0</h3>
        </div>
    </div>
    <script src="scripts/links.js"></script>
    <script>
        // Your JavaScript code here
    </script>
</body>
</html>
