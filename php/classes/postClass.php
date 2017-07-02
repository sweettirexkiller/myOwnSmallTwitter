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

    function setId($id){
        $this->id= $id;
        return $this;
    }
    
    function setUser_id($user_id) {
        $this->user_id = $user_id;
        return $this;
    }

    function setContent($content) {
        $this->content = $content;
        return $this;
    }

    function setDateOfCreation($dateOfCreation) {
        $this->dateOfCreation = $dateOfCreation;
        return $this;
    }

    static public function loadPostById(PDO $conn, $id){
        $stmt = $conn->prepare('SELECT * FROM post WHERE id=:id');
        $result = $stmt->execute(['id' => $id]);
        
        if($result == true && $stmt->rowCount() > 0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $loadPost = new post();
            $loadPost->id = $row['id'];
            $loadPost->setContent($row['content']);
            $loadPost->setUser_id($row['user_id']);
            $loadPost->setDateOfCreation($row['dateOfCreation']);
            
            
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
                    $loadPost->setContent($row['content']);
                    $loadPost->setUser_id($row['user_id']);
                    $loadPost->setDateOfCreation($row['dateOfCreation']);
                    
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
                $loadPost->setContent($row['content']);
                $loadPost->setUser_id($row['user_id']);
                $loadPost->setDateOfCreation($row['dateOfCreation']);
                
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

class postWithEmail extends post{
    private $email;
    
    
    function getEmail() {
        return $this->email;
    }
    
    function setEmail($email) {
        $this->email = $email;
    }

    public function __construct() {
        parent::__construct();
        $this->email = '';
    }
    
    static public function loadAllPostsWithUserEmailOrderedByTime($conn){
        $sql = "SELECT user.email as email, post.content as content, post.dateOfCreation as dateOfCreation, post.id as post_id FROM post JOIN user ON user.id = post.user_id ORDER BY post.dateOfCreation DESC";
        $ret = [];
        
        $result = $conn->query($sql);
        
        if($result !== false && $result->rowCount() > 0){
            foreach($result as $row){
                $loadPostWitEmail = new postWithEmail();
                $loadPostWitEmail->setEmail($row['email']);
                $loadPostWitEmail->setContent($row['content']);
                $loadPostWitEmail->setDateOfCreation($row['dateOfCreation']);
                $loadPostWitEmail->setId($row['post_id']);
                $ret[] = $loadPostWitEmail;
            }
        }
        return $ret;
    }

}