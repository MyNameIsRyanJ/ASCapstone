<?php
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/me");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $authObj["access_token"]
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    $prof_obj = json_decode($response, true);
?>