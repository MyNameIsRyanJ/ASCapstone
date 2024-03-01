<?php

$ini = parse_ini_file(__DIR__ . '/dbconfig.ini');

$db = new PDO(
    "mysql:host=" . $ini['servername'] . 
    ";port=" . $ini['port'] . 
    ";dbname=" . $ini['dbname'], 
    $ini['username'], 
    $ini['password']
);

$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

function addUser($account_name, $account_spotify_id)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO accounts (account_name, account_spotify_id, date_of_creation) VALUES (?, ?, Now())"); /*placeholder for values*/
    return $stmt->execute([$account_name, $account_spotify_id]);
}

function userLogin($spotify_id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM accounts WHERE account_spotify_id = ?");
    $stmt->execute([$spotify_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addMusicClashHistory($account_id, $songs_list, $round_winners_list, $round_losers_list) {
    global $db;
    $stmt = $db->prepare("INSERT INTO musicclashhistory (account_id, songs_list, round_winners_list, round_losers_list) VALUES (?, ?, ?, ?)"); /*placeholder for values*/
    return $stmt->execute([$account_id, $songs_list, $round_winners_list, $round_losers_list]);
}
        
function addAlbumMatchingHistory($account_id, $albums_list, $album_guess_correct, $song_list, $guess_correct_list, $score) {
    global $db;
    $stmt = $db->prepare("INSERT INTO albummatchinghistory (account_id, albums_list, album_guess_correct, song_list, guess_correct_list, score) VALUES (?, ?, ?, ?, ?, ?)"); /*place holder */
    return $stmt->execute([$account_id, $albums_list, $album_guess_correct, $song_list, $guess_correct_list, $score]);
}

function addGuessTheLyricHistory($account_id, $song, $lyric, $dropped_word_index, $guess, $score) {
    global $db;
    $stmt = $db->prepare("INSERT INTO guessthelyrichistory (account_id, song, lyric, dropped_word, guess, score, date_played) VALUES (?, ?, ?, ?, ?, ?, Now())");
    return $stmt->execute([$account_id, $song, $lyric, $dropped_word_index, $guess, $score]);
}

function searchUserPlayedMusicClashGames($account_id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM musicclashhistory WHERE account_id = ?");
    $stmt->execute([$account_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function searchUserPlayedAlbumMatching($account_id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM albummatchinghistory WHERE account_id = ?");
    $stmt->execute([$account_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function searchUserPlayedGuessTheLyric($account_id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM guessthelyrichistory WHERE account_id = ?");
    $stmt->execute([$account_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUserScoreAlbumMatching($account_id) {
    global $db;
    $stmt = $db->prepare("SELECT SUM(score) AS total_score FROM albummatchinghistory WHERE account_id = ?");
    $stmt->execute([$account_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total_score'];
}

function getUserScoreGuessTheLyric($account_id) {
    global $db;
    $stmt = $db->prepare("SELECT SUM(score) AS total_score FROM guessthelyrichistory WHERE account_id = ?");
    $stmt->execute([$account_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total_score'];
}

function addGuessTheLyricData ($genre, $song_name, $song_image, $song_lyrics, $song_spotify_id)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO guessthelyricdata (genre, song_name, song_image, song_lyrics, song_spotify_id) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$genre, $song_name, $song_image, $song_lyrics, $song_spotify_id]);
}

function searchGuessTheLyricData ($genre)
{
    global $db;
    $stmt = $db->prepare("SELECT * FROM guessthelyricdata WHERE genre = ?");
    $stmt->execute([$genre]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function searchGuessTheLyricDataForExisting ($genre, $song_name)
{
    global $db;
    $stmt = $db->prepare("SELECT * FROM guessthelyricdata WHERE genre = ? AND song_name = ?");
    $stmt->execute([$genre, $song_name]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addGenreData ($genre)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO genres (genre) VALUES (?)");
    return $stmt->execute([$genre]);
}

function getGenres ()
{
    global $db;
    $stmt = $db->prepare("SELECT genre FROM genres");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function searchGenresForExisting ($genre)
{
    global $db;
    $stmt = $db->prepare("SELECT * FROM genres WHERE genre = ?");
    $stmt->execute([$genre]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

