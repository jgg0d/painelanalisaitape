<?php
session_start();
include_once("../../../conn/conexao.php");

$id = $_POST['id_administrador_edit'];
$name = $_POST['nome_edit'];
$email = $_POST['contato_edit'];
$description = $_POST['descricao_edit'];
$login = $_POST['login_edit'];

$permissoes = $_POST['permissoes_edit'];

if (!$name || !$email || !$login || !$permissoes) {
    header('Location: ../../../index.php#administradores.php');
    $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-warning'>Campos incompletos, não foi possível editar administrador</div>";
} else {
    $sql = "UPDATE administrators SET name = '$name', email = '$email', description = '$description',
        login = '$login' WHERE id = $id";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        // criar permissoes
        $sql = "DELETE FROM administrators_permissions WHERE administrator_id = $id";
        $res = mysqli_query($conn, $sql);

        for ($i = 0; $i < COUNT($permissoes); $i++) {
            $sql = "INSERT INTO administrators_permissions(administrator_id, permission_id) 
        VALUES($id, $permissoes[$i])";
            $res = mysqli_query($conn, $sql);
        }

        if ($res) {
            header('Location: ../../../index.php#administradores.php');
            $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-success'>Administrador editado com sucesso</div>";
        } else {
            header('Location: ../../../index.php#administradores.php');
            $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-danger'>Erro ao editar administrador</div>";
        }
    } else {
        header('Location: ../../../index.php#administradores.php');
        $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-danger'>Erro ao editar administrador</div>";
    }
}
