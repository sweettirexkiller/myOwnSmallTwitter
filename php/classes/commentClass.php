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

    function getText() {
        return $this->text;
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

    function setContent($text) {
        $this->text = $text;
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
        $sql = "SELECT * FROM comment WHERE post_id=':id'";
        $ret = [];
        
        if($id > 0){
            $stmt = $conn->prepare($sql);
            $stmt->execute(['id'=>$id]);
            
            $result = $stmt->fetchAll(); 
            if($stmt->rowCount() > 0){
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
