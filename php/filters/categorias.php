<?php
session_start();
include_once('../../conn/conexao.php');

$status = isset($_GET['status']) ? $_GET['status'] : "";

$where = "";

if ($status != "") {
    $where .= "WHERE status = $status";
}

$sql = "SELECT 
            * 
        FROM categories 
        $where";
$res_categories = mysqli_query($conn, $sql);
?>

<table class="table table-hover c-pointer" id="dataTable" width="100%" cellspacing="0">
    <thead data-toggle="tooltip" data-placement="top" title="Clique 2x para editar">
        <tr>
            <th>Nome</th>
            <th>Cadastro</th>
            <th>Atualização</th>
            <th>Status</th>
        </tr>
    </thead>
    <tfoot data-toggle="tooltip" data-placement="bottom" title="Clique 2x para editar">
        <tr>
            <th>Nome</th>
            <th>Cadastro</th>
            <th>Atualização</th>
            <th>Status</th>
        </tr>
    </tfoot>
    <tbody>
        <?php foreach ($res_categories as $row) {
            $color = $row['status'] == 0 ? "danger" : "success";
            $status = $row['status'] == 0 ? "Inativa" : "Ativa";
            $status_alterar = $row['status'] == 0 ? 1 : 0;
            $data_update = $row['update_date'] ? date('d/m/Y', strtotime($row['update_date'])) : "Nunca";
        ?>
            <tr ondblclick="editar_categoria(<?= $row['id'] ?>)">
                <td><?= $row['name'] ?></td>
                <td><?= date('d/m/Y', strtotime($row['create_date'])) ?></td>
                <td><?= $data_update ?></td>
                <td data-toggle="tooltip" data-placement="left" title="Alterar" class="d-flex align-items-center" onclick="alterar_status(<?= $row['id'] ?>, <?= $status_alterar ?>)">
                    <i class="fa icon-status fa-circle text-<?= $color ?>"></i>
                    <?= $status ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $('#dataTable').dataTable();
    $('[data-toggle="tooltip"]').tooltip();
</script>