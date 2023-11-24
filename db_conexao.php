<?php
// Configurações de conexão com o banco de dados
$host = "localhost";
$dbname = "sistema_de_frequencia_atualizado";
$username = "root";
$password = "";

try {
    // Conexão com o banco de dados usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Define o modo de erro do PDO como exceção para lidar com erros de maneira adequada
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retorne a conexão PDO para ser usada em outras partes do seu código
    return $pdo;
} catch (PDOException $e) {
    // Em caso de erro na conexão, exiba uma mensagem de erro ou trate o erro de acordo com sua necessidade
    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
    exit();
}
?>
