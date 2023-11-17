<?php
require_once("conecta.php");

$email = $_POST["email"];
$senha = $_POST["senha"];
$senha_hash = md5($senha);


try {

    $stmt = $conn->prepare("SELECT * FROM `usuarios` WHERE `email` = :email AND `senha` = :senha");
    $stmt->bindParam("email",$email);
    $stmt->bindParam("senha",$senha_hash);
    $stmt->execute();

    $res = $stmt->fetchAll();
    
    if(count($res) > 0) {   
        foreach ($res as $row) {
            $id = $row['id'];
        }
            if(!isset($_SESSION))
                session_start();
            $_SESSION['id_usuario'] = $id;

            if (isset($_POST['lembrar']) && $_POST['lembrar'] == 'on') {
                setcookie('email', $email, time() + (86400 * 30), "/");
            } 
            else {
                setcookie('email', '', time() - 3600, "/");
            }

            header("Location:restrito.php");

  }
  else {
      header("Location:index.php?msg=Falha no Login");
  }

} catch(PDOException $e) {
    $e->getMessage();
}

$conn = null;
$stmt = null;

?>
