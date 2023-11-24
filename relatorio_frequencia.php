<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registros de Frequência</title>

    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/cabecalho.css">
    <link rel="stylesheet" href="../css/relatorio_frequencia.css">
    <link rel="stylesheet" href="../css/tables.css">
</head>
<body>
<header>
    <h1>Registros de Frequência</h1>
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

    <form action="" method="GET">
        <label for="data_inicio">Data Início:</label>
        <input type="date" id="data_inicio" name="data_inicio">

        <label for="data_fim">Data Fim:</label>
        <input type="date" id="data_fim" name="data_fim">

        <input class="btn" type="submit" value="Filtrar">
        <a href="relatorio_frequencia.php" class="btn">Remover Filtro</a>
    </form>

    <?php
    // Verifica se o formulário foi submetido
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        // Obtém as datas de início e fim do formulário
        $dataInicio = $_GET["data_inicio"] ?? null;
        $dataFim = $_GET["data_fim"] ?? null;

        // Inclua o arquivo de conexão com o banco de dados
        require_once "../config/db_conexao.php";

        // Crie a consulta SQL para obter os registros de frequência filtrados por período
        $sql = "SELECT alunos.students_nome AS aluno_nome, frequencias.data, frequencias.hora, frequencias.presenca, frequencias.id 
                FROM frequencias 
                INNER JOIN alunos ON alunos.id = frequencias.aluno_id";

        // Verifica se as datas de início e fim foram fornecidas
        if ($dataInicio && $dataFim) {
            // Adiciona a cláusula WHERE para filtrar por período
            $sql .= " WHERE frequencias.data >= :dataInicio AND frequencias.data <= :dataFim";
        }

        // Prepare a declaração SQL
        $stmt = $pdo->prepare($sql);

        // Verifica se as datas de início e fim foram fornecidas e executa a declaração SQL com os valores dos parâmetros
        if ($dataInicio && $dataFim) {
            $stmt->execute([
                ":dataInicio" => $dataInicio,
                ":dataFim" => $dataFim
            ]);
        } else {
            $stmt->execute();
        }

        // Verifica se há registros retornados
        if ($stmt->rowCount() > 0) {
            // Exiba a tabela de registros de frequência
            echo "<div style='overflow-x:auto;'>";
            echo "<table>";
            echo "<tr><th>Aluno</th><th>Data</th><th>Hora</th><th>Presença</th><th colspan='2' style ='text-align: center';>Ações</th></tr>";            

            // Percorre os registros e exibe cada linha da tabela
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td >" . $row["aluno_nome"] . "</td>";
                echo "<td>" . $row["data"] . "</td>";
                echo "<td>" . $row["hora"] . "</td>";
                echo "<td>" . ($row["presenca"] ? "Presente" : "Ausente") . "</td>";
                echo "<td style ='text-align: center';>";
                echo "<a href='editar_registro.php?id=" . $row["id"] . "' class='btn'>Editar</a>";
                echo "<a href='apagar_registro.php?id=" . $row["id"] . "' class='btn'>Apagar</a>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "</div>";
        } else {
            echo "Nenhum registro encontrado.";
        }
    }
    ?>

</body>
</html>
