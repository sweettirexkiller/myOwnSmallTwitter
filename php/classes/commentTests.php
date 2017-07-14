<?php
require_once __DIR__.'/../dbConfig.php';
require_once __DIR__.'/commentClass.php';
$conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);

//Testy dla loadCommentById

//$testComment = comment::loadCommentById($conn, 1);
//var_dump($testComment);

//Testy dla loadCommentByPostId

//$testComments = comment::loadAllCommentsByPostId($conn, 3);
//var_dump($testComments);

//Testy dla saveToDB

//$testComment = new comment();
//$testComment->setContent('test test test');
//$testComment->setCreation_date(date('Y-m-d G:i:s'));
//$testComment->setPostId(3);
//$testComment->setUserId(1);
//var_dump($testComment);
//$testComment->saveToDB($conn);
//var_dump($testComment);


//Testy dla loadCommentByPostIdOrderedByTime

$testComments = comment::loadAllCommentsByPostIdOrderedByTimeWithAuthorEmail($conn, 3);
var_dump($testComments);