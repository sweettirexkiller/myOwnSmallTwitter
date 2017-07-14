<?php

session_start();
require_once __DIR__ . '/../../php/classes/userClass.php';
require_once __DIR__ . '/../renderFunction.php';
require_once __DIR__ . '/../../php/dbConfig.php';
$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    require 'logInTemplate.html';
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    
    
    
    header('Location: http://localhost/myOwnSmallTwitter/html/main%20/main.php');
    exit;
}

