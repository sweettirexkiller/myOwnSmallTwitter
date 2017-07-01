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
}

//TEST OF saveToDB:
//require_once __DIR__.'/../dbConfig.php';
//    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
//    $testUser = new user();
//    $testUser->setEmail("test@test.test");
//    $testUser->setPassword('pass');
//    $testUser->saveToDB($conn);
//    var_dump($testUser);
//TEST OF loadUserById:
//    $loadedUser = user::loadUserById($conn, 3);
//    var_dump($loadedUser);
    

