<?php
class user{
    private $id;
    private $email;
    private $hashed_password;
    
    
    public function __construct() {
        $this->id = null;
        $this->setEmail("");
        $this->hashed_password = "";
    }
            
    
    function getId() {return $this->id;}
    function getEmail() {return $this->email;}
    function verifyPassword($password) { password_verify($password,$this->hashed_password);}
    

    function setEmail($email) {
        $this->email = $email;
        return $this;
    }
    
    function setPassword($password) {
        $this->hashed_password = password_hash($password,PASSWORD_BCRYPT,['cost'=>11]);
        return $this;
    }

    public function saveToDB(PDO $conn){
        if($this->id){
            return false;
        }
        $stmt = $conn->prepare("INSERT INTO user(email,hashed_password) VALUES (:email, :password)");
        $result =  $stmt->execute([
            'email'=>$this->email, 
            'password'=>$this->hashed_password
        ]);
        if($result !== false){
            $this->id = $conn->lastInsertId();
            
            return true;
        }
    }
    
    static public function loadUserById(PDO $conn, $id){
        $stmt = $conn->prepare('SELECT * FROM user WHERE id=:id');
        $result = $stmt->execute(['id' => $id]);
        
        if($result == true && $stmt->rowCount() > 0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $loadUser = new user();
            $loadUser->id = $row['id'];
            $loadUser->email = $row['email'];
            $loadUser->hashed_password = $row['hashed_password'];
            
            return $loadUser;
        }
        
        return NULL;
    }
    
    static public function loadAllUsers(PDO $conn){
        
        $sql = "SELECT * FROM user";
        $ret = [];
        
        $result = $conn->query($sql);
        if($result !== false && $result->rowCount() != 0){
            foreach($result as $row){
                $loadUser = new User();
                $loadUser->id = $row['id'];
                $loadUser->email = $row['email'];
                $loadUser->hashed_password = $row['hashed_password'];
                
                $ret[] = $loadUser;
            }
        }
        return $ret;
    }
    
    
    
    
}

//TEST OF saveToDB:
//
//require_once __DIR__.'/../dbConfig.php';
//    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
//    $testUser = new user();
//    $testUser->setEmail("test@test.test");
//    $testUser->setPassword('pass');
//    $testUser->saveToDB($conn);
//    var_dump($testUser);
//    
//TEST OF loadUserById:
//
//require_once __DIR__.'/../dbConfig.php';
//    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
//    $loadedUser = user::loadUserById($conn, 3);
//    var_dump($loadedUser);
//    
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
    

