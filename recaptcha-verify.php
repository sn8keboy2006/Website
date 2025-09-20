<?php
// Replace with your secret key from Google reCAPTCHA
$secret = '6Lemys8rAAAAAGBRuobNO4YJL5lBEVgvFwnE7yQg';

$recaptcha_response = $_POST['g-recaptcha-response'];

if (!$recaptcha_response) {
    echo json_encode(['success' => false, 'error' => 'Missing reCAPTCHA']);
    exit;
}

$url = 'https://www.google.com/recaptcha/api/siteverify';
$data = [
    'secret' => $secret,
    'response' => $recaptcha_response,
    'remoteip' => $_SERVER['REMOTE_ADDR']
];

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    ]
];
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$verification = json_decode($result, true);

if ($verification["success"] === true) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'reCAPTCHA failed']);
}
?>