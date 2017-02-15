<h1 class="ls-title-intro ls-ico-users"><?= $tituloPage ?></h1>

<form id="postForm" action="<?= $action ?>" method="post" class="ls-form ls-form-horizontal row " data-ls-module="form" enctype="multipart/form-data">
	<div class="col-md-6">
		<fieldset>
			<label class="ls-label">
				<b class="ls-label-text">Nome:</b>
				<input type="text" name="nome" value="<?= @$aluno[0]->nome ?>" required>
			</label>
			<label class="ls-label">
				<b class="ls-label-text">E-mail:</b>				
				<input type="email" name="email" value="<?= @$aluno[0]->email ?>" required>
			</label>
			<label class="ls-label">
				<b class="ls-label-text">Curso:</b>
				<div class="ls-custom-select">				
					<select name="curso" onchange="App.methods.getCurso(this)" class="ls-select">
						<option value="">Selecione...</option>
						<?php if($cursos) : ?>
							<?php foreach($cursos as $curso) : ?>
								<option value="<?= $curso->id ?>"><?= $curso->nome_br ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
						<option value="0">Personalizado</option>
					</select>
				</div>
			</label>
			<div class="row">
				<label class="ls-label col-md-4">
					<b class="ls-label-text">Horas:</b>				
					<input type="text" class="time" name="horas" value="" >
				</label>
				<label class="ls-label col-md-4">
					<b class="ls-label-text">Tipo de Horas:</b>
					<div class="ls-custom-select">				
						<select name="tipo" class="ls-select">
							<option value="pacote">Pacote</option>
							<option value="avulso">Avulso</option>
						</select>
					</div>
				</label>
				<label class="ls-label col-md-4">
					<b class="ls-label-text">Valor Hora:</b>				
					<input type="text" class="money" name="valor" value="" >
				</label>
			</div>
			<div align="right">
				<button class="ls-btn-success ls-btn-lg">Salvar</button>
			</div>
		</fieldset>        
	</div>
</form>