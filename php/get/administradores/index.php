<?php
include_once("../../../conn/conexao.php");

$id = $_GET['id'];

$sql = "SELECT * FROM administrators WHERE id = $id";
$res = mysqli_query($conn, $sql);

$sql = "SELECT * FROM administrators_permissions WHERE administrator_id = $id";
$res_permissions = mysqli_query($conn, $sql);

$permissions = array();

while ($row = mysqli_fetch_array($res_permissions)){
    array_push($permissions, $row['permission_id']);
}

$response = array();

while ($row = mysqli_fetch_array($res)) {
    array_push($response, array(
        'id' => $row['id'],
        'name' => $row['name'],
        'login' => $row['login'],
        'password' => $row['password'],
        'email' => $row['email'],
        'description' => $row['description'],
        'partner' => $row['partner'],
        'status' => $row['status'],
        'create_date' => $row['create_date'],
        'update_date' => $row['update_date'],
        'permissions' => $permissions
    ));
}

mysqli_close($conn);
echo json_encode($response);
