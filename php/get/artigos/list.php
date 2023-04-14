<?php
session_start();
include_once("../../../conn/conexao.php");

$where = "";
if ($_SESSION['jgGn67bXK3çPartner'] == 1) {
  $where .= "AND partner_id = " . $_SESSION['jgGn67bXK3ç'];
}

$limit = $_GET['limit'];
$offset = $_GET['offset'];

$sql = "SELECT 
            a.*,
            c.name as category
        FROM articles AS a
        INNER JOIN categories AS c ON
            a.category_id = c.id
        WHERE 
            a.status = 1 
            $where 
        LIMIT $limit OFFSET $offset";
$res_artigos = mysqli_query($conn, $sql);

foreach ($res_artigos as $row) { ?>
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
            <li><a class="btn_1 gray"><i class="fa fa-fw fa-edit"></i> Editar</a></li>
            <?php if ($row['status'] == 0) { ?>
                <li><a class="btn_1 gray approve"><i class="fa fa-fw fa-check-circle-o"></i> Aprovar</a></li>
            <?php } elseif ($row['status'] == 1) { ?>
                <li><a class="btn_1 gray delete"><i class="fa fa-fw fa-times-circle-o"></i> Inativar</a></li>
            <?php } ?>
        </ul>
    </li>
<?php } ?>