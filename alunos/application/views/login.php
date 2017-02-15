<!DOCTYPE html>
<html class="ls-theme-green ls-main-full">
<head>
	<title>{titulo}</title>

	<meta charset="utf-8">
	<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="description" content="Insira aqui a descrição da página.">
	<link href="<?= base_url('assets') ?>/stylesheets/locastyle.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url('assets') ?>/stylesheets/plugins.css" rel="stylesheet" type="text/css">
	<link rel="icon" sizes="192x192" href="<?= base_url('assets') ?>/images/ico-boilerplate.png">
	<link rel="apple-touch-icon" href="<?= base_url('assets') ?>/images/ico-boilerplate.png">
</head>
<body>
	<div class="ls-login-parent">
		<div class="ls-login-inner">
			<div class="ls-login-container">
				<div class="ls-login-box">
					<h1 class="ls-login-logo"><img title="Logo login" src="{logo}"></h1>
					<h4 align="center">Área do Aluno</h4>
					<br>
					<form role="form" class="ls-form ls-login-form" action="{action}" method="post">
						<fieldset>

						<label class="ls-label">
							<b class="ls-label-text ls-hidden-accessible">Usuário</b>
							<input name="login" class="ls-login-bg-user ls-field-lg" type="text" placeholder="Usuário" required="" autofocus="">
						</label>

						<label class="ls-label">
							<b class="ls-label-text ls-hidden-accessible">Senha</b>
							<div class="ls-prefix-group ls-field-lg">
							<input name="senha" id="password_field" class="ls-login-bg-password" type="password" placeholder="Senha" required="">
							<a class="ls-label-text-prefix ls-toggle-pass ls-ico-eye" data-toggle-class="ls-ico-eye, ls-ico-eye-blocked" data-target="#password_field" href="#"></a>
							</div>
						</label>

						<!--<p><a href="" class="ls-login-forgot" href="forgot-password">Esqueci minha senha</a></p>-->

						<input type="submit" value="Entrar" class="ls-btn-primary ls-btn-block ls-btn-lg">

						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>		
	
	<!-- We recommended use jQuery 1.10 or up -->
	<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="<?= base_url('assets') ?>/javascripts/locastyle.js" type="text/javascript"></script>
	<script src="<?= base_url('assets') ?>/javascripts/plugins.js" type="text/javascript"></script>
	{notify}
</body>
</html>