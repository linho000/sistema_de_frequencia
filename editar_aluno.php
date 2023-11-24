<?php
// Inclua o arquivo de conexão com o banco de dados
require_once "../config/db_conexao.php";

// Verifique se o parâmetro aluno_id está presente na URL
if (isset($_GET['aluno_id'])) {
    // Recupere o valor do parâmetro aluno_id
    $aluno_id = $_GET['aluno_id'];

    try {
        // Crie a instrução SQL para selecionar os dados do aluno e seu responsável pelo ID
        $sql = "SELECT a.id AS aluno_id, a.students_nome AS aluno_nome, a.students_data_nascimento AS aluno_data_nascimento, a.students_email AS aluno_email, a.students_telefone AS aluno_telefone,
                r.guardian_nome AS responsavel_nome, r.guardian_data_nascimento AS responsavel_data_nascimento, r.guardian_email AS responsavel_email,
                r.guardian_telefone AS responsavel_telefone, r.guardian_endereco AS responsavel_endereco
                FROM alunos a
                INNER JOIN responsaveis r ON a.id = r.aluno_id
                WHERE a.id = :aluno_id";

        // Prepare a consulta SQL
        $stmt = $pdo->prepare($sql);

        // Substitua o marcador de parâmetro pelo valor do aluno_id
        $stmt->bindValue(':aluno_id', $aluno_id);

        // Execute a consulta SQL
        $stmt->execute();

        // Verifique se o aluno foi encontrado
        if ($stmt->rowCount() > 0) {
            // Obtém o registro do aluno como um array associativo
            $aluno = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            // Redirecione de volta para a página "visualizar_alunos.php" se o aluno não for encontrado
            header("Location: visualizar_alunos.php");
            exit();
        }
    } catch (PDOException $e) {
        // Em caso de erro, exiba uma mensagem de erro ou trate o erro de acordo com sua necessidade
        echo "Erro ao recuperar os dados do aluno: " . $e->getMessage();
        exit();
    }
} else {
    // Redirecione de volta para a página "visualizar_alunos.php" se o parâmetro aluno_id não estiver presente
    header("Location: visualizar_alunos.php");
    exit();
}

// Verifique se o formulário foi enviado para atualizar os dados do aluno
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupere os valores do formulário
    $aluno_nome = $_POST['aluno_nome'];
    $aluno_data_nascimento = $_POST['aluno_data_nascimento'];
    $aluno_email = $_POST['aluno_email'];
    $aluno_telefone = $_POST['aluno_telefone'];
    $responsavel_nome = $_POST['responsavel_nome'];
    $responsavel_data_nascimento = $_POST['responsavel_data_nascimento'];
    $responsavel_email = $_POST['responsavel_email'];
    $responsavel_telefone = $_POST['responsavel_telefone'];
    $responsavel_endereco = $_POST['responsavel_endereco'];

    try {
        // Atualize os dados do aluno e responsável no banco de dados
        $sql = "UPDATE alunos a
                INNER JOIN responsaveis r ON a.id = r.aluno_id
                SET a.students_nome = :aluno_nome,
                    a.students_data_nascimento = :aluno_data_nascimento,
                    a.students_email = :aluno_email,
                    a.students_telefone = :aluno_telefone,
                    r.guardian_nome = :responsavel_nome,
                    r.guardian_data_nascimento = :responsavel_data_nascimento,
                    r.guardian_email = :responsavel_email,
                    r.guardian_telefone = :responsavel_telefone,
                    r.guardian_endereco = :responsavel_endereco
                WHERE a.id = :aluno_id";

        // Prepare a consulta SQL
        $stmt = $pdo->prepare($sql);

        // Substitua os marcadores de parâmetro pelos valores do formulário
        $stmt->bindValue(':aluno_nome', $aluno_nome);
        $stmt->bindValue(':aluno_data_nascimento', $aluno_data_nascimento);
        $stmt->bindValue(':aluno_email', $aluno_email);
        $stmt->bindValue(':aluno_telefone', $aluno_telefone);
        $stmt->bindValue(':responsavel_nome', $responsavel_nome);
        $stmt->bindValue(':responsavel_data_nascimento', $responsavel_data_nascimento);
        $stmt->bindValue(':responsavel_email', $responsavel_email);
        $stmt->bindValue(':responsavel_telefone', $responsavel_telefone);
        $stmt->bindValue(':responsavel_endereco', $responsavel_endereco);
        $stmt->bindValue(':aluno_id', $aluno_id);

        // Execute a consulta SQL
        $stmt->execute();

        // Redirecione de volta para a página "visualizar_alunos.php" após a atualização
        header("Location: visualizar_alunos.php");
        exit();
    } catch (PDOException $e) {
        // Em caso de erro, exiba uma mensagem de erro ou trate o erro de acordo com sua necessidade
        echo "Erro ao atualizar os dados do aluno: " . $e->getMessage();
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Editar Aluno</title>

    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/cabecalho.css">
    <link rel="stylesheet" href="../css/editar_aluno.css">
</head>

<body>

    <header>
        <h1>Editar Aluno</h1>
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
            <div id="form_group_up">

            <!-- Dados do Aluno -->
            <div id="register-students">
            <h2>Dados do Aluno</h2>
            <div class="form-group">
                <label for="aluno_nome">Nome do Aluno:</label>
                <input type="text" id="aluno_nome" name="aluno_nome" value="<?php echo $aluno['aluno_nome']; ?>" required>
            </div>
            <div class="form-group">
                <label for="aluno_data_nascimento">Data de Nascimento do Aluno:</label>
                <input type="date" id="aluno_data_nascimento" name="aluno_data_nascimento" value="<?php echo $aluno['aluno_data_nascimento']; ?>" required>
            </div>
            <div class="form-group">
                <label for="aluno_email">E-mail do Aluno:</label>
                <input type="email" id="aluno_email" name="aluno_email" value="<?php echo $aluno['aluno_email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="aluno_telefone">Telefone do Aluno:</label>
                <input type="text" id="aluno_telefone" name="aluno_telefone" value="<?php echo $aluno['aluno_telefone']; ?>" required>
            </div>
            </div>

            <!-- Dados do Aluno -->
            <div id="register-guardian">
            <h2>Dados do Responsável</h2>
            <div class="form-group">
                <label for="responsavel_nome">Nome do Responsável:</label>
                <input type="text" id="responsavel_nome" name="responsavel_nome" value="<?php echo $aluno['responsavel_nome']; ?>" required>
            </div>
            <div class="form-group">
                <label for="responsavel_data_nascimento">Data de Nascimento do Responsável:</label>
                <input type="date" id="responsavel_data_nascimento" name="responsavel_data_nascimento" value="<?php echo $aluno['responsavel_data_nascimento']; ?>" required>
            </div>
            <div class="form-group">
                <label for="responsavel_email">E-mail do Responsável:</label>
                <input type="email" id="responsavel_email" name="responsavel_email" value="<?php echo $aluno['responsavel_email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="responsavel_telefone">Telefone do Responsável:</label>
                <input type="text" id="responsavel_telefone" name="responsavel_telefone" value="<?php echo $aluno['responsavel_telefone']; ?>" required>
            </div>
            <div class="form-group">
                <label for="responsavel_endereco">Endereço do Responsável:</label>
                <textarea id="responsavel_endereco" name="responsavel_endereco" required><?php echo $aluno['responsavel_endereco']; ?></textarea>
            </div>
            </div>
            </div>
            </div>
            <div class="button-container">
                <button type="submit">Salvar</button>
                <a href="visualizar_alunos.php"><button type="button">Cancelar</button></a>
        </form>
    </main>
</body>

</html>
