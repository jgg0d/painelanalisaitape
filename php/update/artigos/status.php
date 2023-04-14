<?php
session_start();
include_once("../../../conn/conexao.php");

$id = $_POST['id_artigo_status'];
$status = $_POST['status_artigo'];

$sql = "UPDATE articles SET status = $status WHERE id = $id";
$res = mysqli_query($conn, $sql);

if ($res) {
    header('Location: ../../../index.php#artigos.php');
    $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-success'>Artigo editado com sucesso</div>";
} else {
    header('Location: ../../../index.php#artigos.php');
    $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-danger'>Erro ao editar artigo</div>";
}
