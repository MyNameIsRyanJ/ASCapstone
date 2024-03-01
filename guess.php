<?php
session_start();

if (!(isset($_SESSION["username"])))
{
    header('Location: index.php');
}
elseif (isset($_GET["submit"]))
{
    include "models/db.php";
    $track_name = $_GET["song-name"];
    $lyricsOnPageStr = $_GET["lyrics"];
    $dropped_word = $_GET["dropped-word"];
    $dropped_word_index = $_GET["dropped-word-index"];
    $track_image = $_GET["track-image"];
    $guess = $_GET["guess"];
    $lyricsArray = explode(" ", $lyricsOnPageStr);
    $lyricsArray[$dropped_word_index] = $dropped_word;
    $lyricsOnPageStr = implode(" ", $lyricsArray);
    if (strtolower($guess) == strtolower($dropped_word))
    {
        $correct = True;
    }
    else
    {
        $correct = False;
    }
    addGuessTheLyricHistory($_SESSION["user_id"], $track_name, $lyricsOnPageStr, $dropped_word_index, $guess, $correct ? "20" : "0");
}
elseif (isset($_GET["home"]))
{
    header('Location: index.php');  
}
else
{
    include "guessFunctions.php";
    include "models/db.php";
    $passed = True;
    $accessToken = $_SESSION["accessToken"];
    $genre = strtolower($_GET["genre"]);
    $albumID = getAlbumID($genre, $accessToken);
    if ($albumID == "ERROR")
    {
        $passed = False;
    }
    else
    {
        $track_id = getTrackIDFromAlbumID($albumID, $accessToken);
        if ($track_id == "ERROR")
        {
            $passed = False;
        }
        else
        {
            $trackData = getIsrcIDFromTrackID($track_id, $accessToken);
            if ($trackData == "ERROR")
            {
                $passed = False;
            }
            else
            {
                $isrcID = $trackData[0];
                $track_name = $trackData[1];
                $track_image = $trackData[2];
                $lyrics = getLyricData($isrcID);
                if ($lyrics == "ERROR")
                {
                    $passed = False;
                }
                else
                {
                    if (0 == count(searchGuessTheLyricDataForExisting($genre, $track_name)))
                    {
                        addGuessTheLyricData($genre, $track_name, $track_image, $lyrics, $track_id);
                    }
                }
            }
        }
    }
    $failed = False;
    if (!$passed)
    {
        $guessData = searchGuessTheLyricData($genre);
        if (0 == count($guessData))
        {
            $failed = True;
        }
        elseif (1 == count($guessData))
        {
            $guessData = $guessData[0];
        }
        else
        {
            $randomIndex = rand(1, count($guessData)-1);
            $guessData = $guessData[$randomIndex];
            $track_name = $guessData["song_name"];
            $track_image = $guessData["song_image"];
            $lyrics = $guessData["song_lyrics"];
        }
    }
    if ($failed)
    {
        header('Location: index.php?error=cannotrecieve');   
    }
    else
    {
        $lyricsToInclude = explode(" ", $lyrics);
        $lyricsLength = count($lyricsToInclude);
        $lyricsOnPageArray = [];
        if ($lyricsLength > 8)
        {
            $randLyricEnd = rand(8, $lyricsLength);
            for ($i = 0; $i < 8; $i++)
            {
                array_push($lyricsOnPageArray, $lyricsToInclude[$randLyricEnd-8+$i]);
            }
        }
        else
        {
            for ($i = 0; $i < $lyricsLength; $i++)
            {
                array_push($lyricsOnPageArray, $lyricsToInclude[0]);
            }
        }
        $dropped_word_index = rand(1, count($lyricsOnPageArray)-1);
        $dropped_word = $lyricsOnPageArray[$dropped_word_index];
        $lyricsOnPageArray[$dropped_word_index] = str_repeat("_", strlen($dropped_word));
        $lyricsOnPageStr = implode(" ", $lyricsOnPageArray);
    }
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
            <h1 id="logo-text"><strong class="text-color-primary">Guess</strong> <strong class="text-color-secondary">The Lyric</strong></h1>
        </div>
        <div class="nav-item account-click">
            <h2 id="username"><?=$_SESSION["username"];?></h2>
            <img src="<?=$_SESSION["userImg"];?>" alt="logo" class="logo-img">
        </div>
    </div>
    <div id="guess-content">
        <div id="guess-album-img"><img src=<?=$track_image?> style="height:100%;width:100%;"/></div>
        <?php if (!(isset($_GET["submit"]))): ?>
        <div id="lyrics"><?=$lyricsOnPageStr?></div>
        <form>
            <input type="hidden" name="song-name" value="<?=$track_name?>" />
            <input type="hidden" name="lyrics" value="<?=$lyricsOnPageStr?>" />
            <input type="hidden" name="dropped-word" value="<?=$dropped_word?>" />
            <input type="hidden" name="dropped-word-index" value="<?=$dropped_word_index?>" />
            <input type="hidden" name="track-image" value="<?=$track_image?>" />
            <input type="text" name="guess" id="guess-inp" />
            <button type="submit" name="submit" id="guess-submit-btn">Submit</button>
        </form>
        <?php else: ?>
            <?php if ($correct): ?>
                <div id="lyrics" style="color:#0000ff;"><?=$lyricsOnPageStr?></div>
            <?php else: ?>
                <div id="lyrics" style="color:#ff0000;"><?=$lyricsOnPageStr?></div>
            <?php endif; ?>
            <form>
                <button type="submit" name="home" id="guess-submit-btn">Go Home</button>
            </form>
        <?php endif; ?>
    </div>
    <script>
    </script>
    <script src="scripts/links.js"></script>
</body>
</html>