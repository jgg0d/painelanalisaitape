<?php
session_start();
include_once('../../conn/conexao.php');

$status = isset($_GET['status']) ? $_GET['status'] : "";

$where = "";

if ($status != "") {
    $where .= "WHERE status = $status";
}

$sql = "SELECT * FROM feedbacks $where LIMIT 5";
$res_feedbacks = mysqli_query($conn, $sql);
$count_feedbacks = mysqli_num_rows($res_feedbacks);

if ($count_feedbacks > 0) {
    foreach ($res_feedbacks as $row) {
        $disabled = !$row['email'] || $row['email'] == "" ? "disabled" : "";
        if ($row['status'] == 1) {
            $tag = "<i class='approved'>Encerrado</i>";
        }else if($row['status'] == 2){
            $tag = "<i class='cancel'>Cancelado</i>";
        }else{
            $tag = "";
        }
?>
        <li>
            <h4><?= $row['title'] != "" ? $row['title'] : "Sem título" ?> <?= $tag ?></h4>
            <p><?= date('d/m/Y', strtotime($row['create_date'])) ?></p>
            <p><?= $row['feedback'] ?></p>
            <p class="inline-popups">
                <button <?= $disabled ?> type="button" onclick="replicar_feedback(<?= $row['id'] ?>)" class="btn_1 gray <?= $disabled ?>">
                    <i class="fa fa-fw fa-reply"></i> Réplica do Feedback
                </button>
            </p>
            <ul class="buttons">
                <li><a onclick="alterar_status(<?= $row['id'] ?>, 1)" class="btn_1 gray approve"><i class="fa fa-fw fa-check-circle-o"></i>Encerrar</a></li>
                <li><a onclick="alterar_status(<?= $row['id'] ?>, 2)" class="btn_1 gray delete"><i class="fa fa-fw fa-times-circle-o"></i>Cancelar</a></li>
            </ul>
        </li>
    <?php }
} else { ?>
    <li>
        <h4>Não há feedbacks</h4>
        <p>Nada para exibir aqui.</p>
    </li>
<?php } ?>