<?php
session_start();
if (!(isset($_SESSION["username"]))) {
    header('Location: index.php');
}

include_once 'models/db.php';

$user_id = $_SESSION["user_id"];
$matching_history = searchUserPlayedAlbumMatching($user_id);
?>

<!DOCTYPE html>
<html lang="en" style="overflow:auto;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Matching Game History</title>
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
    <body>
    <div id="album-history-content">
    <table id="album-history-table">
        <tr id="album-history-table-header">
            <th>Date Played</th>
            <th>Albums 1</th>
            <th>Albums 2</th>
            <th>Song 1</th>
            <th>Song 2</th>
            <th>Song 3</th>
            <th>Song 4</th>
            <th>Song 5</th>
            <th>Song 6</th>
            <th>Song 7</th>
            <th>Song 8</th>
            <th>Song 9</th>
            <th>Song 10</th>
            <th>Score</th>
        </tr>
        <?php foreach ($matching_history as $record): ?>
            <tr id="album-history-table-body">
                <td><?= $record['date_of_play']?></td>
                <td style="color:<?php if($record['album_guess_correct'] == 0) {echo "#ff0000";} else {echo "#0000ff";}?>;"><?= $record['album_0']?></td>
                <td style="color:<?php if($record['album_guess_correct'] == 0) {echo "#ff0000";} else {echo "#0000ff";}?>;"><?= $record['album_1']?></td>
                <td style="color:<?php if($record['song_0_correct'] == 0) {echo "#ff0000";} else {echo "#0000ff";}?>;"><?= $record['song_0']?></td>
                <td style="color:<?php if($record['song_1_correct'] == 0) {echo "#ff0000";} else {echo "#0000ff";}?>;"><?= $record['song_1']?></td>
                <td style="color:<?php if($record['song_2_correct'] == 0) {echo "#ff0000";} else {echo "#0000ff";}?>;"><?= $record['song_2']?></td>
                <td style="color:<?php if($record['song_3_correct'] == 0) {echo "#ff0000";} else {echo "#0000ff";}?>;"><?= $record['song_3']?></td>
                <td style="color:<?php if($record['song_4_correct'] == 0) {echo "#ff0000";} else {echo "#0000ff";}?>;"><?= $record['song_4']?></td>
                <td style="color:<?php if($record['song_5_correct'] == 0) {echo "#ff0000";} else {echo "#0000ff";}?>;"><?= $record['song_5']?></td>
                <td style="color:<?php if($record['song_6_correct'] == 0) {echo "#ff0000";} else {echo "#0000ff";}?>;"><?= $record['song_6']?></td>
                <td style="color:<?php if($record['song_7_correct'] == 0) {echo "#ff0000";} else {echo "#0000ff";}?>;"><?= $record['song_7']?></td>
                <td style="color:<?php if($record['song_8_correct'] == 0) {echo "#ff0000";} else {echo "#0000ff";}?>;"><?= $record['song_8']?></td>
                <td style="color:<?php if($record['song_9_correct'] == 0) {echo "#ff0000";} else {echo "#0000ff";}?>;"><?= $record['song_9']?></td>
                <td><?= $record['score']?></td>
            </tr>
        <?php endforeach; ?>
    </table>   
    </div>
    <script src="scripts/links.js"></script>
</body>
</html>
