<?php

session_start();
require_once __DIR__ . '/../../php/classes/userClass.php';
require_once __DIR__ . '/../../php/classes/messageClass.php';
require_once __DIR__ . '/../renderFunction.php';
require_once __DIR__ . '/../../php/dbConfig.php';

$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_SESSION['logged_user_id'])) {
        $user = User::loadUserById($conn, $_SESSION['logged_user_id']);
        $messages = message::getAllMessagesByUserEmail($conn, $user->getEmail());
        $message_html = '';
        foreach ($messages as $message) {
            $receiver = User::loadUserById($conn, $message['receiver_id']);
            $data = [
                'receiver' => $receiver->getEmail(),
                'content' => $message['content'],
                 'date' => $message['dateOfSending']
            ];
            $message_html .= render('messages/messagesTemplate.html', $data);
        }

        $data = [
            'user_email' => $user->getEmail(),
            'messages' => $message_html
        ];
        echo render('userSiteTemplate.html', $data);
    } else {
        $html = file_get_contents('notLoggedInWarning.html');
        echo $html;
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['receiver_email']) && isset($_POST['content'])) {
        $receiver_email = $_POST['receiver_email'];
        if (User::authenticateUserByEmail($conn, $receiver_email)) {
            $content = $_POST['content'];
            if (!(strlen($content) < 1 || strlen($content) > 255)) {


                $sender = User::loadUserById($conn, $_SESSION['logged_user_id']);
                $message = new message();
                $message->setContent($content);
                $message->sendAndSave($conn, $sender->getEmail(), $receiver_email);
                echo'<p><b>Message Send</b></p>';
            } else {
                echo'<p><b>To short or to long message. MAX 255 characters.</b></p>';
            }
        } else {
            echo '<p><b>No such user email in the database.</b></p>';
        }
    }


     if (isset($_SESSION['logged_user_id'])) {
        $user = User::loadUserById($conn, $_SESSION['logged_user_id']);
        $messages = message::getAllMessagesByUserEmail($conn, $user->getEmail());
        $message_html = '';
        foreach ($messages as $message) {
            $receiver = User::loadUserById($conn, $message['receiver_id']);
            $data = [
                'receiver' => $receiver->getEmail(),
                'content' => $message['content'],
                 'date' => $message['dateOfSending']
            ];
            $message_html .= render('messages/messagesTemplate.html', $data);
        }

        $data = [
            'user_email' => $user->getEmail(),
            'messages' => $message_html
        ];
        echo render('userSiteTemplate.html', $data);
    } else {
        $html = file_get_contents('notLoggedInWarning.html');
        echo $html;
    }
}