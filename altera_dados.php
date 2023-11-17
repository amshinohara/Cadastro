<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
</head>
<body>
<?php
require_once("autentica.php");
require("conecta.php");

$id = "";
if (!isset($_SESSION)) {
    session_start();
}
$id = $_SESSION['id_usuario'];

$nome = $_POST["nome"];
$senha = $_POST["senha"];
$confirmar_senha = $_POST["confirmar_senha"];

$errors = [];

function validar_nome($nome) {
    global $errors;
    if (empty($nome)) {;
        return;
    }
    if (strlen($nome) < 3 || strlen($nome) > 50) {
        $errors[] = "O campo nome deve conter entre 3 e 50 caracteres.";
        return;
    }
    else {
        echo "Nome: $nome<br>";
        return;
    }
}

function validar_senha($senha) {
    global $errors;
    if (empty($senha)) {
        return;
    }
    if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()\-_=+{};:,<.>])(?:([0-9a-zA-Z$*&@#%])(?!\1)){8,}$/', $senha)) {
        $errors[] = "O campo senha precisa ter no mínimo 8 dígitos contendo letras maiúsculas e minúsculas, números, caracteres especiais e não conter sequências.";
        return;
    }
    else {
        echo "Senha: $senha<br>";
    }
}

function confirmar_senhas($senha, $confirmar_senha) {
    global $errors;
    if (empty($senha)) {
        return;
    }
    if (empty($confirmar_senha)) {
        $errors[] = "O campo confirmação de senha não pode estar vazio.";
        return;
    } 
    if ($senha !== $confirmar_senha) {
        $errors[] = "O campo senha e confirmação de senha não conferem.";
        return;
    }
    else {
        return;
    }
}

validar_nome($nome);
validar_senha($senha);
confirmar_senhas($senha, $confirmar_senha);

if (!empty($errors)) {
    $error_menssagens = implode("<br>", $errors);
    header("Location:restrito.php?erro=1&nome=$nome&senha=$senha&confirmar_senha=$confirmar_senha&error_menssagens=$error_menssagens");
    return;
}
else {
    try {
        $stmt = $conn->prepare("SELECT * FROM `usuarios` WHERE `id` = :id");
        $stmt->bindParam("id", $id);
        $stmt->execute();

        $res = $stmt->fetchAll();

        if (count($res) > 0) {
            foreach ($res as $row) {
                $nome = $row['nome'];
                $email = $row['email'];
                $senha_atual = $row['senha'];
            }
        } else {
            header("Location:index.php");
        }

        if (isset($_POST['nome']) && !empty($_POST['nome'])) {
            $novo_nome = $_POST['nome'];
            $stmt = $conn->prepare("UPDATE `usuarios` SET `nome` = :novo_nome WHERE `id` = :id");
            $stmt->bindParam(":novo_nome", $novo_nome);
            $stmt->bindParam(":id", $id);
            if ($stmt->execute()) {
                header("Location: restrito.php?msg=Nome alterado com sucesso!");
                exit();
            }
        }

        if (isset($_POST['senha']) && !empty($_POST['senha'])) {
            $nova_senha = md5($_POST['senha']);
            $stmt = $conn->prepare("UPDATE `usuarios` SET `senha` = :nova_senha WHERE `id` = :id");
            $stmt->bindParam(":nova_senha", $nova_senha);
            $stmt->bindParam(":id", $id);
            if ($stmt->execute()) {
                header("Location: restrito.php?msg=Senha alterada com sucesso!");
                exit();
            }
        }

    } catch (PDOException $e) {
        // echo "Connection failed: " . $e->getMessage();
    }
}

$conn = null;
$stmt = null;

header("Location: restrito.php");
?>