<?php
session_start();

$album1GuessDataSave = "";
$album2GuessDataSave = "";
include "models/db.php";
if (!(isset($_SESSION["username"])))
{
    header('Location: index.php');
}
else if (isset($_GET["submit-titles"]))
{
    $album1GuessDataSave = $_GET["album1-title-guess"];
    $album2GuessDataSave = $_GET["album2-title-guess"];
    $titlesGuessed = True;
    $songsGuessed = False;
    $album1Base_Data = $_SESSION["Album1Data"];
    $album2Base_Data = $_SESSION["Album2Data"];
    $tracksOnPage = [];
    $incrementer = 0;
    foreach ($_SESSION["Album1Tracks"][0] as $track)
    {
        array_push($tracksOnPage, $track);
        $incrementer++;
        if ($incrementer >= 5)
        {
            break;
        }
    }
    $incrementer = 0;
    foreach ($_SESSION["Album2Tracks"][0] as $track)
    {
        array_push($tracksOnPage, $track);
        $incrementer++;
        if ($incrementer >= 5)
        {
            break;
        }
    }
    shuffle($tracksOnPage);
}
else if (isset($_GET["submit-songs"]))
{
    $titlesGuessed = True;
    $songsGuessed = True;
    $album1Base_Data = $_SESSION["Album1Data"];
    $album2Base_Data = $_SESSION["Album2Data"];
    $album1_tracks_onPage = [];
    $album2_tracks_onPage = [];
    $incrementer = 0;
    foreach ($_SESSION["Album1Tracks"][0] as $track)
    {
        array_push($album1_tracks_onPage, $track);
        $incrementer++;
        if ($incrementer >= 5)
        {
            break;
        }
    }
    $incrementer = 0;
    foreach ($_SESSION["Album2Tracks"][0] as $track)
    {
        array_push($album2_tracks_onPage, $track);
        $incrementer++;
        if ($incrementer >= 5)
        {
            break;
        }
    }
    $album1TitleGuess = $_GET["album1-title-guess"];
    $album2TitleGuess = $_GET["album2-title-guess"];
    $album1TrackGuesses = $_GET["album1-song-guess"];
    $album2TrackGuesses = $_GET["album2-song-guess"];
    $album1TrackGuessesArray = explode("*_*", $album1TrackGuesses);
    $album2TrackGuessesArray = explode("*_*", $album2TrackGuesses);
    $score = 0;
    $correctTitles = [0, 0];
    $correctSongs = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    if ($album1TitleGuess == $album1Base_Data[1])
    {
        $correctTitles[0] = 1;
        $score += 5;
    }
    if ($album2TitleGuess == $album2Base_Data[1])
    {
        $correctTitles[1] = 1;
        $score += 5;
    }
    for ($i = 0; $i < count($album1TrackGuessesArray); $i++)
    {
        if (in_array($album1TrackGuessesArray[$i], $album1_tracks_onPage))
        {
            $correctSongs[$i] = 1;
            $score += 5;
        }
    }
    for ($i = 0; $i < count($album2TrackGuessesArray); $i++)
    {
        if (in_array($album2TrackGuessesArray[$i], $album2_tracks_onPage))
        {
            $correctSongs[$i+5] = 1;
            $score += 5;
        }
    }
    addAlbumMatchingHistory($_SESSION["user_id"], $album1TitleGuess, $album2TitleGuess, $correctTitles[0], $album1TrackGuessesArray[0], $correctSongs[0], $album1TrackGuessesArray[1], $correctSongs[1], $album1TrackGuessesArray[2], $correctSongs[2], $album1TrackGuessesArray[3], $correctSongs[3], $album1TrackGuessesArray[4], $correctSongs[4], $album2TrackGuessesArray[0], $correctSongs[5], $album2TrackGuessesArray[1], $correctSongs[6], $album2TrackGuessesArray[2], $correctSongs[7], $album2TrackGuessesArray[3], $correctSongs[8], $album2TrackGuessesArray[4], $correctSongs[9], $score);
}
else if (isset($_GET["home"]))
{
    header('Location: index.php'); 
}
else
{
    if (isset($_SESSION["Album1Data"]))
    {
        unset($_SESSION["Album1Data"]);
    }
    if (isset($_SESSION["Album2Data"]))
    {
        unset($_SESSION["Album2Data"]);
    }
    if (isset($_SESSION["Album1Tracks"]))
    {
        unset($_SESSION["Album1Tracks"]);
    }
    if (isset($_SESSION["Album2Tracks"]))
    {
        unset($_SESSION["Album2Tracks"]);
    }
    $accessToken = $_SESSION["accessToken"];
    $genre = strtolower($_GET["genre"]);
    include "matchingFunctions.php";
    $passed = True;
    $albumsBaseData = recommendationsToAlbums($genre, $accessToken);
    if ($albumsBaseData == "ERROR")
    {
        $passed = False;
    }
    else
    {
        $album1Base_Data = $albumsBaseData[0];
        $album2Base_Data = $albumsBaseData[1];
        $album1Data = albumLookup($album1Base_Data[0], $accessToken);
        if ($album1Data == "ERROR")
        {
            $passed = False;
        }
        else
        {
            $album2Data = albumLookup($album2Base_Data[0], $accessToken);
            if ($album2Data == "ERROR")
            {
                $passed = False;
            }
            else
            {
                $album1_tracks = albumToTracksArray($album1Data);
                $album2_tracks = albumToTracksArray($album2Data);
                if (0 == count(searchAlbumDataForExisting($album1Base_Data[0])))
                {
                    addAlbumData($genre, $album1Base_Data[1], $album1Base_Data[2], $album1Base_Data[0]);
                }
                if (0 == count(searchAlbumDataForExisting($album2Base_Data[0])))
                {
                    addAlbumData($genre, $album2Base_Data[1], $album2Base_Data[2], $album2Base_Data[0]);
                }
                $album1_DB_DATA = searchAlbumDataForExisting($album1Base_Data[0]);
                for($i = 0; $i < count($album1_tracks[0]); $i++)
                {
                    if (0 == count(searchAlbumSongDataForExisting($album1_tracks[1][$i])))
                    {
                        addAlbumSongData($album1_tracks[0][$i], $album1_tracks[1][$i], $album1_DB_DATA[0]["id"]);
                    }
                }
                $album2_DB_DATA = searchAlbumDataForExisting($album2Base_Data[0]);
                for($i = 0; $i < count($album2_tracks[0]); $i++)
                {
                    if (0 == count(searchAlbumSongDataForExisting($album2_tracks[1][$i])))
                    {
                        addAlbumSongData($album2_tracks[0][$i], $album2_tracks[1][$i], $album2_DB_DATA[0]["id"]);
                    }
                }
            }
        }
    }
    $failed = False;
    if (!$passed)
    {
        $albumDBDATA = searchAlbumData($genre);
        if (1 >= count($albumDBDATA))
        {
            $failed = True;
        }
        elseif (2 == count($albumDBDATA))
        {
            $albumDBDATA1 = $albumDBDATA[0];
            $albumDBDATA2 = $albumDBDATA[1];
        }
        else
        {
            $albumIndex = rand(0, count($albumDBDATA)-2);
            $albumDBDATA1 = $albumDBDATA[$albumIndex];
            $albumDBDATA2 = $albumDBDATA[$albumIndex+1];
        }
        if (!$failed)
        {
            $album1DBSongs = searchAlbumSongData($albumDBDATA1["id"]);
            $album2DBSongs = searchAlbumSongData($albumDBDATA2["id"]);
            if (4 >= count($album1DBSongs) or 4 >= count($album2DBSongs))
            {
                $failed = True;
            }
            else
            {
                $album1Base_Data = [$albumDBDATA1["album_spotify_id"], $albumDBDATA1["album_name"], $albumDBDATA1["album_image"]];
                $album2Base_Data = [$albumDBDATA2["album_spotify_id"], $albumDBDATA2["album_name"], $albumDBDATA2["album_image"]];
                $album1_tracks = [[], []];
                for ($i = 0; $i < count($album1DBSongs); $i++)
                {
                    $album1_tracks[0][$i] = $album1DBSongs[$i]["song_name"];
                    $album1_tracks[1][$i] = $album1DBSongs[$i]["song_spotify_id"];
                }
                $album2_tracks = [[], []];
                for ($i = 0; $i < count($album2DBSongs); $i++)
                {
                    $album2_tracks[0][$i] = $album2DBSongs[$i]["song_name"];
                    $album2_tracks[1][$i] = $album2DBSongs[$i]["song_spotify_id"];
                }
            }
        }
    }
    if ($failed)
    {
        header('Location: index.php?error=cannotrecieve');
    }
    else
    {
        $titlesGuessed = False;
        $songsGuessed = False;
        $albumTitles = [$album1Base_Data[1], $album2Base_Data[1]];
        $displayFirstAlbumIndex = rand(0, 1);
        if ($displayFirstAlbumIndex == 1)
        {
            $displaySecondAlbumIndex = 0;
        }
        else
        {
            $displaySecondAlbumIndex = 1;
        }
        $tracksOnPage = [];
        $incrementer = 0;
        foreach ($album1_tracks[0] as $track)
        {
            array_push($tracksOnPage, $track);
            $incrementer++;
            if ($incrementer >= 5)
            {
                break;
            }
        }
        $incrementer = 0;
        foreach ($album2_tracks[0] as $track)
        {
            array_push($tracksOnPage, $track);
            $incrementer++;
            if ($incrementer >= 5)
            {
                break;
            }
        }
        shuffle($tracksOnPage);
        $_SESSION["Album1Data"] = $album1Base_Data;
        $_SESSION["Album2Data"] = $album2Base_Data;
        $_SESSION["Album1Tracks"] = $album1_tracks;
        $_SESSION["Album2Tracks"] = $album2_tracks;
    }
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
                    <div class="album-matching-img"><img src=<?=$album1Base_Data[2]?> style="height:100%;width:100%;"/></div>
                    <div class="matching-title-area">
                        <?php if ($titlesGuessed): ?>
                            <?=$album1Base_Data[1]?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="album-matching-guesses">
                <?php if ($songsGuessed): ?>
                    <?php foreach($album1_tracks_onPage as $tracks):?>
                        <div><?=$tracks?></div>
                    <?php endforeach; ?>
                <?php endif; ?>
                </div>
            </div>
            <div class="album-matching-section">
                <div class="album-matching-img-title">
                    <div class="album-matching-img"><img src=<?=$album2Base_Data[2]?> style="height:100%;width:100%;"/></div>
                    <div class="matching-title-area">
                        <?php if ($titlesGuessed): ?>
                            <?=$album2Base_Data[1]?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="album-matching-guesses">
                <?php if ($songsGuessed): ?>
                    <?php foreach($album2_tracks_onPage as $tracks):?>
                        <div><?=$tracks?></div>
                    <?php endforeach; ?>
                <?php endif; ?>
                </div>
            </div>
        </div>
        <div id="album-matching-stage-1-options">
            <?php if (!$titlesGuessed): ?>
                <div class="matching-title"><?=$albumTitles[$displayFirstAlbumIndex]?></div>
                <div class="matching-title"><?=$albumTitles[$displaySecondAlbumIndex]?></div>
            <?php elseif (!$songsGuessed): ?>
                <?php foreach($tracksOnPage as $tracks):?>
                    <div class="matching-track"><?=$tracks?></div>
                <?php endforeach; ?>
            <?php elseif($songsGuessed): ?>
                <div id="matching-score">Score: <?=$score;?></div>
            <?php endif; ?>
        </div>
        <form>
            <input type="hidden" name="album1-title-guess" id="album1-title-guess" value="<?=$album1GuessDataSave;?>" />
            <input type="hidden" name="album2-title-guess" id="album2-title-guess" value="<?=$album2GuessDataSave;?>" />
            <input type="hidden" name="album1-song-guess" id="album1-song-guess" />
            <input type="hidden" name="album2-song-guess" id="album2-song-guess" />
            <?php if (!$titlesGuessed): ?>
                <button type="submit" name="submit-titles" id="matching-submit-button">Submit</button>
            <?php elseif (!$songsGuessed): ?>
                <button type="submit" name="submit-songs" id="matching-submit-button">Submit</button>
            <?php else: ?>
                <button type="submit" name="home" id="matching-submit-button">Home</button>
            <?php endif; ?>
        </form>
    </div>
    <script src="scripts/albumMatching.js"></script>
    <script src="scripts/links.js"></script>
</body>
</html>