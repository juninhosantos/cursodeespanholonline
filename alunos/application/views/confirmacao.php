<!DOCTYPE html>
<html class="ls-theme-green ls-main-full">
<head>
	<title>Área do Aluno - Cursos de Espanhol Online</title>

	<meta charset="utf-8">
	<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="description" content="Insira aqui a descrição da página.">
	<link href="<?= base_url('assets') ?>/stylesheets/locastyle.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url('assets') ?>/stylesheets/plugins.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url('assets') ?>/stylesheets/main.css" rel="stylesheet" type="text/css">
	<link rel="icon" sizes="192x192" href="<?= base_url('assets') ?>/images/ico-boilerplate.png">
	<link rel="apple-touch-icon" href="<?= base_url('assets') ?>/images/ico-boilerplate.png">
</head>
<body>
	<div class="ls-login-parent">
		<div class="ls-login-inner">
			<div class="ls-login-container">
				<br>
				<br>
				<div class="col-md-8 col-md-offset-2">
					<h1 class="ls-login-logo"><img title="Logo login" src="<?= base_url('assets/images/logo.svg') ?>"></h1>
					<div class="step1 ls-box">
						<?php if($confirm) : ?>
							<h5 class="ls-title-5">Complete seu cadastro</h5>
							<form method="post" id="dados" class="ls-form ls-form-horizontal">
								<fieldset>
									<label class="ls-label">
										<b class="ls-label-text ls-display-block ls-txt-left">Nome:</b>
										<input type="text" name="nome" value="<?= @$aluno->nome ?>" required >
									</label>
									<div class="row">
										<label class="ls-label col-md-6">
											<b class="ls-label-text ls-display-block ls-txt-left">E-mail:</b>
											<input type="email" name="email" value="<?= @$aluno->email ?>" required >
										</label>
										<label class="ls-label col-md-6">
											<b class="ls-label-text ls-display-block ls-txt-left">Documento:</b>
											<input type="text" name="documento" value="<?= @$aluno->documento ?>" required >
										</label>
										<label class="ls-label col-md-6">
											<b class="ls-label-text ls-display-block ls-txt-left">Telefone:</b>
											<input type="text" name="telefone" value="<?= @$aluno->telefone ?>" >
										</label>
										<label class="ls-label col-md-6">
											<b class="ls-label-text ls-display-block ls-txt-left">Skype:</b>
											<input type="text" name="skype" value="<?= @$aluno->skype ?>" required >
										</label>
										<label class="ls-label col-md-6">
											<b class="ls-label-text ls-display-block ls-txt-left">Whatsapp:</b>
											<input type="text" name="whatsapp" value="<?= @$aluno->whatsapp ?>" required >
										</label>
										<label class="ls-label col-md-6">
											<b class="ls-label-text ls-display-block ls-txt-left">Facebook:</b>
											<input type="text" name="facebook" value="<?= @$aluno->facebook ?>" >
										</label>
									</div>
									<br>
									<br>
									<br>
									
									<h5 class="ls-title-5">Contrato</h5>
									<br>
									<div style="width:100%;height:300px;overflow-y:scroll; text-align:left;">
										<p>
											<b>CLÁUSULA PRIMEIRA:</b> Os serviços contratados compreendem o conjunto de atividades de programadas de acuerdo com o método desenvolvido pelo SITE para o ensino do espanhol,utilizando o método comunicativo.
										</p>
										<p>

										</p>
										<p>
											<b>ARTIGO SEGUNDO:</b> Os valores referentes  a hora-aula  serão reajustados de acordo  com o INIDICE  no mês de março , data dissídio da categoria dos profesores da definição do preço: o preço fixado levou em consideração a realidade econômica e financeira vigente na data da assinatura deste instrumento, considerados os custos gerais da escola, inclusive os salários dos funcionários, bem como a  inflação do período, tendo como base de atualização o IGP-M da Fundação Getúlio Vargas,  podendo ser   reajustado sempre que ocorrer dissídios salariais da categoria, bem como na reposição da inflação verificada no período, nas prestações futuras, quando e se houver um incremento de 10%(dez por cento) ou mais no índice acumulado. 
										</p>
										<p>
											<b>CLÁUSULA SEGUNDA:</b>  O CONTRATANTE participará das atividades de ensino , de acordo com horário de funcionamento  e condições oferecidas pela CONTRATADA, sendo esta a responsável pela preparação de sua programação quanto à freqüência e carga horária, o que estará diretamente relacionado com a carga horária acordada e o curso contratado.
										</p>  
										<p>
											<b>PÁGRAFO  PRIMEIRO :</b>  So terão dereito a reposição, as  horas canceladas com  24 horas de antecedecia, ao horário combinado. No caso de tempestade  o corte geral  de energia elétrica pode ser uma escpcao caso não conseguir fazer aulas por vias alternativas.  Fica por conta do aluno ter garantida a sua parte para boas  condições da aual, como  boa sinal de internet , computador, espaço comfortavel,  matérias,  phones de ouvido, e  microphone.
										</p>
									</div>
									<br>
									<label class="ls-label-text">
										<input type="checkbox" name="aceito" id="aceito" value="1">
										Li e aceito TODOS os termos.<br><small>Ao assinalar este campo me comprometo com todo o contrato.</small>
									</label>
									<input type="hidden" name="id" value="<?= @$aluno->id ?>">
									<button type="submit" disabled class="ls-btn-success ls-btn-block">AVANÇAR</button>
								</fieldset>
							</form>
						<?php else: ?>
							<cite>Nenhum registro encontrado</cite>
						<?php endif; ?>
					</div>
					<div class="step2 ls-display-none ls-box">
						<h5 class="ls-title-5">Como deseja pagar?</h5>
						<br>
						<br>
						<div class="col-md-6">
							<a href="<?= site_url('aluno/pagseguro') ?>"><img src="<?= base_url('assets/images/pagseguro.jpg') ?>" alt="" class="img-responsive"></a>
						</div>
						<div class="col-md-6">
							<a href="<?= site_url('aluno/paypal') ?>"><img src="<?= base_url('assets/images/paypal.png') ?>" alt="" class="img-responsive"></a>
						</div>
					</div>
				</div>
				<div class="ls-clearfix"></div>
				<br>
				<br>
			</div>
		</div>
	</div>		
	
	<!-- We recommended use jQuery 1.10 or up -->
	<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="<?= base_url('assets') ?>/javascripts/locastyle.js" type="text/javascript"></script>
	<script src="<?= base_url('assets') ?>/javascripts/plugins.js" type="text/javascript"></script>
	<script>
		$(function(){
			$("#aceito").on('click',function(){
				if($(this).is(':checked')){
					$('button').removeAttr('disabled');
				}else{
					$('button').attr('disabled','disabled');
				}
			});

			$("#dados").submit(function(e){
				var dados = $(this).serialize();
				//console.log(dados);

				$.ajax({
					type:"POST",
					url: '<?= site_url('aluno/salvar') ?>',
					data: dados,
					success:function(data){
						$(".step1").addClass('ls-display-none');
						$(".step2").removeClass("ls-display-none");
					}
				})

				e.preventDefault();

			})
		})
	</script>
</body>
</html>