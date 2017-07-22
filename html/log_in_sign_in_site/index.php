<?php

session_start();
require_once __DIR__ . '/../../php/classes/userClass.php';
require_once __DIR__ . '/../renderFunction.php';
require_once __DIR__ . '/../../php/dbConfig.php';
$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['new']) && $_GET['new'] == 1) {
        header('Location: http://localhost/myOwnSmallTwitter/html/log_in_sign_in_site/signInTemplate.html');
        exit;
    } else {
        require 'logInTemplate.html';
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['pwd'];
    $showed = false;
    if (strlen($email) > 0 && strlen($password) > 0) {
        $allUsers = user::loadAllUsers($conn);
        foreach ($allUsers as $user) {
            if ($user->getEmail() == $email && $user->verifyPassword($password)) {
                $_SESSION['logged_user_id'] = $user->getId(); // logged a user by hand
                header('Location: http://localhost/myOwnSmallTwitter/html/main/main.php');
                exit;
            }
        }
        $data = ['info' => 'Wrong password or email.'];
        echo render('wrongEmailTemplate.html', $data);
        $showed = true;
    } else {
        if (!$showed) {
            $data = ['info' => 'Wrong password or email.'];
            echo render('wrongEmailTemplate.html', $data);
        }
    }
}

