<?php

class Alunos extends MY_Controller{
    public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('admin')){
			redirect(site_url('login'));
		}

        $this->load->model("alunosmodel",'alunos');

	}

    public function index(){
        $data = $this->defaultVars();      

        $content = array();
        $content['btnNovo'] = site_url('alunos/novo');
        $content['alunos'] = $this->alunos->get(array('where'=>'ativo != 2'));

        $data['content'] = $this->load->view('content/alunos/list',$content,true);
        $this->parser->parse("default",$data);
    }

    public function novo(){
        $data = $this->defaultVars();

        $this->load->model("paginasmodel","cursos");

        $content = array();
        $content['tituloPage'] = "Novo Aluno";
        $content['action'] = site_url("alunos/salvar");
        $content['cursos'] = $this->cursos->get(array('where'=>"curso IS NOT NULL"));
        $data['content'] = $this->load->view('content/alunos/form',$content,true);
        $this->parser->parse("default",$data);
    }

    public function salvar(){
        $nome = $this->input->post('nome');
        $email = $this->input->post('email');
        $curso = $this->input->post('curso');
        $horas = $this->input->post('horas');
        $tipo = $this->input->post('tipo');
        $valor = str_replace(array('.',','),array('','.'),$this->input->post('valor'));
        $valor = number_format((float)$valor,2,".","");
        $senha = $this->gerarSenha();

        $id = $this->alunos->insert(array('nome'=>$nome,'email'=>$email,'senha'=>$senha,'ativo'=>0,"chave_ativacao"=>md5($email.$senha)));
        if($id){
            $this->load->model('pacotesmodel','pacotes');
            $this->pacotes->insert(array('curso'=>$curso,'valor'=>$valor,'horas'=>$horas,'tipo'=>$tipo,'aluno'=>$id,'valor_total'=>$valor*$horas));

            $this->load->library('email'); 

            $config = Array(
                'protocol' => 'mail',
                'smtp_host' => 'br20.hostgator.com.br',
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
            $this->email->subject('Bem vindo(a) ao cursosdeespanholonline.com');
            $template = $this->load->view("template/mailAluno",array("nome"=>$nome,"valor"=>($valor*$horas),"horas"=>$horas,"link"=>str_replace("admin","alunos",base_url('confirmacao/'.md5($email.$senha)))),true);
            $this->email->message($template);

            if(!$this->email->send()){
                echo "deu erro";
            }

            $this->load->library("notify");
            $this->notify->config(array("type"=>"success","titulo"=>"Sucesso!","mensagem"=>"Cadastrado com sucesso."));
            $this->notify->sessionOutput();

            redirect(site_url('alunos'));

        }

    }

    public function editar($id){
        $data = $this->defaultVars();

        $this->load->model("paginasmodel","cursos");
        $this->load->model("pacotesmodel","pacotes");

        $content = array();
        $content['tituloPage'] = "Info do Aluno";
        $content['action'] = site_url("alunos/atualizar");
        $aluno = $this->alunos->get(array('where'=>'id = '.$id));
        $aluno = $aluno[0];
        $pacote = $this->pacotes->get(array('where'=>'aluno = '.$id,'limit'=>3,'order'=>'codigo DESC'));
        $aluno->pacote = $pacote;

        $content['aluno'] = $aluno;

        $content['cursos'] = $this->cursos->get(array('where'=>"curso IS NOT NULL"));
        
        $data['content'] = $this->load->view('content/alunos/edit',$content,true);
        $this->parser->parse("default",$data);

    }

    public function deletar($id){
        $this->alunos->update(array("ativo"=>2),'id = '.$id);

        $this->load->library("notify");
        $this->notify->config(array("type"=>"success","titulo"=>"Sucesso!","mensagem"=>"Deletado com sucesso."));
        $this->notify->sessionOutput();

        redirect(site_url('alunos'));

    }

    public function getCurso($id){
        $this->load->model("paginasmodel","cursos");
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