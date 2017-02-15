<h1 class="ls-title-intro ls-ico-users"><?= $tituloPage ?></h1>

<div class="ls-form-horizontal">
	<div class="col-md-5">
		<fieldset>
			<h3 class="ls-title-3">Dados Cadastrais</h3>
			<br>
			<label class="ls-label">
				<b class="ls-label-text">Nome:</b>
				<input type="text" disabled value="<?= @$aluno->nome ?>" required>
			</label>
			<div class="row">
				<label class="ls-label col-md-6">
					<b class="ls-label-text">E-mail:</b>				
					<input type="email" name="email" disabled value="<?= @$aluno->email ?>" required>
				</label>

				<label class="ls-label col-md-6">
					<b class="ls-label-text">Telefone:</b>				
					<input type="email" disabled value="<?= @$aluno->telefone ?>" required>
				</label>

				<label class="ls-label col-md-6">
					<b class="ls-label-text">Documento:</b>				
					<input type="email" disabled value="<?= @$aluno->documento ?>" required>
				</label>

				<label class="ls-label col-md-6">
					<b class="ls-label-text">Skype:</b>				
					<input type="email" disabled value="<?= @$aluno->skype ?>" required>
				</label>
			</div>

		</fieldset>        
	</div>
	<div class="col-md-5 col-md-offset-1">
		<h3 class="ls-title-3">Cursos contratados</h3>
		<br>
		<?php if($aluno->pacote): ?>
		<?php foreach($aluno->pacote as $p) : ?>
			<div class="ls-list">
				<header class="ls-list-header">
					<div class="ls-list-title col-md-9">
						<a href="javascript:void(0)"><?= $p->curso ?></a>
						<small><?= $p->ativo ?></small>
					</div>
				</header>
				<div class="ls-list-content ">
					<div class="col-xs-12 col-md-6">
					<span class="ls-list-label">Horas</span>
					<strong><?= $p->horas ?>H</strong>
					</div>
					<div class="col-xs-12 col-md-6">
					<span class="ls-list-label">Valor</span>
					<strong>R$ <?= number_format($p->valor_total,2,",","."); ?></strong>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
		<?php endif; ?>

	</div>
</div>
