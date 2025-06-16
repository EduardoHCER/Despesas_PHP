<?php
// Configurações Banco
$host = 'localhost';
$dbname = 'controle_despesas';
$user = 'root'; 
$pass = '';   

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Em caso de erro na conexão, exibe a mensagem
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>