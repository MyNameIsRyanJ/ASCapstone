<?php
function albumLookup($album_id, $accessToken) {
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
        return $albumInfo;
    }
}

function albumToTracksArray($albumData) {
    $albumTracks = [];
    $albumIds = [];
    foreach ($albumData["items"] as $tracks) {
        array_push($albumTracks, $tracks["name"]);
        array_push($albumIds, $tracks["id"]);
    }
    return [$albumTracks, $albumIds];
}

function recommendationsToAlbums ($genre, $accessToken)
{
    $url = 'https://api.spotify.com/v1/recommendations?limit=2&seed_genres=' . urlencode($genre);

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

        $album1_id = $recommendations["tracks"][0]["album"]["id"];
        $album2_id = $recommendations["tracks"][1]["album"]["id"];
        $album1_name = $recommendations["tracks"][0]["album"]["name"];
        $album1_image = $recommendations["tracks"][0]["album"]["images"][0]["url"];
        $album2_name = $recommendations["tracks"][1]["album"]["name"];
        $album2_image = $recommendations["tracks"][1]["album"]["images"][0]["url"];
        return [[$album1_id, $album1_name, $album1_image], [$album2_id, $album2_name, $album2_image]];
    }
}
?>