<?php
session_start();
require_once("PHPMailerAutoload.php");
$id_feedback = $_POST['id_feedback_replica'];
$replica = $_POST['replica'];
$email = $_POST['email_replica_input'];

$mail = new PHPMailer();

$mail->CharSet = 'UTF-8';

$mail->isSMTP();

$mail->SMTPOptions = array(
  'ssl' => array(
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true
  )
);

$mail->SMTDebug = 2;

$mail->Host = "smtp.hostinger.com.br";
$mail->SMTPSecure = "tls";
$mail->Port = 587;

$mail->SMTPAuth = True;

$mail->Username = 'equipeanalisaitape@twicedev.tech';
$mail->Password = 'Analisaitape@2022';

$mail->isHtml(true);
$mail->setFrom('equipeanalisaitape@twicedev.tech', 'AnalisaItapê');
$mail->addAddress($email);
$mail->Subject = 'Réplica de Feedback - AnalisaItapê';
$mail->Body = "Agradecemos pelo seu feedback! <br><br> $replica";

if ($mail->send()) {
  $sql = "UPDATE feedbacks SET status = 1 WHERE id = $id_feedback";
  $res = mysqli_query($conn, $sql);

  if ($res) {
    header('Location: ../../../index.php#feedbacks.php');
    $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-success'>Feedback respondido com sucesso</div>";
  } else {
    header('Location: ../../../index.php#feedbacks.php');
    $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-danger'>Erro ao atualizar feedback</div>";
  }
} else {
  header('Location: ../../../index.php#feedbacks.php');
  $_SESSION['msg'] = "<div class='ml-1 mr-1 mb-0 alert alert-danger'>Erro ao responder feedback</div>";
}
