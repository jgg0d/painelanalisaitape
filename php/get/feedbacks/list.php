<?php
include_once("../../../conn/conexao.php");

$limit = $_GET['limit'];
$offset = $_GET['offset'];

$sql = "SELECT * FROM feedbacks WHERE status = 0 LIMIT $limit OFFSET $offset";
$res_feedbacks = mysqli_query($conn, $sql);

foreach ($res_feedbacks as $row) { ?>
    <li>
        <h4><?= $row['title'] != "" ? $row['title'] : "Sem título" ?></h4>
        <p><?= date('d/m/Y', strtotime($row['create_date'])) ?></p>
        <p><?= $row['feedback'] ?></p>
        <p class="inline-popups"><a data-toggle="modal" data-target="#exampleModal" class="btn_1 gray"><i class="fa fa-fw fa-reply"></i> Réplica do Feedback</a></p>
        <ul class="buttons">
            <li><a class="btn_1 gray approve"><i class="fa fa-fw fa-check-circle-o"></i>Encerrar</a></li>
            <li><a class="btn_1 gray delete"><i class="fa fa-fw fa-check-circle-o"></i>Cancelar</a></li>
        </ul>
    </li>
<?php } ?>