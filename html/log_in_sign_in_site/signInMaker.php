<?php
session_start();
require_once __DIR__ . '/../../php/classes/userClass.php';
require_once __DIR__ . '/../renderFunction.php';
require_once __DIR__ . '/../../php/dbConfig.php';
$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(strlen($_POST['pwd']) > 0 && strlen($_POST['email']) > 1){
        if(strlen($_POST['pwd']) > 7){
            $addUser = new user();
            $addUser->setEmail($_POST['email'])->setPassword($_POST['pwd'])->saveToDB($conn);
            $_SESSION['logged_user_id'] = $addUser->getId();
            header('Location: http://localhost/myOwnSmallTwitter/html/main%20/main.php');
            exit;
        }else{
            $data = ['info' => 'Too short password.'];
            echo render('wrongPasswordTemplate.html', $data);
        }
    }
}