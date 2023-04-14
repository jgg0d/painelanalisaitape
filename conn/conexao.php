<?php
$host = "localhost";
$user = "root";
$password = "";
// $db = "analisaitape";
$db = "u995521796_analisaitape";

try {
    $conn = mysqli_connect($host, $user, $password, $db);
} catch (Exception $e) {
    echo "Erro ao conectar no banco";
    // exit(header('Location: ../404.php'));
}
