<?php
// Inclua o arquivo de conexão com o banco de dados
require_once "../config/db_conexao.php";

try {
  // Crie a instrução SQL para selecionar os dados dos alunos
  $sql = "SELECT id, students_nome AS nome FROM alunos";

  // Execute a consulta SQL
  $stmt = $pdo->query($sql);

  // Obtém todos os registros como um array associativo
  $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  // Em caso de erro, exiba uma mensagem de erro ou trate o erro de acordo com sua necessidade
  echo "Erro ao recuperar os dados: " . $e->getMessage();
  exit();
}

// Define o fuso horário
date_default_timezone_set('America/Maceio');

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Presença dos Alunos</title>

  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/cabecalho.css">
  <link rel="stylesheet" href="../css/frequencia_alunos.css">
  <link rel="stylesheet" href="../css/tables.css">
</head>

<body>
  <header>
    <h1>Cadastrar Frequência</h1>
    <nav class="button-container">
      <a href="cadastro_alunos.php">
        <button type="button">Cadastro</button>
      </a>
      <a href="visualizar_alunos.php">
        <button type="button">Alunos</button>
      </a>
      <a href="frequencia_alunos.php">
        <button type="button" class="active">Frequência</button>
      </a>
      <a href="relatorio_frequencia.php">
        <button type="button">Relatório</button>
      </a>
    </nav>
  </header>

  <main>
    <form action="../php/salvar_frequencia.php" method="POST">
      <table>
        <tr>
          <th>Aluno</th>
          <th>Data</th>
          <th>Hora</th>
          <th>Presença</th>
          <th>Falta</th>
        </tr>
        <?php foreach ($alunos as $aluno) : ?>
          <tr>
            <td><?= $aluno["nome"]; ?></td>
            <td><?= date("Y/m/d"); ?></td> <!-- Obtém a data atual -->
            <td><?= date("H:i:s"); ?></td> <!-- Obtém a hora atual -->
            <td><input type="radio" name="presenca[<?= $aluno["id"]; ?>]" value="presenca"></td>
            <td><input type="radio" name="presenca[<?= $aluno["id"]; ?>]" value="falta"></td>
          </tr>
        <?php endforeach; ?>
      </table>
      <input type="submit" value="Salvar Presença">
    </form>
  </main>
</body>

</html>