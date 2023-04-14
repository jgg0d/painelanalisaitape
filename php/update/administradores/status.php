<?php
session_start();
include_once("../../../conn/conexao.php");

$id = $_POST['id_administrador_status'];
$status = $_POST['status_administrador'];

$sql = "UPDATE administrators SET status = $status WHERE id = $id";
$res = mysqli_query($conn, $sql);

if ($res) {
    header('Location: ../../../index.php#administradores.php');
    $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-success'>Administrador editado com sucesso</div>";
} else {
    header('Location: ../../../index.php#administradores.php');
    $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-danger'>Erro ao editar administrador</div>";
}
