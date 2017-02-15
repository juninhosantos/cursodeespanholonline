<h1 class="ls-title-intro ls-ico-users"><?= $tituloPage ?></h1>

<div class="ls-form ls-form-horizontal row ">
	<div class="col-md-6">
		<fieldset>
			<label class="ls-label">
				<b class="ls-label-text">Nome:</b>
				<input type="text" disabled name="nome" value="<?= @$prof[0]->nome ?>" >
			</label>
			<div class="row">
				<label class="ls-label col-md-6">
					<b class="ls-label-text">E-mail:</b>				
					<input type="email" disabled name="email" value="<?= @$prof[0]->email ?>" >
				</label>
				<label class="ls-label col-md-6">
					<b class="ls-label-text">Documento:</b>				
					<input type="email" disabled name="email" value="<?= @$prof[0]->documento ?>" >
				</label>
				<label class="ls-label col-md-6">
					<b class="ls-label-text">Telefone:</b>				
					<input type="email" disabled name="email" value="<?= @$prof[0]->telefone ?>" >
				</label>
				<label class="ls-label col-md-6">
					<b class="ls-label-text">Skype:</b>				
					<input type="email" disabled name="email" value="<?= @$prof[0]->skype ?>" >
				</label>
			</div>
			
		</fieldset>        
	</div>
</div>