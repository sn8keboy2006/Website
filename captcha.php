<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

use Gregwar\Captcha\CaptchaBuilder;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Generate new CAPTCHA
    $builder = new CaptchaBuilder;
    $builder->build();
    $_SESSION['captcha_phrase'] = $builder->getPhrase();
    header('Content-type: image/jpeg');
    $builder->output();
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CAPTCHA
    $user_code = isset($_POST['code']) ? $_POST['code'] : '';
    $valid = isset($_SESSION['captcha_phrase']) && strtolower($user_code) === strtolower($_SESSION['captcha_phrase']);
    echo json_encode(['valid' => $valid]);
    exit;
}
?>