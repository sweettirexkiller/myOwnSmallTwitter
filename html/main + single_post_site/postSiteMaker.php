<?php
require_once __DIR__.'/../../php/classes/postClass.php';
require_once __DIR__.'/../renderFunction.php';
require_once __DIR__.'/../../php/dbConfig.php';

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(isset($_GET['id']) && intval($_GET['id']) > 0){
        
        $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
        
        $postId = $_GET['id'];
        $singlePostObject = post::loadPostById($conn, $postId);
        $data = [
            'post_id' => $singlePostObject->getId(),
            'user_id' => $singlePostObject->getUser_id(),
            'content' => $singlePostObject->getContent(),
            'date' => $singlePostObject->getDateOfCreation()
        ];
                
        echo render('singlePostSiteTemplate.html', $data);
    }
}

