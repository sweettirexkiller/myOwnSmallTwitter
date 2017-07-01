<?php
require_once __DIR__.'/../dbConfig.php';
require_once __DIR__.'/userClass.php';
$conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
//TEST OF saveToDB:
//    $testUser = new user();
//    $testUser->setEmail("test@test.test");
//    $testUser->setPassword('pass');
//    $testUser->saveToDB($conn);
//    var_dump($testUser);
//TEST OF loadUserById:
//    $loadedUser = user::loadUserById($conn, 3);
//    var_dump($loadedUser);
//TEST OF loadAllUsers: 
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
//TEST OF deleteFromDB:
    //new one
//    $testUser1 = new user();
//    $testUser1->setEmail("test1@test.test");
//    $testUser1->setPassword('pass1');
//    $testUser1->saveToDB($conn);
//    
//    echo "Before deleting: <br>";
//    $collectionOfallUsersFromDB = user::loadAllUsers($conn);
//    echo "All in DB: <br>";
//    var_dump($collectionOfallUsersFromDB);
//    echo "All in PHP: <br>";
//    var_dump($testUser1);
//    
//    $testUser1->deleteFromDB($conn);
//    
//    echo "After deleting: <br>";
//    $collectionOfallUsers = user::loadAllUsers($conn);
//    echo "All in DB: <br>";
//    var_dump($collectionOfallUsers);
//    echo "All in PHP: <br>";
//    var_dump($testUser1);
//    

