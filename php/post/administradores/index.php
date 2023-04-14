<?php
session_start();
include_once("../../../conn/conexao.php");

$name = $_POST['nome'];
$email = $_POST['contato'];
$description = $_POST['descricao'];
$login = $_POST['login'];
$password = "4Nalisa1taP3#001";
// $password = hash('sha256', $password);
$permissoes = $_POST['permissoes'];

if (!$name || !$email || !$login || !$permissoes) {
    header('Location: ../../../index.php#administradores.php');
    $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-warning'>Campos incompletos, não foi possível cadastrar administrador</div>";
} else {
    $sql = "INSERT INTO administrators(name, email, description, login, password) 
        VALUES('$name', '$email', '$description', '$login', '$password')";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        // criar permissoes
        $sql = "SELECT LAST_INSERT_ID() FROM administrators";
        $res = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($res)) {
            $administrator_id = $row[0];
        }

        for ($i = 0; $i < COUNT($permissoes); $i++) {
            $sql = "INSERT INTO administrators_permissions(administrator_id, permission_id) 
        VALUES($administrator_id, $permissoes[$i])";
            $res = mysqli_query($conn, $sql);
        }

        if ($res) {
            header('Location: ../../../index.php#administradores.php');
            $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-success'>Administrador cadastrado com sucesso</div>";
        } else {
            header('Location: ../../../index.php#administradores.php');
            $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-danger'>Erro ao cadastrar novo administrador</div>";
        }
    } else {
        header('Location: ../../../index.php#administradores.php');
        $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-danger'>Erro ao cadastrar novo administrador</div>";
    }
}
