<?php
session_start();
include_once("../../../conn/conexao.php");

$name = $_POST['nome'];
$email = $_POST['contato'];
$description = $_POST['descricao'];
$login = $_POST['login'];
$password = "4Nalisa1taP3#001";
// $password = hash('sha256', $password);

if (!$name || !$email || !$login) {
    header('Location: ../../../index.php#parceiros.php');
    $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-warning'>Campos incompletos, não foi possível cadastrar parceiro</div>";
} else {
    $sql = "INSERT INTO administrators(name, email, description, login, password, partner) 
        VALUES('$name', '$email', '$description', '$login', '$password', 1)";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        // criar permissoes
        $sql = "SELECT LAST_INSERT_ID() FROM administrators";
        $res = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($res)) {
            $administrator_id = $row[0];
        }

        $sql = "SELECT * FROM `permissions` WHERE `action` = 'artigos' OR `action` = 'projetos_sociais'";
        $res2 = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_array($res2)) {
            $permission_id = $row['id'];
            $sql = "INSERT INTO administrators_permissions (administrator_id, permission_id)
                    VALUES ($administrator_id, $permission_id)";
            $res = mysqli_query($conn, $sql);
        }

        if ($res) {
            header('Location: ../../../index.php#parceiros.php');
            $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-success'>Parceiro cadastrado com sucesso</div>";
        } else {
            header('Location: ../../../index.php#parceiros.php');
            $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-danger'>Erro ao cadastrar novo parceiro</div>";
        }
    } else {
        header('Location: ../../../index.php#parceiros.php');
        $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-danger'>Erro ao cadastrar novo parceiro</div>";
    }
}
