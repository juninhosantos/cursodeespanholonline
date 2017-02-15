<h1 class="ls-title-intro ls-ico-users">Professores</h1>

<div class="ls-float-right">
    <a href="<?= $btnNovo ?>" class="ls-btn">Cadastrar Professor</a>
</div>

<div class="ls-clearfix"></div>
<br>

<table class="ls-table ls-no-hover ls-table-striped">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Data Entrada</th>
            <th width="12%"></th>
        </tr>
    </thead>
    <tbody>
        <?php if($professores): ?>
            <?php foreach($professores as $p) : ?>
            <tr>
                <td><?= $p->nome ?></td>
                <td><?= date("d/m/Y",strtotime($p->data_cadastro)); ?></td>
                <td>
                    <a href="<?php echo site_url('professores/deletar/'.$p->id) ?>" class="ls-btn-danger" title="Desativar"><i class="ls-ico-close"></i></a>
                    <a href="<?php echo site_url('professores/visualizar/'.$p->id) ?>" class="ls-btn" title="Ver Informações"><i class="ls-ico-eye"></i></a>
                </td>
            </tr>
            <?php endforeach ?>
        <?php endif; ?>
    </tbody>
</table>