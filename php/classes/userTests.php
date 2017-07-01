<?php

//TEST OF saveToDB:

//require_once __DIR__.'/../dbConfig.php';
//    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
//    $testUser = new user();
//    $testUser->setEmail("test@test.test");
//    $testUser->setPassword('pass');
//    $testUser->saveToDB($conn);
//    var_dump($testUser);
    
//TEST OF loadUserById:

//require_once __DIR__.'/../dbConfig.php';
//    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
//    $loadedUser = user::loadUserById($conn, 3);
//    var_dump($loadedUser);
   
//TEST OF loadAllUsers: 

//require_once __DIR__.'/../dbConfig.php';
//    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
//    
//    $testUser1 = new user();
//    $testUser1->setEmail("test1@test.test");
//    $testUser1->setPassword('pass1');
//    $testUser1->saveToDB($conn);
//    
//    $testUser2 = new user();
//    $testUser2->setEmail("test2@test.test");
//    $testUser2->setPassword('pass2');
//    $testUser2->saveToDB($conn);
//    
//    $collectionOfallUsers = user::loadAllUsers($conn);
//    var_dump($collectionOfallUsers);
    
//TEST OF saveToDb when we want to UPDATE a row, change its values in DB:
//
//    require_once __DIR__.'/../dbConfig.php';
//    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
//    
//    //new one
//    $testUser1 = new user();
//    $testUser1->setEmail("test1@test.test");
//    $testUser1->setPassword('pass1');
//    $testUser1->saveToDB($conn);
//    
//    $collectionOfallUsers = user::loadAllUsers($conn);
//    var_dump($collectionOfallUsers);
//    
//    //make some changes
//    $testUser1->setEmail("test1changed@test.test");
//    $testUser1->setPassword('pass1changed');
//    $testUser1->saveToDB($conn);
//    
//    $collectionOfallUsers1 = user::loadAllUsers($conn);
//    var_dump($collectionOfallUsers1);
