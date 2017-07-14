<?php
require_once __DIR__.'/../../php/classes/postClass.php';
require_once __DIR__.'/../../php/classes/commentClass.php';
require_once __DIR__.'/../renderFunction.php';
require_once __DIR__.'/../../php/dbConfig.php';

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(isset($_GET['id']) && intval($_GET['id']) > 0){
        
        $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
        
        
        
        $postId = $_GET['id'];
        $singlePostObject = post::loadPostById($conn, $postId);
        
        $allPostCommentsOrderedByTime = comment::loadAllCommentsByPostIdOrderedByTimeWithAuthorEmail($conn, $postId);
        //rendering comments
        $allCommentsRendered = '';
        foreach($allPostCommentsOrderedByTime as $comment){
            $data = [
                'author_email' => $comment->author,
                'content' => $comment->getContent(),
                'dateOfCreation' => $comment->getCreation_date()
            ];
            $allCommentsRendered .= render('commentsUnderPostTemplate.html', $data); 
        }
        $data = [
            'post_id' => $singlePostObject->getId(),
            'user_id' => $singlePostObject->getUser_id(),
            'content' => $singlePostObject->getContent(),
            'date' => $singlePostObject->getDateOfCreation(),
            'comments' => $allCommentsRendered
        ];
                
        echo render('singlePostSiteTemplate.html', $data);
    }
}

