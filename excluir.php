<?php
require_once("autentica.php");
require("conecta.php");

if(isset($_GET["error_menssagens"])){
    $error_menssagens= $_GET["error_menssagens"];
}
else{
    $error_menssagens = "";
}

$id = "";
if(!isset($_SESSION))
    session_start();
$id = $_SESSION['id_usuario'];

try {
    $stmt = $conn->prepare("SELECT * FROM `usuarios` WHERE `id` = :id");
    $stmt->bindParam("id",$id);
    $stmt->execute();

    $res = $stmt->fetchAll();

    if (count($res) > 0) {
        $stmt = $conn->prepare("DELETE FROM `usuarios` WHERE `id` = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        session_destroy();

        header("Location: index.php");

    }
} catch (PDOException $e) {
    // echo "Connection failed: " . $e->getMessage();
}

$conn = null;
$stmt = null;
?>