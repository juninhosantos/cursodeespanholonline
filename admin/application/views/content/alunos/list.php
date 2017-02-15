<h1 class="ls-title-intro ls-ico-users">Alunos</h1>

<div class="ls-float-right">
    <a href="<?= $btnNovo ?>" class="ls-btn">Cadastrar Aluno</a>
</div>

<div class="ls-clearfix"></div>
<br>

<table class="ls-table ls-no-hover ls-table-striped">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Data Entrada</th>
            <th>Status</th>
            <th width="12%"></th>
        </tr>
    </thead>
    <tbody>
        <?php if($alunos): ?>
            <?php foreach($alunos as $aluno) : ?>
            <tr>
                <td><?= $aluno->nome ?></td>
                <td><?= $aluno->data ?></td>
                <td><?= $aluno->status ?></td>
                <td>
                    <a href="<?= site_url('alunos/deletar/'.$aluno->id) ?>" class="ls-btn-danger" title="Desativar"><i class="ls-ico-close"></i></a>
                    <a href="<?= site_url('alunos/editar/'.$aluno->id) ?>" class="ls-btn" title="Ver Informações"><i class="ls-ico-eye"></i></a>
                </td>
            </tr>
            <?php endforeach ?>
        <?php endif; ?>
    </tbody>
</table>