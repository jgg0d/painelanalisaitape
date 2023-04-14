<?php
session_start();
include_once("../../../conn/conexao.php");

$id = $_POST['id_categoria_edit'];
$name = $_POST['nome_edit'];

if (!$name) {
    header('Location: ../../../index.php#categorias.php');
    $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-warning'>Campos incompletos, não foi possível editar categoria</div>";
} else {
    $sql = "UPDATE categories SET name = '$name' WHERE id = $id";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        header('Location: ../../../index.php#categorias.php');
        $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-success'>Categoria editada com sucesso</div>";
    } else {
        header('Location: ../../../index.php#categorias.php');
        $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-danger'>Erro ao editar categoria</div>";
    }
}
