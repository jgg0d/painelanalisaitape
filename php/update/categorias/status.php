<?php
session_start();
include_once("../../../conn/conexao.php");

$id = $_POST['id_categoria_status'];
$status = $_POST['status_categoria'];

$sql = "UPDATE categories SET status = $status WHERE id = $id";
$res = mysqli_query($conn, $sql);

if ($res) {
    header('Location: ../../../index.php#categorias.php');
    $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-success'>Categoria editada com sucesso</div>";
} else {
    header('Location: ../../../index.php#categorias.php');
    $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-danger'>Erro ao editar categoria</div>";
}
