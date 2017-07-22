<?php

class message {

    private $id;
    private $sender_id;
    private $receiver_id;
    private $content;
    private $dateOfSending;

    function __construct() {
        $this->id = NULL;
        $this->sender_id = 0;
        $this->receiver_id = 0;
        $this->content = "";
        $this->dateOfSending = 0;
    }

    function getId() {
        return $this->id;
    }

    function getSender_id() {
        return $this->sender_id;
    }

    function getReceiver_id() {
        return $this->receiver_id;
    }

    function getContent() {
        return $this->content;
    }

    function getDateOfSending() {
        return $this->dateOfSending;
    }

    function setSender_id($sender_id) {
        $this->sender_id = $sender_id;
    }

    function setReceiver_id($receiver_id) {
        $this->receiver_id = $receiver_id;
    }

    function setContent($content) {
        $this->content = $content;
    }

    function setDateOfSending($dateOfSending) {
        $this->dateOfSending = $dateOfSending;
    }

    public function sendAndSave(PDO $conn, $sender_email, $receiver_email) { //save new, there is not option for update
        if ($this->id !== NULL) { // if the object already exists in the  database and has set id
            return false;
        } else { // else if object deos not exist in databse yet
            $sender = User::loadUserByEmail($conn, $sender_email);
            $receiver = User::loadUserByEmail($conn, $receiver_email);

            $stmt = $conn->prepare("INSERT INTO message(sender_id, receiver_id, content, dateOfSending) VALUES (:sender_id, :receiver_id, :content, :dateOfSending)");
            $result = $stmt->execute([
                "sender_id" => $sender->getId(),
                "receiver_id" => $receiver->getId(),
                "content" => $this->content,
                "dateOfSending" => date('Y-m-d G:i:s')
            ]);

            if ($result === true) {
                $this->id = $conn->lastInsertId();
                return true;
            }
        }
        return false;
    }

    static public function getAllMessagesByUserEmail(PDO $conn, $user_email) {
        $user = User::loadUserByEmail($conn, $user_email);
        $ret = [];
        $stmt = $conn->prepare('SELECT * FROM message WHERE sender_id = :id');
        $result = $stmt->execute([
            'id' => $user->getId()
        ]);
        if ($result === true) {
            foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $message){
                $ret[] = $message;
            }
        }
        return $ret;
    }

}
