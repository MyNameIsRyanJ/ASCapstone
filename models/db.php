<?php

$ini = parse_ini_file( __DIR__ . '/dbconfig.ini');

$db = new PDO(
                "mysql:host=" . $ini['servername'] . 
                ";port=" . $ini['port'] . 
                ";dbname=" . $ini['dbname'], 
                $ini['username'], 
                $ini['password']);


$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

function addMusicClashHistory () {
    global $db;
    $results = [];
    $stmt = $db->prepare("SELECT account_id, songs_list, round_winners_list, round_losers_list FROM musicclashhistory ORDER BY account_id");
    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return $results;
}
        
function AddAlbumMatchingHistory () {
    global $db;
    $results = [];
    $stmt = $db->prepare("SELECT account_id, albums_list, album_guess_correct, song_list, guess_correct_list, score FROM albummatchinghistory ORDER BY account_id");
    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return $results;

}

function AddGuessTheLyricHistory () {
    global $db;
    $results = [];
    $stmt = $db->prepare("SELECT account_id, song, lyric, dropped_word_index, guess, score FROM guessthelyrichistory ORDER BY account_id");
    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return $results;
}

function SearchUserPlayedMusicClashGames () {
    global $db
    $results = [];
    $stmt = $db->prepare("SELECT account_id FROM musicclashhistory")
    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return $results;
}

function SearchUserPlayedAlbumMatching () {
    global $db
    $results = [];
    $stmt = $db->prepare("SELECT account_id FROM albummatchinghistory")
    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return $results;
}
