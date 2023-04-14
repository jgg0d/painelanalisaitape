<?php
session_start();
include_once('../conn/conexao.php');

$sql = "SELECT * FROM administrators WHERE partner = 0";
$res_administrators = mysqli_query($conn, $sql);

$sql = "SELECT * FROM permissions";
$res_permissions = mysqli_query($conn, $sql);
?>
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#dashboard" onclick="page('dashboard.php')">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Administradores</li>
</ol>
<!-- Example DataTables Card-->
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-between">
        <label class="m-0">
            <i class="fa fa-table"></i> Lista de Administradores
        </label>
        <div class="filter d-flex align-items-center justify-between">
            <button class="btn_1" onclick="novo_administrador()">+ Cadastrar</button>
            <a class="btn btn-default p-0 btn-filter-collapse" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa fa-align-justify"></i>
            </a>
        </div>
    </div>

    <div class="card-header collapse bg-color-white" id="collapseExample">
        <div class="filter">
            <select name="filtro-status" id="filtro-status" class="form-control" onchange="filtrar()">
                <option value="">Status</option>
                <option value="1">Ativos</option>
                <option value="0">Inativos</option>
            </select>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive" id="table-administradores">
            <table class="table table-hover c-pointer" id="dataTable" width="100%" cellspacing="0">
                <thead data-toggle="tooltip" data-placement="top" title="Clique 2x para editar">
                    <tr>
                        <th>Nome</th>
                        <th>Contato</th>
                        <th width="20%">Descrição</th>
                        <th>Cadastro</th>
                        <th>Atualização</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tfoot data-toggle="tooltip" data-placement="bottom" title="Clique 2x para editar">
                    <tr>
                        <th>Nome</th>
                        <th>Contato</th>
                        <th width="20%">Descrição</th>
                        <th>Cadastro</th>
                        <th>Atualização</th>
                        <th>Status</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($res_administrators as $row) {
                        $color = $row['status'] == 0 ? "danger" : "success";
                        $status = $row['status'] == 0 ? "Inativo" : "Ativo";
                        $status_alterar = $row['status'] == 0 ? 1 : 0;
                        $data_update = $row['update_date'] ? date('d/m/Y', strtotime($row['update_date'])) : "Nunca";
                    ?>
                        <tr ondblclick="editar_usuario(<?= $row['id'] ?>)">
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['description'] ?></td>
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

<div class="modal fade" id="modalCadastroAdministrador" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Novo Administrador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="php/post/administradores/" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col">
                            <label for="nome">Nome</label>
                            <input id="nome" name="nome" type="text" class="form-control" placeholder="Nome" required>
                        </div>
                        <div class="col">
                            <label for="contato">Contato</label>
                            <input id="contato" name="contato" type="email" class="form-control" placeholder="email@email.com" required>
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
                    <div class="form-row">
                        <div class="col">
                            <label for="login">Login</label>
                            <input id="login" name="login" type="text" class="form-control" placeholder="Login" required>
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <label for="permissoes">Permissões</label>
                            <select id="permissoes" name="permissoes[]" multiple required>
                                <?php foreach ($res_permissions as $row) { ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                                <?php } ?>
                            </select>
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

<div class="modal fade" id="modalEditaAdministrador" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Administrador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="php/update/administradores/" method="POST" enctype="multipart/form-data">
                <input id="id_administrador_edit" name="id_administrador_edit" type="hidden">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col">
                            <label for="nome_edit">Nome</label>
                            <input id="nome_edit" name="nome_edit" type="text" class="form-control" placeholder="Nome" required>
                        </div>
                        <div class="col">
                            <label for="contato_edit">Contato</label>
                            <input id="contato_edit" name="contato_edit" type="email" class="form-control" placeholder="email@email.com" required>
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
                    <div class="form-row">
                        <div class="col">
                            <label for="login_edit">Login</label>
                            <input id="login_edit" name="login_edit" type="text" class="form-control" placeholder="email@email.com" required>
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <label for="permissoes_edit">Permissões</label>
                            <select id="permissoes_edit" name="permissoes_edit[]" multiple required>
                                <?php foreach ($res_permissions as $row) { ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                                <?php } ?>
                            </select>
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

<div class="modal fade" id="modalStatusAdministrador" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmar modificação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="php/update/administradores/status.php" method="POST" enctype="multipart/form-data">
                <input id="id_administrador_status" name="id_administrador_status" type="hidden">
                <input id="status_administrador" name="status_administrador" type="hidden">
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

    $(".selectbox").selectbox();

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

    function novo_administrador() {
        $('#modalCadastroAdministrador').modal('show');
    }

    async function editar_usuario(id) {
        await $.get(`php/get/administradores?id=${id}`, (data) => {
            const json = JSON.parse(data)[0];

            $('#id_administrador_edit').val(json.id);
            $('#nome_edit').val(json.name);
            $('#contato_edit').val(json.email);
            $('#descricao_edit').val(json.description);
            $('#login_edit').val(json.login);

            var selectize = $('#permissoes_edit').selectize()[0].selectize;
            selectize.setValue(json.permissions);

            $('#modalEditaAdministrador').modal('show');
        })
    }

    async function alterar_status(id, status) {
        await $.get(`php/get/administradores?id=${id}`, (data) => {
            const json = JSON.parse(data)[0];

            const msg = status == 0 ? `Confirme a inativação do administrador "${json.name}"` : `Confirme a ativação do administrador "${json.name}"`;

            $('#msg-status').html(msg);
            $('#id_administrador_status').val(id);
            $('#status_administrador').val(status);
        })

        $('#modalStatusAdministrador').modal('show');
    }

    async function filtrar() {
        var status = $('#filtro-status').val() !== "" ? parseInt($('#filtro-status').val()) : "";

        var data =
            "<div id='spinner' class='spinner-border' role='status' style='margin-left: 47%;margin-top: 20%;margin-bottom: 20%; color:#1CB4D5; width:5rem; height:5rem;'><span class='sr-only'>Loading...</span></div>";
        $("#table-administradores").html(data);

        await $.get(`php/filters/administradores.php?status=${status}`, (data) => {
            $('#table-administradores').html(data);
        })
    }
</script>