<?php
session_start();
include_once("../../../conn/conexao.php");

$id = $_POST['id_feedback_status'];
$status = $_POST['status_feedback'];

if ($status == 1) {
    $saida = "aprova";
} else if ($status == 2) {
    $saida = "reprova";
}

$sql = "UPDATE feedbacks SET status = $status WHERE id = $id";
$res = mysqli_query($conn, $sql);

if ($res) {
    header('Location: ../../../index.php#feedbacks.php');
    $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-success'>Feedback $saida" . "do " . "com sucesso</div>";
} else {
    header('Location: ../../../index.php#feedbacks.php');
    $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-danger'>Erro ao $saida" . "r" . " categoria</div>";
}
