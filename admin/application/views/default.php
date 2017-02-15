<!DOCTYPE html>
<html class="ls-theme-light-red">
<head>
	<title>Dashboard</title>
	<meta charset="utf-8">
	<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="description" content="Insira aqui a descrição da página.">
	<link href="http://assets.locaweb.com.br/locastyle/3.10.0/stylesheets/locastyle.css" rel="stylesheet" type="text/css">
	<link rel="icon" sizes="192x192" href="/locawebstyle/assets/images/ico-boilerplate.png">
	<link rel="apple-touch-icon" href="/locawebstyle/assets/images/ico-boilerplate.png">
	<link rel="stylesheet" href="<?= base_url('assets/stylesheets/plugins.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/stylesheets/main.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/javascripts/uploadify/uploadify.css') ?>">
</head>
<body>
	<?php $this->load->view('includes/header') ?>

	<?php $this->load->view('includes/sidebar') ?>

	<main class="ls-main ">
		<div class="container-fluid">
			{content}
		</div>
	</main>

	
	<?php $this->load->view('includes/footer') ?>
	<div id="site_url" class="ls-display-none"><?php echo uri_string(); ?></div>
	<div id="base_url" class="ls-display-none"><?php echo base_url() ?></div>
	<?php
	if($this->session->flashdata('notify')){
		echo $this->session->flashdata('notify');
	}
	?>
</body>
</html>