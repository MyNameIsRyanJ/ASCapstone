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

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    $albumInfo = json_decode($response, true);
    return $albumInfo;
}

function albumToTracksArray($albumData) {
    foreach ($albumData["items"] as $tracks) {
        var_dump($tracks);
        echo "<br>";
    }
}

$url = 'https://api.spotify.com/v1/recommendations?limit=2&seed_genres=' . urlencode($genre);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $accessToken
]);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$recommendations = json_decode($response, true);

$album_id1 = $recommendations["tracks"][0]["album"]["id"];
$album_id2 = $recommendations["tracks"][1]["album"]["id"];

$album1Data = albumLookup($album_id1, $accessToken);
$album2Data = albumLookup($album_id2, $accessToken);
albumToTracksArray($album1Data);
?>