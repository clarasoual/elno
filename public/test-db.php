<?php 
$config = require __DIR__ . '/../config/config.php' ;
$dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'] . ';charset=utf8mb4' ;
$pdo = new PDO($dsn, $config['user'], $config['password']) ; 
$result = $pdo->query('SELECT COUNT(*) FROM  formulas') ; 
echo 'Connexion réussie' ;
echo $result->fetchColumn() ; 