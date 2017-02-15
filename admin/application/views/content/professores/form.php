<h1 class="ls-title-intro ls-ico-users"><?= $tituloPage ?></h1>

<form id="postForm" action="<?= $action ?>" method="post" class="ls-form ls-form-horizontal row " data-ls-module="form" enctype="multipart/form-data">
	<div class="col-md-6">
		<fieldset>
			<label class="ls-label">
				<b class="ls-label-text">Nome:</b>
				<input type="text" name="nome" value="<?= @$prof[0]->nome ?>" required>
			</label>
			<label class="ls-label">
				<b class="ls-label-text">E-mail:</b>				
				<input type="email" name="email" value="<?= @$prof[0]->email ?>" required>
			</label>
			
			<div align="right">
				<button class="ls-btn-success ls-btn-lg">Salvar</button>
			</div>
		</fieldset>        
	</div>
</form>