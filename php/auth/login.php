<?php
session_start();

include_once("../../conn/conexao.php");
include_once('anti_injection.php');

$login = anti_injection($_REQUEST['login']);
$password = anti_injection($_REQUEST['password']);
// $password = hash('sha256', $password);

echo $sql = "SELECT * FROM administrators WHERE login = '$login'";
$res = mysqli_query($conn, $sql);

if (mysqli_num_rows($res) > 0 && $res) {
    while ($row = mysqli_fetch_array($res)) {
        if ($row['status'] == 0) {
            header('Location: ../../');
            $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-warning'>Usuário Inativo. Contate a Equipe AnalisaItapê.</div>";
        } else if ($row['password'] == $password) {
            $administrator_id = $row['id'];
            $_SESSION['jgGn67bXK3ç'] = $row['id'];
            $_SESSION['jgGn67bXK3çPartner'] = $row['partner'];

            $_SESSION['permissionsAdm'] = array();

            $sql = "SELECT * FROM administrators_permissions WHERE administrator_id = $administrator_id";
            $res_permissions = mysqli_query($conn, $sql);

            while ($row_p = mysqli_fetch_array($res_permissions)) {
                array_push($_SESSION['permissionsAdm'], $row_p['permission_id']);
            }

            header('Location: ../../');
            $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-success'>Logado com sucesso</div>";
        } else {
            header('Location: ../../');
            $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-danger'>Senha incorreta</div>";
        }
    }
} else {
    // header('Location: ../../login.php');
    $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-danger'>Login inexistente</div>";
}
