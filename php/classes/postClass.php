<?php
class post{
    private $id;
    private $user_id;
    private $content;
    private $dateOfCreation;
    
    public function __construct() {
        $this->id = NULL;
        $this->setContent('');
        $this->setDateOfCreation(null);
        $this->setUser_id(null);
    }
            
    function getId() {
        return $this->id;
    }

    function getUser_id() {
        return $this->user_id;
    }

    function getContent() {
        return $this->content;
    }

    function getDateOfCreation() {
        return $this->dateOfCreation;
    }

    function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    function setContent($content) {
        $this->content = $content;
    }

    function setDateOfCreation($dateOfCreation) {
        $this->dateOfCreation = $dateOfCreation;
    }

    static public function loadPostById(PDO $conn, $id){
        $stmt = $conn->prepare('SELECT * FROM post WHERE id=:id');
        $result = $stmt->execute(['id' => $id]);
        
        if($result == true && $stmt->rowCount() > 0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $loadPost = new post();
            $loadPost->id = $row['id'];
            $loadPost->content = $row['content'];
            $loadPost->user_id= $row['user_id'];
            $loadPost->dateOfCreation= $row['dateOfCreation'];
            
            
            return $loadPost;
        }
        
        return NULL;
    }
    
    static public function loadAllPostsByUserId(PDO $conn, $id){
        $sql = "SELECT post.user_id, post.id as post_id, post.content, post.dateOfCreation FROM user JOIN post ON user.id=post.user_id WHERE user.id=:id";
        $ret = [];
        
        if($id > 0){
            $stmt = $conn->prepare($sql);
            $didSucced = $stmt->execute(['id'=>$id]);
            
            $result = $stmt->fetchAll(); 
            
            if($didSucced === true && $stmt->rowCount() > 0){
                foreach($result as $row){
                    $loadPost = new post();
                    $loadPost->id = $row['post_id'];
                    $loadPost->content = $row['content'];
                    $loadPost->user_id= $row['user_id'];
                    $loadPost->dateOfCreation= $row['dateOfCreation'];
                    
                    $ret[] = $loadPost;
                }
            }
        }
        
        return $ret;
    }
    
    
    static public function loadAllPosts(PDO $conn){
        $sql = "SELECT * FROM post";
        $ret = [];
        
        $result = $conn->query($sql);
        
        if($result !== false && $result->rowCount() > 0){
            foreach($result as $row){
                $loadPost = new post();
                $loadPost->id = $row['id'];
                $loadPost->content = $row['content'];
                $loadPost->user_id= $row['user_id'];
                $loadPost->dateOfCreation= $row['dateOfCreation'];
                
                $ret[] = $loadPost;
            }
        }
        return $ret;
    }
    
    public function saveToDB(PDO $conn){
        if($this->id !== NULL){ // if the object already exists in the  database and has set id
            
            $stmt = $conn->prepare(
                    'UPDATE post SET content=:content, user_id=:user_id, dateOfCreation=:dateOfCreation WHERE id=:id'
            );
            
            $result = $stmt->execute(
                    [
                     'content'           => $this->getContent(), 
                     'user_id'           => $this->getUser_id(),
                     'dateOfCreation'    => $this->getDateOfCreation(),
                     'id'                => $this->getId()
                    ]
                    );
            
            if($result === true){
                return true;
            }
        }else{ // else if object deos not exist in databse yet
            $stmt = $conn->prepare("INSERT INTO post(content, user_id, dateOfCreation) VALUES (:content, :user_id, :dateOfCreation)");
            $result =  $stmt->execute([
                'content'           => $this->getContent(), 
                'user_id'           => $this->getUser_id(),
                'dateOfCreation'    => $this->getDateOfCreation()
                ]);
            
            if($result === true){
                $this->id = $conn->lastInsertId();
                return true;
            }
        }
        return false;
    }
    
    
    
    
}

