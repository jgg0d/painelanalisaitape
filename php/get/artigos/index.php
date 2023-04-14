<?php
include_once("../../../conn/conexao.php");

$id = $_GET['id'];

$sql = "SELECT * FROM articles WHERE id = $id";
$res = mysqli_query($conn, $sql);

$response = array();

while ($row = mysqli_fetch_array($res)) {
    array_push($response, array(
        'id' => $row['id'],
        'partner_id' => $row['partner_id'],
        'category_id' => $row['category_id'],
        'title' => $row['title'],
        'description' => $row['description'],
        'img' => $row['img'],
        'text' => $row['text'],
        'status' => $row['status'],
        'create_date' => $row['create_date'],
        'update_date' => $row['update_date']
    ));
}

mysqli_close($conn);
echo json_encode($response);
