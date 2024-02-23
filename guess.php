<?php
session_start();

if (!(isset($_SESSION["username"])))
{
    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en" style="overflow: hidden;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guess The Lyric</title>
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
            <img src="<?=$_SESSION["userImg"];?>" alt="logo" class="logo-img">
        </div>
    </div>
    <div id="guess-content">
        <div id="guess-album-img"></div>
        <div id="lyrics">TEST TEXT _____ LA DE DA</div>
        <input type="text" name="guess" id="guess-inp" />
        <button type="submit" name="submit" id="guess-submit-btn">Submit</button>
    </div>
    <script src="scripts/links.js"></script>
</body>
</html>