<?php
session_start();
if (!(isset($_SESSION["username"]))) {
    header('Location: index.php');
}

include_once 'models/db.php';

$user_id = $_SESSION["user_id"];
$clashHistory = searchUserPlayedMusicClashGames($user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Clash History</title>
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
    <div id="clash-history-content">
    <table id="clash-history-table">
        <tr id="clash-history-table-header">
            <th>1st Place</th>
            <th>2nd Place</th>
            <th>3rd Place</th>
            <th>4th Place</th>
            <th>5th Place</th>
            <th>6th Place</th>
            <th>7th Place</th>
            <th>8th Place</th>
            <th>Date Played</th>
        </tr>
        <?php foreach ($clashHistory as $record):
            if ($record['round_0_game_0_vic'] == 0)
            {
                $round_0_game_0_vic = $record['song_0'];
                $round_0_game_0_los = $record['song_1'];
            }
            else
            {
                $round_0_game_0_vic = $record['song_1'];
                $round_0_game_0_los = $record['song_0'];
            }
            if ($record['round_0_game_1_vic'] == 0)
            {
                $round_0_game_1_vic = $record['song_2'];
                $round_0_game_1_los = $record['song_3'];
            }
            else
            {
                $round_0_game_1_vic = $record['song_3'];
                $round_0_game_1_los = $record['song_2'];
            }
            if ($record['round_0_game_2_vic'] == 0)
            {
                $round_0_game_2_vic = $record['song_4'];
                $round_0_game_2_los = $record['song_5'];
            }
            else
            {
                $round_0_game_2_vic = $record['song_5'];
                $round_0_game_2_los = $record['song_4'];
            }
            if ($record['round_0_game_3_vic'] == 0)
            {
                $round_0_game_3_vic = $record['song_6'];
                $round_0_game_3_los = $record['song_7'];
            }
            else
            {
                $round_0_game_3_vic = $record['song_7'];
                $round_0_game_3_los = $record['song_6'];
            }
            if ($record['round_1_game_0_vic'] == 0)
            {
                $round_1_game_0_vic = $round_0_game_0_vic;
                $round_1_game_0_los = $round_0_game_1_vic;
            }
            else
            {
                $round_1_game_0_vic = $round_0_game_1_vic;
                $round_1_game_0_los = $round_0_game_0_vic;
            }
            if ($record['round_1_game_1_vic'] == 0)
            {
                $round_1_game_1_vic = $round_0_game_2_vic;
                $round_1_game_1_los = $round_0_game_3_vic;
            }
            else
            {
                $round_1_game_1_vic = $round_0_game_3_vic;
                $round_1_game_1_los = $round_0_game_2_vic;
            }
            if ($record['round_2_game_0_vic'] == 0)
            {
                $round_2_game_0_vic = $round_1_game_0_vic;
                $round_2_game_0_los = $round_1_game_1_vic;
            }
            else
            {
                $round_2_game_0_vic = $round_1_game_1_vic;
                $round_2_game_0_los = $round_1_game_0_vic;
            }
            $orderedPlacesArray = [$round_2_game_0_vic, $round_2_game_0_los, $round_1_game_1_los, $round_1_game_0_los, $round_0_game_3_los, $round_0_game_2_los, $round_0_game_1_los, $round_0_game_0_los];
            ?>
            <tr id="clash-history-table-body">
                <td><?= $orderedPlacesArray[0] ?></td>
                <td><?= $orderedPlacesArray[1] ?></td>
                <td><?= $orderedPlacesArray[2] ?></td>
                <td><?= $orderedPlacesArray[3] ?></td>
                <td><?= $orderedPlacesArray[4] ?></td>
                <td><?= $orderedPlacesArray[5] ?></td>
                <td><?= $orderedPlacesArray[6] ?></td>
                <td><?= $orderedPlacesArray[7] ?></td>
                <td><?= $record['date_of_play'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    </div>
    <script src="scripts/links.js"></script>
</div>
</body>
</html>