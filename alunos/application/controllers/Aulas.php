<?php

class Aulas extends MY_Controller{
    public function __construct(){
		parent::__construct();
        if(!$this->session->userdata('aluno')){
			redirect(site_url('login'));
		}
	}

    public function index(){
        $this->load->model('PacotesModel','pacotes');
        $curso = $this->pacotes->get(array('where'=>'aluno = "'.$this->session->aluno->id.'"'));
        $data['content'] = $this->load->view('content/aula/index',array('curso'=>$curso[0]->curso),true);
        $this->parser->parse("default",$data);
    }

   
}