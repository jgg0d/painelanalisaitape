<?php
include_once('../conn/conexao.php');

$sql = "SELECT * FROM feedbacks WHERE status = 0 LIMIT 5";
$res_feedbacks = mysqli_query($conn, $sql);
$count_feedbacks = mysqli_num_rows($res_feedbacks);

$sql = "SELECT COUNT(id) FROM feedbacks WHERE status = 0";
$res_total_feedbacks = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($res_total_feedbacks)) {
  $max_feedbacks = $row[0];
}

$qtd_paginator = ceil($max_feedbacks / 5);
?>
<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="#dashboard" onclick="page('dashboard.php')">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Feedbacks</li>
</ol>

<div class="card mb-3">
  <div class="card-header d-flex align-items-center justify-between">
    <label class="m-0">
      <i class="fa fa-table"></i> Lista de Feedbacks
    </label>
    <div class="filter d-flex align-items-center justify-between">
      <button class="btn_1" onclick="novo_artigo()">+ Cadastrar</button>
      <a class="btn btn-default p-0 btn-filter-collapse" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
        <i class="fa fa-align-justify"></i>
      </a>
    </div>
  </div>

  <div class="card-header collapse bg-color-white" id="collapseExample">
    <div class="filter">
      <select name="filtro-status" id="filtro-status" class="form-control" onchange="filtrar()">
        <option value="">Status</option>
        <option value="0">Em Aberto</option>
        <option value="1">Encerrados</option>
        <option value="2">Cancelados</option>
      </select>
    </div>
  </div>

  <div class="card-body padding-list">
    <div class="list_noimg reviews">
      <ul id="list-feedbacks">
        <?php
        if ($count_feedbacks > 0) {
          foreach ($res_feedbacks as $row) {
            $disabled = !$row['email'] || $row['email'] == "" ? "disabled" : "";
        ?>
            <li>
              <h4><?= $row['title'] != "" ? $row['title'] : "Sem título" ?></h4>
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
      </ul>
    </div>

    <div class="row">
      <div class="col-md-5"></div>
      <div class="col-sm-12 col-md-7 text-right">
        <nav aria-label="...">
          <ul class="pagination pagination-sm add_bottom_15 add_top_15 float-right">
            <li id="prev-button" class="page-item disabled" onclick="previous()">
              <a class="page-link" tabindex="-1">Anterior</a>
            </li>

            <?php
            // LIMIT PAGINATOR - LOCALIZAR
            $limit = 5;
            for ($i = 1; $i <= $qtd_paginator; $i++) {
              $offset = ($i - 1) * $limit;
            ?>
              <li id="item-<?= $i ?>" class="page-item c-pointer <?= $i == 1 ? "active" : "" ?>" onclick="carregar_feedbacks(<?= $limit ?>, <?= $offset ?>)"><a class="page-link"><?= $i ?></a></li>
            <?php } ?>
            <li id="next-button" class="page-item <?= $max_feedbacks <= $limit ? "disabled" : "c-pointer" ?>" onclick="next()">
              <a class="page-link" tabindex="-1">Próximo</a>
            </li>
          </ul>
        </nav>
      </div>
    </div>

    <div class="modal fade" id="modalReplica" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Réplica de Feedback</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="php/utils/emails/send_reply.php" method="POST">
            <div class="modal-body">
              <label for="">Réplica para <b><span id="email_replica"></span>:</b></label>
              <input type="hidden" id="id_feedback_replica" name="id_feedback_replica">
              <input type="hidden" id="email_replica_input" name="email_replica_input">
              <textarea name="replica" id="replica" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary c-pointer" data-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-primary c-pointer">Enviar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modalStatusFeedback" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirmar modificação</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="php/update/feedbacks/status.php" method="POST" enctype="multipart/form-data">
            <input id="id_feedback_status" name="id_feedback_status" type="hidden">
            <input id="status_feedback" name="status_feedback" type="hidden">
            <div class="modal-body">
              <div class="form-row">
                <div class="col">
                  <label id="msg-status"></label>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary c-pointer" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary c-pointer">Confirmar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>
      $(".selectbox").selectbox();

      // variaveis globais para paginação
      var page_items = 1;

      var qtd_paginator = parseInt(<?= $qtd_paginator ?>);

      // LIMIT PAGINATOR - LOCALIZAR
      var limit = 5;

      // variaveis utilizadas para permitir ou não evento onclick
      var prev = false;
      var max_feedbacks = parseInt(<?= $max_feedbacks ?>);

      var nxt = max_feedbacks <= limit ? false : true;

      async function carregar_feedbacks(limit, offset, aux = 0) {
        // auxiliar de next e previous
        page_items += aux;

        // calculo de "pagina aberta"
        page_items = (offset / limit) + 1

        // verificação botão previous
        page_items == 1 ? $('#prev-button').removeClass('c-pointer') : $('#prev-button').addClass('c-pointer');
        page_items == 1 ? $('#prev-button').addClass('disabled') : $('#prev-button').removeClass('disabled');
        prev = page_items == 1 ? false : true;

        // verificação botão next
        page_items == qtd_paginator ? $('#next-button').removeClass('c-pointer') : $('#next-button').addClass('c-pointer');
        page_items == qtd_paginator ? $('#next-button').addClass('disabled') : $('#next-button').removeClass('disabled');
        nxt = page_items == qtd_paginator ? false : true;

        // estado ativo dos botões do paginator, ativa apenas o aberto
        $(".page-item").removeClass("active");
        $("#item-" + page_items).addClass("active");

        var data =
          "<div id='spinner' class='spinner-border' role='status' style='margin-left: 47%;margin-top: 20%;margin-bottom: 20%; color:#1CB4D5; width:5rem; height:5rem;'><span class='sr-only'>Loading...</span></div>";
        $('#list-feedbacks').html(data);

        await $.get(`php/get/feedbacks/list.php?limit=${limit}&offset=${offset}`, (data) => {
          $('#list-feedbacks').html(data);
        })
      }

      function next() {
        if (nxt) {
          page_items += 1;
          var offset = (page_items - 1) * limit;
          carregar_feedbacks(limit, offset)
        }
      }

      function previous() {
        if (prev) {
          page_items -= 1;
          var offset = (page_items - 1) * limit;
          carregar_feedbacks(limit, offset)
        }
      }

      async function alterar_status(id, status) {
        await $.get(`php/get/feedbacks?id=${id}`, (data) => {
          const json = JSON.parse(data)[0];

          let msg = ""

          if (status == 1) {
            msg = `Confirme o encerramento do feedback "${json.title}"`
          } else if (status == 2) {
            msg = `Confirme o cancelamento do feedback "${json.title}"`
          };

          $('#msg-status').html(msg);
          $('#id_feedback_status').val(id);
          $('#status_feedback').val(status);
        })

        $('#modalStatusFeedback').modal('show');
      }

      async function replicar_feedback(id) {
        await $.get(`php/get/feedbacks?id=${id}`, (data) => {
          const json = JSON.parse(data)[0];

          $('#id_feedback_replica').val(id);
          $('#email_replica').html(json.email);
          $('#email_replica_input').val(json.email);
        })
        $('#modalReplica').modal('show');
      }

      async function filtrar() {
        var status = $('#filtro-status').val() !== "" ? parseInt($('#filtro-status').val()) : "";

        var data =
          "<div id='spinner' class='spinner-border' role='status' style='margin-left: 47%;margin-top: 20%;margin-bottom: 20%; color:#1CB4D5; width:5rem; height:5rem;'><span class='sr-only'>Loading...</span></div>";
        $("#list-feedbacks").html(data);

        await $.get(`php/filters/feedbacks.php?status=${status}`, (data) => {
          $('#list-feedbacks').html(data);
        })
      }
    </script>