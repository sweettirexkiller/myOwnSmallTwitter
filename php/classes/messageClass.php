<?php
class message{
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

    


}