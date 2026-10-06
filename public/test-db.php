<?php 
$config = require __DIR__ . '/../config/config.php' ;
$dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'] . ';charset=utf8mb4' ;
$pdo = new PDO($dsn, $config['user'], $config['password']) ; 
echo 'Connexion réussie' ;