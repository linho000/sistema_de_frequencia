<?php
// Inclua o arquivo de conexão com o banco de dados
require_once "../config/db_conexao.php";

// Verifica se o parâmetro ID está presente na URL
if (!isset($_GET["id"])) {
    echo "ID do registro não fornecido.";
    exit();
}

$id = $_GET["id"];

try {
    // Crie a consulta SQL para obter o registro de frequência pelo ID
    $sql = "SELECT alunos.students_nome AS aluno_nome, frequencias.data, frequencias.hora, frequencias.presenca, frequencias.id 
            FROM frequencias 
            INNER JOIN alunos ON alunos.id = frequencias.aluno_id 
            WHERE frequencias.id = :id";

    // Prepare a declaração SQL
    $stmt = $pdo->prepare($sql);

    // Executa a declaração SQL com o ID como parâmetro
    $stmt->execute(["id" => $id]);

    // Verifica se o registro existe
    if ($stmt->rowCount() === 0) {
        echo "Registro não encontrado.";
        exit();
    }

    // Obtém os dados do registro de frequência
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se o formulário foi enviado
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        try {
            // Apaga o registro de frequência do banco de dados
            $sql = "DELETE FROM frequencias WHERE id = :id";

            // Prepare a declaração SQL
            $stmt = $pdo->prepare($sql);

            // Executa a declaração SQL com o ID como parâmetro
            $stmt->execute(["id" => $id]);

            // Redireciona para a página "relatorio_frequencia.php"
            header("Location: ../views/relatorio_frequencia.php");
            exit();
        } catch (PDOException $e) {
            echo "Erro ao apagar o registro de frequência: " . $e->getMessage();
        }
    }
} catch (PDOException $e) {
    echo "Erro ao recuperar o registro de frequência: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Apagar Registro de Frequência</title>

    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/cabecalho.css">
    <link rel="stylesheet" href="../css/apagar_registro.css">
</head>

<body>
    
    <header>
    <h1>Apagar Registro de Frequência</h1>
    <nav class="button-container">
      <a href="cadastro_alunos.php">
        <button type="button">Cadastro</button>
      </a>
      <a href="visualizar_alunos.php">
        <button type="button">Alunos</button>
      </a>
      <a href="frequencia_alunos.php">
        <button type="button">Frequência</button>
      </a>
      <a href="relatorio_frequencia.php">
        <button type="button" class="active">Relatório</button>
      </a>
    </nav>
  </header>
    <form class="excluir-form" action="" method="POST" onsubmit="return confirm('Tem certeza que deseja apagar o registro?')">
        <label for="aluno_nome">Nome do Aluno:</label>
        <input class="disabled" type="text" id="aluno_nome" value="<?php echo $registro['aluno_nome']; ?>" readonly>

        <label for="data">Data:</label>
        <input class="disabled" type="date" id="data" value="<?php echo $registro['data']; ?>" readonly>

        <label for="hora">Hora:</label>
        <input class="disabled" type="text" id="hora" value="<?php echo $registro['hora']; ?>" readonly>

        <label for="presenca">Presença:</label>
        <input class="disabled" type="text" id="presenca" value="<?php echo $registro['presenca'] == 1 ? 'Presente' : 'Ausente'; ?>" readonly>

        <p>Esta ação é irreversível. Todos os dados relacionados esse registro de frequência serão excluídos. Deseja continuar?</p>

        <input type="submit" value="Apagar Registro">
        <input type="button" value="Cancelar" onclick="window.location.href='../views/relatorio_frequencia.php'">
    </form>
</body>

</html>