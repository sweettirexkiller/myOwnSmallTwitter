<?php
class user{
    private $id;
    private $email;
    private $password;
    
    
    public function __construct() {
        $this->id = null;
    }
            
    
    function getId() {return $this->id;}
    function getEmail() {return $this->email;}
    function verifyPassword($password) { password_verify($password,$this->password);}
    

    function setEmail($email) {
        $this->email = $email;
        return $this;
    }
    
    function setPassword($password) {
        $this->password = password_hash($password,PASSWORD_BCRYPT,['cost'=>11]);
        return $this;
    }

    public function saveToDB(PDO $conn){
        if($this->id){
            return false;
        }
        $stmt = $conn->prepare("INSERT INTO user (email,hashed_password) VALUES (:email, :password");
        return  $stmt->execute([
            'email'=>$this->email, 
            'password'=>$this->password
        ]);
    }


}

