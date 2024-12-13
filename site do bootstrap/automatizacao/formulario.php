<?php
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Configurações do upload
    $targetDir = "uploads/";
    $fileName = basename($_FILES["curriculo"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Verifica se o arquivo tem o tipo correto
    $allowedTypes = array("pdf", "doc", "docx");
    if (in_array(strtolower($fileType), $allowedTypes)) {
        // Tenta fazer o upload do arquivo
        if (move_uploaded_file($_FILES["curriculo"]["tmp_name"], $targetFilePath)) {
            // Dados do formulário
            $nome = htmlspecialchars($_POST["nome"]);
            $email = htmlspecialchars($_POST["email"]);

            // Configurações do e-mail
            $to = "destinatario@exemplo.com"; // Substitua pelo e-mail que receberá o currículo
            $subject = "Novo currículo enviado por $nome";
            $body = "Nome: $nome\nE-mail: $email\nCurrículo: $targetFilePath";
            $headers = "From: $email";

            // Envia o e-mail
            if (mail($to, $subject, $body, $headers)) {
                echo "Currículo enviado com sucesso!";
            } else {
                echo "Erro ao enviar o e-mail.";
            }
        } else {
            echo "Erro ao fazer upload do arquivo.";
        }
    } else {
        echo "Formato de arquivo não permitido. Apenas PDF, DOC e DOCX são aceitos.";
    }
} else {
    echo "Nenhum formulário enviado.";
}
?>