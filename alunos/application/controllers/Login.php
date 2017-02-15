<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{
    
    private $data;

    public function index(){
        $this->data = array(
            "titulo" => "Dashboard",
            "action" => site_url('login/autenticar'),
            "logo"   => base_url('assets/images/logo.svg'),
            "notify" => $this->session->flashdata('notify')
        );

        $this->parser->parse("login",$this->data);
        
    }

    public function autenticar(){
        $this->load->model("LoginModel","login");

        if(!$this->login->autenticando()){

            $this->load->library("notify");
            $this->notify->config(array("type"=>"error","titulo"=>"Ops...","mensagem"=>"Login e/ou senha inválido(s)"));
            $this->notify->sessionOutput();
            
            redirect(site_url('login'));

        }

        redirect(site_url(''));

    }

    public function logout(){
        $this->session->sess_destroy();
        redirect(site_url(''));
    }

}