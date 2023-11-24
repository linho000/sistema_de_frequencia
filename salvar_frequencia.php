<?php
// Inclua o arquivo de conexão com o banco de dados
require_once "../config/db_conexao.php";

// Define o fuso horário
date_default_timezone_set('America/Maceio');

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Obtém os dados de presença/falta do formulário
    $presenca = $_POST["presenca"];

    try {
        // Inicia a transação
        $pdo->beginTransaction();

        // Cria um array para armazenar os parâmetros da inserção
        $parametros = [];

        // Percorre os dados de presença/falta
        foreach ($presenca as $alunoId => $status) {
            // Verifica o valor do status selecionado
            if ($status === "presenca") {
                $presencaValue = 1; // Presença selecionada
            } elseif ($status === "falta") {
                $presencaValue = 0; // Falta selecionada
            } else {
                continue; // Ignora valores inválidos
            }

            // Obtém a data e hora atual
            $dataAtual = date("Y-m-d");
            $horaAtual = date("H:i:s");

            // Adiciona os parâmetros ao array
            $parametros[] = [
                "alunoId" => $alunoId,
                "data" => $dataAtual,
                "hora" => $horaAtual,
                "presenca" => $presencaValue
            ];
        }

        // Cria a instrução SQL para inserir os dados de presença/falta no banco de dados
        $sql = "INSERT INTO frequencias (aluno_id, data, hora, presenca) VALUES (:alunoId, :data, :hora, :presenca)";

        // Prepare a declaração SQL
        $stmt = $pdo->prepare($sql);

        // Executa a declaração SQL várias vezes com diferentes conjuntos de valores
        foreach ($parametros as $parametro) {
            $stmt->execute($parametro);
        }

        // Confirma a transação
        $pdo->commit();

        // Redireciona para a página relatorio_frequencia.php
        header("Location: ../views/relatorio_frequencia.php");
        exit();

    } catch (PDOException $e) {
        // Em caso de erro, desfaz a transação
        $pdo->rollBack();

        // Exiba uma mensagem de erro ou trate o erro de acordo com sua necessidade
        echo "Erro ao salvar os dados de presença/falta: " . $e->getMessage();
    }
} else {
    echo "O formulário não foi enviado.";
}
?>
