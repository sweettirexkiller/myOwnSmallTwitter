<?php
require_once __DIR__.'/../dbConfig.php';
require_once __DIR__.'/commentClass.php';
$conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);

//Testy dla loadCommentById

//$testComment = comment::loadCommentById($conn, 1);
//var_dump($testComment);