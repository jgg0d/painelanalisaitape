<?php
session_start();
include_once("../../../conn/conexao.php");

$id = $_POST['id_artigo_edit'];
$partner_id = $_SESSION['jgGn67bXK3ç'];
$category_id = $_POST['categoria_edit'];
$title = $_POST['titulo_edit'];
$description = $_POST['descricao_edit'];
$text = $_POST['texto_edit'];

if ($_FILES['imagem_edit']['tmp_name'] != "") {
    $img = $_FILES['imagem_edit']['tmp_name'];
    $img = file_get_contents($img);
    $img = base64_encode($img);
} else {
    $sql = "SELECT img FROM articles WHERE id = $id";
    $res = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($res)) {
        $img = $row[0];
    }
}

if (!$partner_id || !$category_id || !$title || !$description || !$text) {
    header('Location: ../../../index.php#artigos.php');
    $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-warning'>Campos incompletos, não foi possível editar artigo</div>";
} else {
    $sql = "UPDATE articles SET partner_id = $partner_id, category_id = $category_id, title = '$title', description = '$description',
    img = '$img', text = '$text' WHERE id = $id";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        header('Location: ../../../index.php#artigos.php');
        $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-success'>Artigo editado com sucesso</div>";
    } else {
        header('Location: ../../../index.php#artigos.php');
        $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-danger'>Erro ao editar artigo</div>";
    }
}
