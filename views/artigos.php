<?php
session_start();
include_once('../conn/conexao.php');

$where = "";
if ($_SESSION['jgGn67bXK3çPartner'] == 1) {
  $where = "WHERE a.partner_id = " . $_SESSION['jgGn67bXK3ç'];
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

$sql = "SELECT COUNT(id) FROM articles WHERE status = 1 $where";
$res_total_artigos = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($res_total_artigos)) {
  $max_artigos = $row[0];
}

$qtd_paginator = ceil($max_artigos / 5);

$sql = "SELECT * FROM categories WHERE status = 1";
$res_categories = mysqli_query($conn, $sql);
?>

<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="#dashboard" onclick="page('dashboard.php')">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Artigos</li>
</ol>

<div class="card mb-3">
  <div class="card-header d-flex align-items-center justify-between">
    <label class="m-0">
      <i class="fa fa-table"></i> Lista de Artigos
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
        <option value="1">Aprovados</option>
        <option value="0">Inativos</option>
      </select>
    </div>
  </div>

  <div class="card-body padding-list">
    <div class="<?= $count_articles > 0 ? "list_general" : "list_noimg" ?>">
      <ul id="list-artigos">
        <?php
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
      </ul>

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
                <li id="item-<?= $i ?>" class="page-item c-pointer <?= $i == 1 ? "active" : "" ?>" onclick="carregar_artigos(<?= $limit ?>, <?= $offset ?>)"><a class="page-link"><?= $i ?></a></li>
              <?php } ?>
              <li id="next-button" class="page-item <?= $max_artigos <= $limit ? "disabled" : "c-pointer" ?>" onclick="next()">
                <a class="page-link" tabindex="-1">Próximo</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
</div>

