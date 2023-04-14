<?php
include_once("../../../conn/conexao.php");

$id = $_GET['id'];

$sql = "SELECT * FROM feedbacks WHERE id = $id";
$res = mysqli_query($conn, $sql);

$response = array();

while ($row = mysqli_fetch_array($res)) {
    array_push($response, array(
        'id' => $row['id'],
        'email' => $row['email'],
        'title' => $row['title'],
        'feedback' => $row['feedback'],
        'reply' => $row['reply'],
        'status' => $row['status'],
        'create_date' => $row['create_date'],
        'update_date' => $row['update_date']
    ));
}

mysqli_close($conn);
echo json_encode($response);
