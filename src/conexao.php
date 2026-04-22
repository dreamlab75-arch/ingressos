<?php
//Conexão com o banco de dados
$host = "localhost";
$db = "escola";
$user = "root";
$pass = "";

//try/catch para tratar erros de conexão

try{
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOexception $e){
    echo json_encode(["erro" => $e->getMessage()]);
    exit;
}