<?php
session_start();
include_once("../../../conn/conexao.php");

$name = $_POST['nome'];

if (!$name) {
    header('Location: ../../../index.php#categorias.php');
    $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-warning'>Campos incompletos, não foi possível cadastrar categoria</div>";
} else {
    $sql = "INSERT INTO categories(name) VALUES('$name')";
    $res = mysqli_query($conn, $sql);

    if ($res) {

        header('Location: ../../../index.php#categorias.php');
        $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-success'>Categoria cadastrada com sucesso</div>";
    } else {
        header('Location: ../../../index.php#categorias.php');
        $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-danger'>Erro ao cadastrar nova categoria</div>";
    }
}
