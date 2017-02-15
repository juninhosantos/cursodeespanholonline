<?php

class Admin extends MY_Controller{
    public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('admin')){
			redirect(site_url('login'));
		}

	}

    public function index(){
        $data = $this->defaultVars();
        $data['content'] = $this->parser->parse("content/home",array(),true);
        $this->parser->parse("default",$data);
    }
}