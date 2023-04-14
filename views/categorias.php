<?php
session_start();
include_once('../conn/conexao.php');

$sql = "SELECT * FROM categories";
$res_categories = mysqli_query($conn, $sql);
?>
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#dashboard" onclick="page('dashboard.php')">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Categorias</li>
</ol>
<!-- Example DataTables Card-->
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-between">
        <label class="m-0">
            <i class="fa fa-table"></i> Lista de Categorias
        </label>
        <div class="filter d-flex align-items-center justify-between">
            <button class="btn_1" onclick="nova_categoria()">+ Cadastrar</button>
            <a class="btn btn-default p-0 btn-filter-collapse" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa fa-align-justify"></i>
            </a>
        </div>
    </div>

    <div class="card-header collapse bg-color-white" id="collapseExample">
        <div class="filter">
            <select name="filtro-status" id="filtro-status" class="form-control" onchange="filtrar()">
                <option value="">Status</option>
                <option value="1">Ativas</option>
                <option value="0">Inativas</option>
            </select>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive" id="table-categorias">
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
        </div>
    </div>
    <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
</div>

<div class="modal fade" id="modalCadastroCategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nova Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="php/post/categorias/" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col">
                            <label for="nome">Nome</label>
                            <input id="nome" name="nome" type="text" class="form-control" placeholder="Nome" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary c-pointer" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary c-pointer">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditaCategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="php/update/categorias/" method="POST" enctype="multipart/form-data">
                <input id="id_categoria_edit" name="id_categoria_edit" type="hidden">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col">
                            <label for="nome_edit">Nome</label>
                            <input id="nome_edit" name="nome_edit" type="text" class="form-control" placeholder="Nome" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary c-pointer" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary c-pointer">Editar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalStatusCategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmar modificação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="php/update/categorias/status.php" method="POST" enctype="multipart/form-data">
                <input id="id_categoria_status" name="id_categoria_status" type="hidden">
                <input id="status_categoria" name="status_categoria" type="hidden">
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
    $('#dataTable').dataTable();

    $('[data-toggle="tooltip"]').tooltip();

    $("#permissoes").selectize({
        plugins: ["remove_button"],
        delimiter: ",",
        persist: false
    });

    $("#permissoes_edit").selectize({
        plugins: ["remove_button"],
        delimiter: ",",
        persist: false
    });

    function nova_categoria() {
        $('#modalCadastroCategoria').modal('show');
    }

    async function editar_categoria(id) {
        await $.get(`php/get/categorias?id=${id}`, (data) => {
            const json = JSON.parse(data)[0];

            $('#id_categoria_edit').val(json.id);
            $('#nome_edit').val(json.name);

            $('#modalEditaCategoria').modal('show');
        })
    }

    async function alterar_status(id, status) {
        await $.get(`php/get/categorias?id=${id}`, (data) => {
            const json = JSON.parse(data)[0];

            const msg = status == 0 ? `Confirme a inativação da categoria "${json.name}"` : `Confirme a ativação da categoria "${json.name}"`;

            $('#msg-status').html(msg);
            $('#id_categoria_status').val(id);
            $('#status_categoria').val(status);
        })

        $('#modalStatusCategoria').modal('show');
    }

    async function filtrar() {
        var status = $('#filtro-status').val() !== "" ? parseInt($('#filtro-status').val()) : "";

        var data =
            "<div id='spinner' class='spinner-border' role='status' style='margin-left: 47%;margin-top: 20%;margin-bottom: 20%; color:#1CB4D5; width:5rem; height:5rem;'><span class='sr-only'>Loading...</span></div>";
        $("#table-categorias").html(data);

        await $.get(`php/filters/categorias.php?status=${status}`, (data) => {
            $('#table-categorias').html(data);
        })
    }
</script>