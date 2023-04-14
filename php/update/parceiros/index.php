<?php
session_start();
include_once("../../../conn/conexao.php");

$id = $_POST['id_administrador_edit'];
$name = $_POST['nome_edit'];
$email = $_POST['contato_edit'];
$description = $_POST['descricao_edit'];
$login = $_POST['login_edit'];

if (!$name || !$email || !$login) {
    header('Location: ../../../index.php#parceiros.php');
    $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-warning'>Campos incompletos, não foi possível editar parceiro</div>";
} else {
    $sql = "UPDATE administrators SET name = '$name', email = '$email', description = '$description',
        login = '$login' WHERE id = $id";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        header('Location: ../../../index.php#parceiros.php');
        $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-success'>Parceiro editado com sucesso</div>";
    } else {
        header('Location: ../../../index.php#parceiros.php');
        $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-danger'>Erro ao editar parceiro</div>";
    }
}
