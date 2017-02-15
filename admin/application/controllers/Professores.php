<?php

class Professores extends MY_Controller{
    public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('admin')){
			redirect(site_url('login'));
		}

        $this->load->model("professoresmodel",'prof');

	}

    public function index(){
        $data = $this->defaultVars();      

        $content = array();
        $content['btnNovo'] = site_url('professores/novo');
        $content['professores'] = $this->prof->get(array('where'=>'ativo != 2'));

        $data['content'] = $this->load->view('content/professores/list',$content,true);
        $this->parser->parse("default",$data);
    }

    public function novo(){
        $data = $this->defaultVars();

        $this->load->model("PaginasModel","cursos");

        $content = array();
        $content['tituloPage'] = "Novo Professor";
        $content['action'] = site_url("professores/salvar");
        $data['content'] = $this->load->view('content/professores/form',$content,true);
        $this->parser->parse("default",$data);
    }

    public function salvar(){
        $nome = $this->input->post('nome');
        $email = $this->input->post('email');
        
        $senha = $this->gerarSenha();

        $id = $this->prof->insert(array('nome'=>$nome,'email'=>$email,'senha'=>$senha,'ativo'=>0));

        if($id){
           
            $this->load->library('email'); 

            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'br20.hostgator.com.br',
                'smtp_crypto' => 'ssl',
                'smtp_port' => 465,
                'smtp_user' => 'noreply@cursodeespanholonline.com',
                'smtp_pass' => 'pafrente17',
                'mailtype'  => 'html', 
                'charset' => 'utf-8',
                'wordwrap' => TRUE
                );

            $this->email->initialize($config);
            $this->email->set_mailtype("html");
            $this->email->set_newline("\r\n");
            $this->email->from('contato@cursosdeespanholonline.com', 'Cursos de Espanhol Online');

            $this->email->to(strtolower($email));
            $this->email->subject('Olá Professor, seja bem vindo(a) ao cursosdeespanholonline.com');
            $template = $this->load->view("template/mailProf",array("nome"=>$nome,"link"=>str_replace("admin","professor",base_url('cadastro/confirmacao'))),true);
            $this->email->message($template);

            /*if(!$this->email->send()){
                echo "deu erro";
            }*/

            $this->load->library("notify");
            $this->notify->config(array("type"=>"success","titulo"=>"Sucesso!","mensagem"=>"Cadastrado com sucesso. Um e-mail com login e senha foi enviado para o usuário."));
            $this->notify->sessionOutput();

            redirect(site_url('professores'));

        }

    }

    public function visualizar($id){
        $data = $this->defaultVars();

        $content = array();
        $content['tituloPage'] = "Info do Professor";
        $content['prof'] = $this->prof->get(array('where'=> 'id = '.$id));
        $data['content'] = $this->load->view('content/professores/edit',$content,true);
        $this->parser->parse("default",$data);
    }

    public function deletar($id){
        $this->prof->update(array("ativo"=>2),'id = '.$id);

        $this->load->library("notify");
        $this->notify->config(array("type"=>"success","titulo"=>"Sucesso!","mensagem"=>"Deletado com sucesso."));
        $this->notify->sessionOutput();

        redirect(site_url('professores'));

    }

    public function getCurso($id){
        $this->load->model("PaginasModel","cursos");
        $result = $this->cursos->get(array('where'=>"id = ".$id));
        
        echo json_encode($result);
    }

    private function gerarSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false){
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$%*-';
        $retorno = '';
        $caracteres = '';
        $caracteres .= $lmin;
        if ($maiusculas) $caracteres .= $lmai;
        if ($numeros) $caracteres .= $num;
        if ($simbolos) $caracteres .= $simb;
        $len = strlen($caracteres);
        for ($n = 1; $n <= $tamanho; $n++) {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand-1];
        }
        return $retorno;

    }
}