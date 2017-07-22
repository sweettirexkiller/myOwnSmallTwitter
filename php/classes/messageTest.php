<?php
require_once __DIR__.'/../dbConfig.php';
require_once __DIR__.'/messageClass.php';
require_once __DIR__.'/userClass.php';
$conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);

//Tests for getAllMessagesByUserEmail

try{
    $user = User::loadUserById($conn, 1);
    $messages = message::getAllMessagesByUserEmail($conn, $user->getEmail());
    var_dump($messages);
} catch (Exception $ex) {
    echo $ex->getMessage();
}