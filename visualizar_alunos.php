<?php
// Inclua o arquivo de conexão com o banco de dados
require_once "../config/db_conexao.php";

// Função para redirecionar para a página de edição
function redirectEditarAluno($aluno_id)
{
    header("Location: editar_aluno.php?aluno_id=$aluno_id");
    exit();
}

// Função para redirecionar para a página de exclusão
function redirectExcluirAluno($aluno_id)
{
    // Implemente a lógica para excluir o aluno do banco de dados aqui
    // Depois de excluir o aluno, redirecione para a página "visualizar_alunos.php"
    header("Location: excluir_aluno.php");
    exit();
}

try {
    // Verifique se foi enviada uma busca pelo nome
    if (isset($_GET['nome'])) {
        // Recupere o valor da busca pelo nome
        $nome = $_GET['nome'];

        // Crie a instrução SQL para selecionar os dados dos alunos e seus responsáveis, filtrando pelo nome
        $sql = "SELECT a.id AS aluno_id, a.students_nome AS aluno_nome, a.students_data_nascimento AS aluno_data_nascimento, a.students_email AS aluno_email, a.students_telefone AS aluno_telefone,
                r.guardian_nome AS responsavel_nome, r.guardian_data_nascimento AS responsavel_data_nascimento, r.guardian_email AS responsavel_email,
                r.guardian_telefone AS responsavel_telefone, r.guardian_endereco AS responsavel_endereco
                FROM alunos a
                INNER JOIN responsaveis r ON a.id = r.aluno_id
                WHERE a.students_nome LIKE :nome";

        // Prepare a consulta SQL
        $stmt = $pdo->prepare($sql);

        // Substitua o marcador de parâmetro pelo valor da busca pelo nome
        $stmt->bindValue(':nome', '%' . $nome . '%');

        // Execute a consulta SQL
        $stmt->execute();

        // Obtém todos os registros como um array associativo
        $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Se não houver busca pelo nome, execute a consulta SQL sem filtros
        $sql = "SELECT a.id AS aluno_id, a.students_nome AS aluno_nome, a.students_data_nascimento AS aluno_data_nascimento, a.students_email AS aluno_email, a.students_telefone AS aluno_telefone,
                r.guardian_nome AS responsavel_nome, r.guardian_data_nascimento AS responsavel_data_nascimento, r.guardian_email AS responsavel_email,
                r.guardian_telefone AS responsavel_telefone, r.guardian_endereco AS responsavel_endereco
                FROM alunos a
                INNER JOIN responsaveis r ON a.id = r.aluno_id";

        // Execute a consulta SQL
        $stmt = $pdo->query($sql);

        // Obtém todos os registros como um array associativo
        $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    // Em caso de erro, exiba uma mensagem de erro ou trate o erro de acordo com sua necessidade
    echo "Erro ao recuperar os dados: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Visualizar Alunos</title>

    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/cabecalho.css">
    <link rel="stylesheet" href="../css/tables.css">
    <link rel="stylesheet" href="../css/visualizar_alunoss.css">
</head>

<body>
    <header>
        <h1>Alunos Cadastrados</h1>
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
        <form method="GET" action="">
            <input id="input-search" type="text" name="nome" placeholder="Digite o nome do aluno">
            <input id="button-search" type="submit" value="Buscar">
        </form>
    </header>

    <main>
        <table>
            <tr>
                <th>Aluno</th>
                <th>Data de Nascimento</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Responsável</th>
                <th>Data de Nascimento</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Endereço</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($alunos as $aluno) : ?>
                <tr>
                    <td><?php echo $aluno["aluno_nome"]; ?></td>
                    <td><?php echo $aluno["aluno_data_nascimento"]; ?></td>
                    <td><?php echo $aluno["aluno_email"]; ?></td>
                    <td><?php echo $aluno["aluno_telefone"]; ?></td>
                    <td><?php echo $aluno["responsavel_nome"]; ?></td>
                    <td><?php echo $aluno["responsavel_data_nascimento"]; ?></td>
                    <td><?php echo $aluno["responsavel_email"]; ?></td>
                    <td><?php echo $aluno["responsavel_telefone"]; ?></td>
                    <td><?php echo $aluno["responsavel_endereco"]; ?></td>
                    <td>
                        <a class="btn" href="editar_aluno.php?aluno_id=<?php echo $aluno['aluno_id']; ?>">Editar</a>
                        <a class="btn" href="excluir_aluno.php?aluno_id=<?php echo $aluno['aluno_id']; ?>">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>
</body>

</html>