<?php
    $client_secret = '0eb5480fe3de46979e773f693785cb54';
    $client_id = 'fecdbc2c26e14f288ffb9233e528844e';
    $redirect_uri = 'http://localhost:80/ASCapstone/index.php';

    function handleStateMismatch() {
        header('Location: /#' . http_build_query(['error' => 'state_mismatch']));
        exit;
    }

    if ($_GET['state'] === null) {
        handleStateMismatch();
    } else {
        $code = $_GET['code'] ?? null;
        $state = $_GET['state'] ?? null;

        if ($state === null) {
            handleStateMismatch();
        } else {
            $authOptions = [
                'http' => [
                    'method' => 'POST',
                    'header' => 'Authorization: Basic ' . base64_encode($client_id . ':' . $client_secret) . "\r\n" .
                                'Content-Type: application/x-www-form-urlencoded',
                    'content' => http_build_query([
                        'code' => $code,
                        'redirect_uri' => $redirect_uri,
                        'grant_type' => 'authorization_code'
                    ])
                ]
            ];

            $context = stream_context_create($authOptions);
            $response = file_get_contents('https://accounts.spotify.com/api/token', false, $context);
            $authObj = json_decode($response, true);
        }
    }
?>