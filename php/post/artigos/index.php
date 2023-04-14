<?php
session_start();
include_once("../../../conn/conexao.php");

$partner_id = $_SESSION['jgGn67bXK3ç'];
$category_id = $_POST['categoria'];
$title = $_POST['titulo'];
$description = $_POST['descricao'];
$text = $_POST['texto'];

if ($_FILES['imagem']['tmp_name'] != "") {
    $img = $_FILES['imagem']['tmp_name'];
    $img = file_get_contents($img);
    $img = base64_encode($img);
} else {
    $img = "";
}

if (!$partner_id || !$category_id || !$title || !$description || !$text) {
    header('Location: ../../../index.php#artigos.php');
    $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-warning'>Campos incompletos, não foi possível cadastrar artigo</div>";
} else {
    $sql = "INSERT INTO articles(partner_id, category_id, title, description, img, text) 
        VALUES($partner_id, $category_id, '$title', '$description', '$img', '$text')";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        header('Location: ../../../index.php#artigos.php');
        $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-success'>Artigo cadastrado com sucesso</div>";
    } else {
        header('Location: ../../../index.php#artigos.php');
        $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-danger'>Erro ao cadastrar novo artigo</div>";
    }
}
