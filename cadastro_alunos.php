<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Alunos</title>

  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/cabecalho.css">
  <link rel="stylesheet" href="../css/cadastro_alunoss.css">

</head>

<body>
  <header>
    <h1>Cadastro</h1>
    <nav class="button-container">
      <a href="cadastro_alunos.php">
        <button type="button" class="active">Cadastro</button>
      </a>
      <a href="visualizar_alunos.php">
        <button type="button">Alunos</button>
      </a>
      <a href="frequencia_alunos.php">
        <button type="button">Frequência</button>
      </a>
      <a href="relatorio_frequencia.php">
        <button type="button">Relatório</button>
      </a>
    </nav>
  </header>
  
  <?php
    if (isset($_GET['error'])) {
      $errorMessage = $_GET['error'];
      echo '<p class="error-message">' . $errorMessage . '</p>';
    }
    ?>

  <main class="container">
    <form action="../php/insert.php" method="POST">

      <div id="register-students">
        <!-- Dados do Aluno -->
        <h2>Dados do Aluno</h2>

        <div class="form-group">
          <label for="students-nome">Nome:</label>
          <input type="text" id="students-nome" name="students-nome" required value="Claudio Bruno">
        </div>

        <div class="form-group">
          <label for="students-data_nascimento">Data de Nascimento:</label>
          <input type="date" id="students-data_nascimento" name="students-data_nascimento" required value="02/08/1995">
        </div>

        <div class="form-group">
          <label for="students-email">E-mail:</label>
          <input type="email" id="students-email" name="students-email" required value="Claudio.Bruno095@gmail.com">
        </div>

        <div class="form-group">
          <label for="students-telefone">Telefone:</label>
          <input type="tel" id="students-telefone" name="students-telefone" required value="(82) 98139-6997">
        </div>
      </div>
      
      <!-- Dados do Responsável -->
      <div id="register-guardian">
        <h2>Dados do Responsável</h2>
        <div class="form-group">
          <label for="guardian-nome">Nome:</label>
          <input type="text" id="guardian-nome" name="guardian-nome" required value="Maria Lúcia da Silva">
        </div>

        <div class="form-group">
          <label for="guardian-data_nascimento">Data de Nascimento:</label>
          <input type="date" id="guardian-data_nascimento" name="guardian-data_nascimento" required value="02/08/1995">
        </div>

        <div class="form-group">
          <label for="guardian-email">E-mail:</label>
          <input type="email" id="guardian-email" name="guardian-email" required value="Claudio.Bruno-@outlook.com">
        </div>

        <div class="form-group">
          <label for="guardian-telefone">Telefone:</label>
          <input type="tel" id="guardian-telefone" name="guardian-telefone" required value="(82) 98139-6997">
        </div>

        <div class="form-group">
          <label for="guardian-endereco">Endereço:</label>
          <input type="text" id="guardian-endereco" name="guardian-endereco" required value="Rua Orlando Gomes de Barros, Nº247 - Roberto Correia de Araújo">
        </div>

        <div class="form-group">
          <input type="submit" value="Cadastrar">
        </div>
      </div>
    </form>
  </main>
</body>

</html>