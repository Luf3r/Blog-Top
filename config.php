<?php
// inicia ou resume uma sessao PHP para manter estado entre paginas
// permite armazenar dados de usuario entre diferentes páginas
session_start();

// configuracoes de conexao com o banco de dados
$host = 'localhost';  
$db   = 'blog_db';    
$user = 'root';       
$pass = '';           

// cria a string DSN (Data Source Name) para conexao PDO
$dsn = "mysql:host=$host;dbname=$db";

// configura opcoes para a conexao PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // habilita lancamento de excecoes para erros
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // define o formato padrao de resultados como array associativo
    PDO::ATTR_EMULATE_PREPARES   => false, // usa prepared statements nativos do banco
];

try {
    // cria a conexao PDO (PHP Data Objects)
    // objeto que representa a conexao entre PHP e o banco de dados
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // captura excecoes de erro na conexao e relanca com detalhes
    // getMessage retorna a mensagem de erro descritiva
    // getCode retorna o codigo numerico do erro especifico
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>