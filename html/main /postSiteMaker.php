<?php
require_once __DIR__.'/../../php/classes/postClass.php';
require_once __DIR__.'/../../php/classes/commentClass.php';
require_once __DIR__.'/../renderFunction.php';
require_once __DIR__.'/../../php/dbConfig.php';

if($_SERVER['REQUEST_METHOD'] === 'GET' || $_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_GET['id']) && intval($_GET['id']) > 0){
        session_start();
        $_SESSION['logged_user_id'] = 1; // logged a user by hand
        $_SESSION['postID'] = $_GET['id'];
        
        $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
//            add comment to database or show that you have to be logged in
            if(isset($_SESSION['logged_user_id']) && strlen($_POST['comment_content']) > 0){
                $newComment = new comment();
                $newComment->setContent($_POST['comment_content']);
                $newComment->setPostId($_SESSION['postID']);
                $newComment->setUserId($_SESSION['logged_user_id']);
                $newComment->setCreation_date(date('Y-m-d G:i:s'));
                $newComment->saveToDB($conn); 
                header('filename: postSiteMaker.php');
            }else{
                 $data = ['info'=>'You must be logged in to make a comment.'];
                 echo render('wrongFormTemplate.html', $data);
            }
        }
        
        
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

