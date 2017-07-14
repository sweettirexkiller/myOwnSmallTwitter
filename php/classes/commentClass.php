<?php
class comment {
    private $id;
    private $userId;
    private $postId;
    private $creation_date;
    private $content;
    
    function __construct() {
        $this->id = NULL;
        $this->userId = 0;
        $this->postId = 0;
        $this->creation_date = 0;
        $this->content = '';
    }

    
    function getId() {
        return $this->id;
    }

    function getUserId() {
        return $this->userId;
    }

    function getPostId() {
        return $this->postId;
    }

    function getCreation_date() {
        return $this->creation_date;
    }

    function getContent() {
        return $this->content;
    }
    

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setPostId($postId) {
        $this->postId = $postId;
    }

    function setCreation_date($creation_date) {
        $this->creation_date = $creation_date;
    }

    function setContent($content) {
        $this->content = $content;
    }

    static public function loadCommentById(PDO $conn,$id){
        $stmt = $conn->prepare('SELECT * FROM comment WHERE id=:id');
        $result = $stmt->execute(['id' => $id]);
        
        if($result == true && $stmt->rowCount() > 0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $loadComment = new comment();
            $loadComment->id = $row['id'];
            $loadComment->setPostId($row['post_id']);
            $loadComment->setUserId($row['user_id']);
            $loadComment->setCreation_date($row['dateOfCreation']);
            $loadComment->setContent($row['content']);
            
            return $loadComment;
        }
        
        return NULL;
    }
    
    static public function loadAllCommentsByPostId(PDO $conn, $id){
        $sql = "SELECT * FROM comment WHERE post_id=:id";
        $ret = [];
        
        if($id > 0){
            $stmt = $conn->prepare($sql);
            $boolean = $stmt->execute(['id'=>$id]);
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            if($boolean && $stmt->rowCount() > 0){
                foreach($result as $row){
                    $loadComment = new comment();
                    $loadComment->id = $row['id'];
                    $loadComment->setPostId($row['post_id']);
                    $loadComment->setUserId($row['user_id']);
                    $loadComment->setCreation_date($row['dateOfCreation']);
                    $loadComment->setContent($row['content']);
                    
                    $ret[] = $loadComment;
                }
            }
        }
        return $ret;
    }
    
    public function saveToDB(PDO $conn){
         if($this->id !== NULL){ // if the object already exists in the  database and has set id
            return false;
        }else{ // else if object deos not exist in databse yet 
            $stmt = $conn->prepare("INSERT INTO comment(post_id,user_id, dateOfCreation, content) VALUES (:post_id,:user_id, :dateOfCreation, :content)");
            $result =  $stmt->execute([
                'post_id'=>$this->getPostId(), 
                'user_id'=>$this->getUserId(),
                'dateOfCreation'=>$this->getCreation_date(),
                'content'=>$this->getContent()
                ]);
            if($result === true){
                $this->id = $conn->lastInsertId();
                return true;
            }
        }
        return false;
    }
    static public function loadAllCommentsByPostIdOrderedByTime(PDO $conn, $id){
        $sql = "SELECT * FROM comment WHERE post_id=:id ORDER BY dateOfCreation DESC";
        $ret = [];
        
        if($id > 0){
            $stmt = $conn->prepare($sql);
            $boolean = $stmt->execute(['id'=>$id]);
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            if($boolean && $stmt->rowCount() > 0){
                foreach($result as $row){
                    $loadComment = new comment();
                    $loadComment->id = $row['id'];
                    $loadComment->setPostId($row['post_id']);
                    $loadComment->setUserId($row['user_id']);
                    $loadComment->setCreation_date($row['dateOfCreation']);
                    $loadComment->setContent($row['content']);
                    
                    $ret[] = $loadComment;
                }
            }
        }
        return $ret;
    }

}
