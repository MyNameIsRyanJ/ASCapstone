<?php
    $client_id = 'fecdbc2c26e14f288ffb9233e528844e';
    $redirect_uri = 'http://localhost:80/ASCapstone/index.php';

    function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    $state = generateRandomString(16);
    $scope = 'user-read-private user-read-email';

    header('Location: https://accounts.spotify.com/authorize?' . http_build_query([
        'response_type' => 'code',
        'client_id' => $client_id,
        'scope' => $scope,
        'redirect_uri' => $redirect_uri,
        'state' => $state
    ]));
?>