<div class="modal fade" id="modalCadastroArtigo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Novo Artigo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="php/post/artigos/" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-row">
            <div class="col">
              <label for="imagem-select">Imagem (800x560)</label>
              <div class="select-image-div c-pointer" onclick="selecionar_imagem()">
                <h3 id="imagem-label" class="color-grey">Selecione a imagem</h3>
                <img id="imagem-preview" class="img-preview d-none">
              </div>
              <input accept=".jpg,.jpeg,.png" id="imagem-select" name="imagem" type="file" class="form-control" style="display:none" onchange="mostrar_imagem(this)">
            </div>
          </div>
          <br>
          <div class="form-row">
            <div class="col">
              <label for="titulo">Título</label>
              <input id="titulo" name="titulo" type="text" class="form-control" placeholder="Título" required>
            </div>
            <div class="col">
              <label for="categoria">Categoria</label>
              <select id="categoria" name="categoria" class="form-control" required>
                <option>Escolha</option>
                <?php foreach ($res_categories as $row) { ?>
                  <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <br>
          <div class="form-row">
            <div class="col">
              <label for="descricao">Descrição</label>
              <textarea id="descricao" name="descricao" type="text" class="form-control" placeholder="Descrição"></textarea>
            </div>
          </div>
          <br>
          <textarea id="texto-artigo" name="texto"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary c-pointer" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary c-pointer">Cadastrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalEditaArtigo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Artigo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="php/update/artigos/" method="POST" enctype="multipart/form-data">
        <input id="id_artigo_edit" name="id_artigo_edit" type="hidden">
        <div class="modal-body">
          <div class="form-row">
            <div class="col">
              <label for="imagem-select-edit">Imagem (800x560)</label>
              <div class="select-image-div c-pointer" onclick="selecionar_imagem('-edit')">
                <h3 id="imagem-label-edit" class="color-grey">Selecione a imagem</h3>
                <img id="imagem-preview-edit" class="img-preview d-none">
              </div>
              <input accept=".jpg,.jpeg,.png" id="imagem-select-edit" name="imagem_edit" type="file" class="form-control" style="display:none" onchange="mostrar_imagem(this, '-edit')">
            </div>
          </div>
          <br>
          <div class="form-row">
            <div class="col">
              <label for="titulo_edit">Título</label>
              <input id="titulo_edit" name="titulo_edit" type="text" class="form-control" placeholder="Título" required>
            </div>
            <div class="col">
              <label for="categoria_edit">Categoria</label>
              <select id="categoria_edit" name="categoria_edit" class="form-control" required>
                <option>Escolha</option>
                <?php foreach ($res_categories as $row) { ?>
                  <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <br>
          <div class="form-row">
            <div class="col">
              <label for="descricao_edit">Descrição</label>
              <textarea id="descricao_edit" name="descricao_edit" type="text" class="form-control" placeholder="Descrição"></textarea>
            </div>
          </div>
          <br>
          <textarea id="texto-artigo-edit" name="texto_edit"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary c-pointer" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary c-pointer">Editar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalStatusArtigo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmar modificação</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="php/update/artigos/status.php" method="POST" enctype="multipart/form-data">
        <input id="id_artigo_status" name="id_artigo_status" type="hidden">
        <input id="status_artigo" name="status_artigo" type="hidden">
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

<script src="https://cdn.tiny.cloud/1/brytzs8dl9745c0rxqnnlt4twltlgdu43tbkcccmy9m1u7ge/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
  $(".selectbox").selectbox();

  // variaveis globais para paginação
  var page_items = 1;

  var qtd_paginator = parseInt(<?= $qtd_paginator ?>);

  // LIMIT PAGINATOR - LOCALIZAR
  var limit = 5;

  // variaveis utilizadas para permitir ou não evento onclick
  var prev = false;
  var max_artigos = parseInt(<?= $max_artigos ?>);

  var nxt = max_artigos <= limit ? false : true;

  async function carregar_artigos(limit, offset, aux = 0) {
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
    $('#list-artigos').html(data);

    await $.get(`php/get/artigos/list.php?limit=${limit}&offset=${offset}`, (data) => {
      $('#list-artigos').html(data);
    })
  }

  function next() {
    if (nxt) {
      page_items += 1;
      var offset = (page_items - 1) * limit;
      carregar_artigos(limit, offset)
    }
  }

  function previous() {
    if (prev) {
      page_items -= 1;
      var offset = (page_items - 1) * limit;
      carregar_artigos(limit, offset)
    }
  }

  async function novo_artigo() {
    await tinymce.init({
      selector: 'textarea#texto-artigo',
      height: 400,
      language: 'pt_BR',
      plugins: [
        'advlist autolink lists charmap print preview',
        'visualblocks code',
        'insertdatetime table paste code help wordcount'
      ],
      toolbar: 'undo redo | formatselect | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help',
      content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });

    $('#modalCadastroArtigo').modal('show');
  }

  function selecionar_imagem(edit = "") {
    $('#imagem-select' + edit).click();
  }

  function mostrar_imagem(obj, edit = "") {
    const [file] = obj.files;
    if (file) {
      document.getElementById('imagem-preview' + edit).src = URL.createObjectURL(file);
      $('#imagem-label' + edit).addClass('d-none');
      $('#imagem-preview' + edit).removeClass('d-none');
    } else {
      $('#imagem-label' + edit).removeClass('d-none');
      $('#imagem-preview' + edit).addClass('d-none');
    }
  }

  async function edit_artigo(id) {
    await tinymce.init({
      selector: 'textarea#texto-artigo-edit',
      height: 400,
      language: 'pt_BR',
      plugins: [
        'advlist autolink lists charmap print preview',
        'visualblocks code',
        'insertdatetime table paste code help wordcount'
      ],
      toolbar: 'undo redo | formatselect | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help',
      content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });

    await $.get(`php/get/artigos?id=${id}`, (data) => {
      const json = JSON.parse(data)[0];

      $('#id_artigo_edit').val(id);
      $('#categoria_edit').val(json.category_id);
      $('#titulo_edit').val(json.title);
      $('#descricao_edit').val(json.description);

      tinymce.get('texto-artigo-edit').setContent(json.text, {
        format: 'html'
      })

      if (json.img && json.img != "") {
        document.getElementById('imagem-preview-edit').src = 'data:image/png;base64,' + json.img;
        $('#imagem-label-edit').addClass('d-none');
        $('#imagem-preview-edit').removeClass('d-none');
      } else {
        $('#imagem-label-edit').removeClass('d-none');
        $('#imagem-preview-edit').addClass('d-none');
      }
    })

    $('#modalEditaArtigo').modal('show');
  }

  async function alterar_status(id, status) {
    await $.get(`php/get/artigos?id=${id}`, (data) => {
      const json = JSON.parse(data)[0];

      const msg = status == 0 ? `Confirme a inativação do artigo "${json.title}"` : `Confirme a aprovação do artigo "${json.title}"`;

      $('#msg-status').html(msg);
      $('#id_artigo_status').val(id);
      $('#status_artigo').val(status);
    })

    $('#modalStatusArtigo').modal('show');
  }

  async function filtrar() {
    var status = $('#filtro-status').val() !== "" ? parseInt($('#filtro-status').val()) : "";

    var data =
      "<div id='spinner' class='spinner-border' role='status' style='margin-left: 47%;margin-top: 20%;margin-bottom: 20%; color:#1CB4D5; width:5rem; height:5rem;'><span class='sr-only'>Loading...</span></div>";
    $("#list-artigos").html(data);

    await $.get(`php/filters/artigos.php?status=${status}`, (data) => {
      $('#list-artigos').html(data);
    })
  }
</script>