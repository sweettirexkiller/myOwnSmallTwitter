<?php
session_start();
require_once __DIR__ . '/../../php/classes/userClass.php';
require_once __DIR__ . '/../renderFunction.php';
require_once __DIR__ . '/../../php/dbConfig.php';

$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_SESSION['logged_user_id'])){
        
    }else{
        $html = file_get_contents('notLoggedInWarning.html');
        echo $html;
    }
}