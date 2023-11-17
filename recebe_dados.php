<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }
    </style>
</head>
<body>
<?php
require_once("conecta.php");

$nome = $_POST["nome"];
$email = $_POST["email"];
$senha = $_POST["senha"];
$confirmar_senha = $_POST["confirmar_senha"];

function obter_emails_usuarios($conn) {
    try {
        $stmt = $conn->prepare("SELECT email FROM usuarios");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    } catch (PDOException $e) {
        // echo "Connection failed: " . $e->getMessage();
        return [];
    }
}

$usuarios_email = obter_emails_usuarios($conn);

$errors = [];

/*Função para validação do Nome*/
function validar_nome($nome) {
    global $errors;
    if (empty($nome)) {
        $errors[] = "O campo nome não pode estar vazio.";
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

/* Função para validação do E-mail */
function validar_email($email, $usuarios_email) {
    global $errors;
    if (empty($email)) {
        $errors[] = "O campo e-mail não pode estar vazio.";
        return;
    }
    if (in_array($email, $usuarios_email)) {    
        $errors[] = "O e-mail informado já está cadastrado no sistema.";
        return;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "O e-mail informado não contém um formato válido.";
        return;
    }
    else {
        echo "E-mail: $email<br>";
        return;
    }
}

/*Função para validação da Senha*/
function validar_senha($senha) {
    global $errors;
    if (empty($senha)) {
        $errors[] = "O campo senha não pode estar vazio.";
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

/*Função para validação da Confirmação da Senha*/
function confirmar_senhas($senha, $confirmar_senha) {
    global $errors;
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

echo '<p style="color:Green; background:PaleGreen;">';
echo "<strong>Os dados abaixo foram recebidos com sucesso!</strong><br><br>";

validar_nome($nome);
validar_email($email, $usuarios_email);
validar_senha($senha);
confirmar_senhas($senha, $confirmar_senha);
echo '</p>';

if (!empty($errors)) {
    $error_menssagens = implode("<br>", $errors);
    header("Location:form.php?erro=1&nome=$nome&email=$email&senha=$senha&confirmar_senha=$confirmar_senha&error_menssagens=$error_menssagens");
    return;
}
else {
    $senha_hash = md5($senha);
    try {

        $stmt = $conn->prepare("INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`) VALUES (NULL, :nome, :email, :senha);");
        $stmt->bindParam("nome",$nome);
        $stmt->bindParam("email",$email);
        $stmt->bindParam("senha",$senha_hash);
        
        if($stmt->execute()){
            header("Location:index.php?msg=Usuario cadastrado com sucesso!");
        }
        else{
           header("Location:index.php?msg=Erro na inclusão do usuário!");
        }


    } catch(PDOException $e) {
        $e->getMessage();
    }
}

$conn = null;
$stmt = null;
?>