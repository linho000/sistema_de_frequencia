<?php
require_once "../config/db_conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $studentNome = filter_input(INPUT_POST, "students-nome", FILTER_SANITIZE_STRING);
    $studentDataNascimento = filter_input(INPUT_POST, "students-data_nascimento", FILTER_SANITIZE_STRING);
    $studentEmail = filter_input(INPUT_POST, "students-email", FILTER_SANITIZE_EMAIL);
    $studentTelefone = filter_input(INPUT_POST, "students-telefone", FILTER_SANITIZE_STRING);

    $guardianNome = filter_input(INPUT_POST, "guardian-nome", FILTER_SANITIZE_STRING);
    $guardianDataNascimento = filter_input(INPUT_POST, "guardian-data_nascimento", FILTER_SANITIZE_STRING);
    $guardianEmail = filter_input(INPUT_POST, "guardian-email", FILTER_SANITIZE_EMAIL);
    $guardianTelefone = filter_input(INPUT_POST, "guardian-telefone", FILTER_SANITIZE_STRING);
    $guardianEndereco = filter_input(INPUT_POST, "guardian-endereco", FILTER_SANITIZE_STRING);

    try {
        if (empty($studentNome) || empty($studentDataNascimento) || empty($guardianNome) || empty($guardianDataNascimento)) {
            echo "Por favor, preencha todos os campos obrigatórios.";
            header("Location: ../views/cadastro_alunos.php?error=" . urlencode($errorMessage));
            exit();
        }

        if (!filter_var($studentEmail, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "O e-mail do aluno é inválido.";
            header("Location: ../views/cadastro_alunos.php?error=" . urlencode($errorMessage));
            exit();
        }
        
        if (!filter_var($guardianEmail, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "O e-mail do responsável é inválido.";
            header("Location: ../views/cadastro_alunos.php?error=" . urlencode($errorMessage));
            exit();
        }
        

        $pdo->beginTransaction();

        $sqlAluno = "INSERT INTO alunos (students_nome, students_data_nascimento, students_email, students_telefone)
                VALUES (:students_nome, :students_data_nascimento, :students_email, :students_telefone)";
        $stmtAluno = $pdo->prepare($sqlAluno);
        $stmtAluno->bindParam(":students_nome", $studentNome);
        $stmtAluno->bindParam(":students_data_nascimento", $studentDataNascimento);
        $stmtAluno->bindParam(":students_email", $studentEmail);
        $stmtAluno->bindParam(":students_telefone", $studentTelefone);
        $stmtAluno->execute();
        $alunoId = $pdo->lastInsertId();

        $sqlResponsavel = "INSERT INTO responsaveis (guardian_nome, guardian_data_nascimento, guardian_email, guardian_telefone, guardian_endereco, aluno_id)
                VALUES (:guardian_nome, :guardian_data_nascimento, :guardian_email, :guardian_telefone, :guardian_endereco, :aluno_id)";
        $stmtResponsavel = $pdo->prepare($sqlResponsavel);
        $stmtResponsavel->bindParam(":guardian_nome", $guardianNome);
        $stmtResponsavel->bindParam(":guardian_data_nascimento", $guardianDataNascimento);
        $stmtResponsavel->bindParam(":guardian_email", $guardianEmail);
        $stmtResponsavel->bindParam(":guardian_telefone", $guardianTelefone);
        $stmtResponsavel->bindParam(":guardian_endereco", $guardianEndereco);
        $stmtResponsavel->bindParam(":aluno_id", $alunoId);
        $stmtResponsavel->execute();

        $pdo->commit();

        header("Location: ../views/visualizar_alunos.php");
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Erro no cadastro: " . $e->getMessage();
    }
}
?>