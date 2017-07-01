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
}

