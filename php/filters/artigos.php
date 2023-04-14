<?php
session_start();
include_once('../../conn/conexao.php');

$status = isset($_GET['status']) ? $_GET['status'] : "";

$where = "";

if ($status != "") {
    $where .= "WHERE a.status = $status";
}

if ($_SESSION['jgGn67bXK3çPartner'] == 1) {
    $where .= "AND partner_id = " . $_SESSION['jgGn67bXK3ç'];
}

$sql = "SELECT 
          a.*,
          c.name AS category
        FROM articles AS a
        INNER JOIN categories AS c ON
          a.category_id = c.id
        $where
        LIMIT 5";
$res_articles = mysqli_query($conn, $sql);
$count_articles = mysqli_num_rows($res_articles);

if ($count_articles > 0) {
    foreach ($res_articles as $row) {
?>
        <li>
            <!-- inserir imagem do banco -->
            <figure><img src="img/course_1.jpg" alt=""></figure>
            <h4><?= $row['title'] ?>
                <!--<i class="pending">Pending</i>-->
            </h4>
            <ul class="course_list">
                <li><strong>Data</strong> <?= date("d/m/Y", strtotime($row['create_date'])); ?></li>
                <li><strong>Categoria</strong> <?= $row['category'] ?></li>
            </ul>
            <h6>Descrição do artigo</h6>
            <p><?= $row['description'] ?></p>
            <!-- <p class="inline-popups">
              <a class="btn_1 gray c-pointer"><i class="fa fa-commenting-o"></i> Palavra</a>
              <a class="btn_1 gray c-pointer"><i class="fa fa-commenting-o"></i> Palavra</a>
              <a class="btn_1 gray c-pointer"><i class="fa fa-commenting-o"></i> Palavra</a>
            </p> -->
            <ul class="buttons">
                <li><a onclick="edit_artigo(<?= $row['id'] ?>)" class="btn_1 gray"><i class="fa fa-fw fa-edit"></i> Editar</a></li>
                <?php if ($row['status'] == 0) { ?>
                    <li><a onclick="alterar_status(<?= $row['id'] ?>, 1)" class="btn_1 gray approve"><i class="fa fa-fw fa-check-circle-o"></i> Aprovar</a></li>
                <?php } elseif ($row['status'] == 1) { ?>
                    <li><a onclick="alterar_status(<?= $row['id'] ?>, 0)" class="btn_1 gray delete"><i class="fa fa-fw fa-times-circle-o"></i> Inativar</a></li>
                <?php } ?>
            </ul>
        </li>
    <?php }
} else { ?>
    <li>
        <h4>Não há artigos</h4>
        <p>Nada para exibir aqui.</p>
    </li>
<?php } ?>