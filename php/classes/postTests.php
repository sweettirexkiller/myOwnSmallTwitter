<?php
require_once __DIR__.'/../dbConfig.php';
require_once __DIR__.'/postClass.php';
$conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);

//TESTY dla loadPostById

//$testPost = post::loadPostById($conn, 1);
//var_dump($testPost);

//TESTY dla loadAllPostsByUserId

//$allTestPostsForUserId1 = post::loadAllPostsByUserId($conn, 1);
//var_dump($allTestPostsForUserId1);

//TESTY dla loadAllPosts
//$allPostsInDB = post::loadAllPosts($conn);
//var_dump($allPostsInDB);
//
//
//TESTY dla saveToDB

//$testPost = new post();
//$testPost->setContent("lorem ipsum, this message should be in database 1");
//$testPost->setDateOfCreation(date('Y-m-d G:i:s',time() - 3600*24));
//$testPost->setUser_id(1);
//
//$testPost->saveToDB($conn);
//
//$allPosts = post::loadAllPosts($conn);
//var_dump($allPosts);

//TESTY dla saveToDB

$allPosts = postWithEmail::loadAllPostsWithUserEmailOrderedByTime($conn);

var_dump($allPosts);