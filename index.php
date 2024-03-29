<?php
session_start();

if (!(isset($_SESSION["username"])))
{
    if (isset($_GET['code']))
    {
        include "getAuthObj.php";
        include "profile.php";
        $_SESSION["username"] = $prof_obj["display_name"];
        $_SESSION["userImg"] = $prof_obj["images"][0]["url"];
        $_SESSION["accessToken"] = $authObj["access_token"];
        $_SESSION["spotify_id"] = $prof_obj["id"];
        if (!(isset($_SESSION["user_id"])))
        {
            include "models/db.php";
            $loginData = userLogin($_SESSION["spotify_id"]);
            if (0 == count($loginData))
            {
                addUser($_SESSION["username"], $_SESSION["spotify_id"]);
                $loginData = userLogin($_SESSION["spotify_id"]);
            }
            $_SESSION["user_id"] = $loginData[0]["account_id"];
        }
    }
    else
    {
        include "auth.php";
    }
}

if (isset($_GET['error']))
{
    if ($_GET['error'] == 'Toomanyrequests')
    {
        echo '<script>alert("Too Many API Requests")</script>'; 
    }
    if ($_GET['error'] == 'cannotrecieve')
    {
        echo '<script>alert("Failed To Get Data Try Again.")</script>';
        header('Location: destroy.php');
    }
}
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
    
    <!-- main content section -->
    <div class="content">
        <!-- guess the lyric section -->
        <div id="guess-link">
            <h3></h3>
            <img src="images/note.svg" alt="Guess The Lyric logo">
            <h3>Guess The Lyric</h3>
        </div>
        <!-- album matching section -->
        <div id="matching-link">
            <h3></h3>
            <img src="images/card.svg" alt="Album Matching logo">
            <h3>Album Matching</h3>
        </div>
    </div>
    <script src="scripts/links.js"></script>
    <?php if (isset($_SESSION["username"])) : ?>
    <script>
        const connectToken = `<?=$_SESSION["accessToken"]?>`;
    </script>
    <script src="https://sdk.scdn.co/spotify-player.js"></script>
    <script src="scripts/spotifyplayer.js"></script>
    <?php endif; ?>
</body>
</html>
