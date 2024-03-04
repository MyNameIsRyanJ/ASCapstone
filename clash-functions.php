<?php

function recommendationsToAlbums ($genre, $accessToken)
{
    $url = 'https://api.spotify.com/v1/recommendations?limit=8&seed_genres=' . urlencode($genre);

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

        $albums = [];
        foreach ($recommendations["tracks"] as $track) {
            $album_id = $track["album"]["id"];
            $album_name = $track["album"]["name"];
            $album_image = $track["album"]["images"][0]["url"];
            $albums[] = [$album_id, $album_name, $album_image];
        }
        return $albums;
    }
}

function getArtistAndSongNames($track_id, $accessToken) {
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
        $artist_name = $track_info["artists"][0]["name"];
        $song_name = $track_info["name"];
        return [$artist_name, $song_name];
    }
}

?>
