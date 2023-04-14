<?php
session_start();
include_once("../../conn/conexao.php");

unset($_SESSION['jgGn67bXK3ç']);
unset($_SESSION['permissionsAdm']);
// session_destroy();

exit(header('Location: ../../login.php'));
