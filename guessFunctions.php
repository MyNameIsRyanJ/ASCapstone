<?php

function getAlbumID($genre, $accessToken){
    $url = 'https://api.spotify.com/v1/recommendations?limit=10&seed_genres=' . urlencode($genre);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken
    ]);

    $needDB = False;
    $response = curl_exec($ch);
    if ($response == "Too many requests")
    {
        $needDB = True;
    }
    if (curl_errno($ch)) {
        $needDB = True;
    }
    curl_close($ch);
    if (!$needDB)
    {
        $recommendations = json_decode($response, true);
        if (array_key_exists("error", $recommendations))
        {
            $needDB = True;
        }
    }
    if ($needDB)
    {
        return "ERROR";
    }
    else
    {
        $recommendations = json_decode($response, true);
        $randAlbum = count($recommendations["tracks"]);
        $randAlbum = rand(0, $randAlbum-1);

        $album_id = $recommendations["tracks"][$randAlbum]["album"]["id"];
        return $album_id;
    }    
}

function getTrackIDFromAlbumID($album_id, $accessToken) {
    $url = 'https://api.spotify.com/v1/albums/' . $album_id . '/tracks';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken
    ]);

    $needDB = False;
    $response = curl_exec($ch);
    if ($response == "Too many requests")
    {
        $needDB = True;
    }
    if (curl_errno($ch)) {
        $needDB = True;
    }
    curl_close($ch);
    if (!$needDB)
    {
        $albumInfo = json_decode($response, true);
        if (array_key_exists("error", $albumInfo))
        {
            $needDB = True;
        }
    }
    if ($needDB)
    {
        return "ERROR";
    }
    else
    {
        $albumInfo = json_decode($response, true);
        $track = $albumInfo["items"][0]["id"];
        return $track;
    }
}

function getIsrcIDFromTrackID($track_id, $accessToken){
    $url = 'https://api.spotify.com/v1/tracks/' . $track_id;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken
    ]);

    $needDB = False;
    $response = curl_exec($ch);
    if ($response == "Too many requests")
    {
        $needDB = True;
    }
    if (curl_errno($ch)) {
        $needDB = True;
    }
    curl_close($ch);
    if (!$needDB)
    {
        $track_info = json_decode($response, true);
        if (array_key_exists("error", $track_info))
        {
            $needDB = True;
        }
    }
    if ($needDB)
    {
        return "ERROR";
    }
    else
    {
        $track_info = json_decode($response, true);
        $track_name = $track_info["name"];
        $track_image = $track_info["album"]["images"][0]["url"];
        $isrcID = $track_info["external_ids"]["isrc"];
        return [$isrcID, $track_name, $track_image];
    }
}

function getLyricData($isrcID){
    $apiKey = "e60c61560d0229b6808fdc38ff8dd69e";

    $url = 'https://api.musixmatch.com/ws/1.1/matcher.lyrics.get?apikey=' . $apiKey . '&track_isrc=' . $isrcID;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $needDB = False;
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        $needDB = True;
    }
    curl_close($ch);

    $song_info = json_decode($response, true);
    if ($song_info["message"]["header"]["status_code"] != 200)
    {
        $needDB = True;
    }
    else if (strlen($song_info["message"]["body"]["lyrics"]["lyrics_body"]) < 1)
    {
        $needDB = True;
    }
    if ($needDB)
    {
        return "ERROR";
    }
    else
    {
        $lyrics = str_replace("******* This Lyrics is NOT for Commercial use *******", "", $song_info["message"]["body"]["lyrics"]["lyrics_body"]);
        $lyrics = str_replace("\n", " ", $lyrics);
        $lyrics = str_replace("\t", " ", $lyrics);
        $lyrics = str_replace("  ", " ", $lyrics);
        $lyrics = preg_replace("/[^A-Za-z0-9 ]/", "", $lyrics);
        $lyrics = rtrim($lyrics, "1234567890");
        return $lyrics;
    }
}

?>