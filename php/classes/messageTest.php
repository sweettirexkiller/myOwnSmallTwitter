<?php
require_once __DIR__.'/../dbConfig.php';
require_once __DIR__.'/messageClass.php';
$conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);

//those tests are teriible