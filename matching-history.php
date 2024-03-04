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
<html lang="en">
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
    <div id="clash-content">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px auto;
            margin-left: 22em;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: middle;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        </style>
    <body>
    <table>
        <tr>
            <th>Date Played</th>
            <th>Albums List</th>
            <th>Albums Guessed Correct</th>
            <th>Songs List</th>
            <th>Songs Guessed Correct</th>
            <th>Score</th>
        </tr>
        <?php foreach ($matching_history as $record): ?>
            <tr>
                <td><?= $record['date_played']?></td>
                <td><?= $record['albums_list']?></td>
                <td><?= $record['album_guess_correct']?></td>
                <td><?= $record['songs_list']?></td>
                <td><?= $record['guess_correct_list']?></td>
                <td><?= $record['score']?></td>
            </tr>
        <?php endforeach; ?>
    </table>   
    </div>
    <script src="scripts/links.js"></script>
</body>
</html>
