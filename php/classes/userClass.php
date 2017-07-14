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
    function verifyPassword($password){ 
       return password_verify($password,$this->hashed_password);
    }
    

    function setEmail($email) {
        $this->email = $email;
        return $this;
    }
    
    function setPassword($password) {
        $this->hashed_password = password_hash($password,PASSWORD_BCRYPT,['cost'=>11]);
        return $this;
    }

    public function saveToDB(PDO $conn){ //save new or update existing one
        if($this->id !== NULL){ // if the object already exists in the  database and has set id
            
            $stmt = $conn->prepare(
                    'UPDATE user SET email=:email, hashed_password=:hashed_password WHERE id=:id'
            );
            
            $result = $stmt->execute(
                    [
                     'email'            => $this->getEmail(), 
                     'hashed_password'  => $this->hashed_password,
                     'id'               => $this->getId()
                    ]
                    );
            
            if($result === true){
                return true;
            }
        }else{ // else if object deos not exist in databse yet
            $stmt = $conn->prepare("INSERT INTO user(email,hashed_password) VALUES (:email, :password)");
            $result =  $stmt->execute([
                'email'=>$this->email, 
                'password'=>$this->hashed_password
                ]);
            
            if($result === true){
                $this->id = $conn->lastInsertId();
                return true;
            }
        }
        return false;
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
    
    public function deleteFromDB(PDO $conn){
        if($this->id !== NULL){
            $stmt = $conn->prepare('DELETE FROM user WHERE id=:id');
            $result = $stmt->execute(['id'=>$this->id]);
            
            if($result === true){
                $this->id =  NULL;
                return true;
            }
        }
        return false;
    }
    
    
}
