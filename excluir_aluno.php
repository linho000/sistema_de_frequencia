<?php
// Inclua o arquivo de conexão com o banco de dados
require_once "../config/db_conexao.php";

// Verifique se o parâmetro de ID do aluno foi fornecido
if (isset($_GET['aluno_id'])) {
    $alunoId = $_GET['aluno_id'];

    try {
        // Recupere os dados do aluno e responsáveis
        $sql = "SELECT a.id AS aluno_id, a.students_nome AS aluno_nome, a.students_data_nascimento AS aluno_data_nascimento, a.students_email AS aluno_email, a.students_telefone AS aluno_telefone,
                r.guardian_nome AS responsavel_nome, r.guardian_data_nascimento AS responsavel_data_nascimento, r.guardian_email AS responsavel_email,
                r.guardian_telefone AS responsavel_telefone, r.guardian_endereco AS responsavel_endereco
                FROM alunos a
                INNER JOIN responsaveis r ON a.id = r.aluno_id
                WHERE a.id = :alunoId";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':alunoId', $alunoId);
        $stmt->execute();

        $aluno = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$aluno) {
            echo "Aluno não encontrado.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Erro ao recuperar os dados do aluno: " . $e->getMessage();
        exit();
    }
} else {
    echo "ID do aluno não fornecido.";
    exit();
}

// Verifique se o formulário de confirmação foi enviado
if (isset($_POST['confirmar_exclusao'])) {
    try {
        // Excluir responsáveis do aluno do banco de dados
        $sqlResponsavel = "DELETE FROM responsaveis WHERE aluno_id = :alunoId";
        $stmtResponsavel = $pdo->prepare($sqlResponsavel);
        $stmtResponsavel->bindValue(':alunoId', $alunoId);
        $stmtResponsavel->execute();

        // Excluir aluno do banco de dados
        $sqlAluno = "DELETE FROM alunos WHERE id = :alunoId";
        $stmtAluno = $pdo->prepare($sqlAluno);
        $stmtAluno->bindValue(':alunoId', $alunoId);
        $stmtAluno->execute();

        // Redirecionar para a página "visualizar_alunos.php" após a exclusão
        header("Location: visualizar_alunos.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao excluir aluno: " . $e->getMessage();
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Excluir Aluno</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/cabecalho.css">
    <link rel="stylesheet" href="../css/excluir_aluno.css">
</head>

<body>
    <header>
        <h1>Confirmação de Exclusão</h1>
        <nav class="button-container">
            <a href="cadastro_alunos.php">
                <button type="button">Cadastro</button>
            </a>
            <a href="visualizar_alunos.php">
                <button type="button" class="active">Alunos</button>
            </a>
            <a href="frequencia_alunos.php">
                <button type="button">Frequência</button>
            </a>
            <a href="relatorio_frequencia.php">
                <button type="button">Relatório</button>
            </a>
        </nav>
    </header>
    <main>
        <form method="POST" action="">
            <div class="form-group">
                <label for="aluno_nome">Aluno:</label>
                <input type="text" id="aluno_nome" name="aluno_nome" value="<?php echo $aluno['aluno_nome']; ?>" disabled>
            </div>

            <div class="form-group">
                <label for="aluno_data_nascimento">Data de Nascimento:</label>
                <input type="text" id="aluno_data_nascimento" name="aluno_data_nascimento" value="<?php echo $aluno['aluno_data_nascimento']; ?>" disabled>
            </div>

            <div class="form-group">
                <label for="aluno_email">E-mail:</label>
                <input type="text" id="aluno_email" name="aluno_email" value="<?php echo $aluno['aluno_email']; ?>" disabled>
            </div>

            <div class="form-group">
                <label for="aluno_telefone">Telefone:</label>
                <input type="text" id="aluno_telefone" name="aluno_telefone" value="<?php echo $aluno['aluno_telefone']; ?>" disabled>
            </div>

            <div class="form-group">
                <label for="responsavel_nome">Responsável:</label>
                <input type="text" id="responsavel_nome" name="responsavel_nome" value="<?php echo $aluno['responsavel_nome']; ?>" disabled>
            </div>

            <div class="form-group">
                <label for="responsavel_data_nascimento">Data de Nascimento do Responsável:</label>
                <input type="text" id="responsavel_data_nascimento" name="responsavel_data_nascimento" value="<?php echo $aluno['responsavel_data_nascimento']; ?>" disabled>
            </div>

            <div class="form-group">
                <label for="responsavel_email">E-mail do Responsável:</label>
                <input type="text" id="responsavel_email" name="responsavel_email" value="<?php echo $aluno['responsavel_email']; ?>" disabled>
            </div>

            <div class="form-group">
                <label for="responsavel_telefone">Telefone do Responsável:</label>
                <input type="text" id="responsavel_telefone" name="responsavel_telefone" value="<?php echo $aluno['responsavel_telefone']; ?>" disabled>
            </div>

            <div class="form-group">
                <label for="responsavel_endereco">Endereço do Responsável:</label>
                <input type="text" id="responsavel_endereco" name="responsavel_endereco" value="<?php echo $aluno['responsavel_endereco']; ?>" disabled>
            </div>

            <div class="button-container-exluir">
                <button type="submit" name="confirmar_exclusao">Confirmar Exclusão</button>
                <a href="visualizar_alunos.php">Cancelar</a>
            </div>
        </form>
    </main>
</body>

</html>