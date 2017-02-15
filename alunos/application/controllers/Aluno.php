<?php

class Aluno extends MY_Controller{
    public function __construct(){
		parent::__construct();
	}

    public function index(){
        
        if(!$this->session->userdata('aluno')){
			redirect(site_url('login'));
		}
        $data['content'] = $this->load->view('content/home',array(),true);
        $this->parser->parse("default",$data);
    }

    public function confirmacao($confirmacao=""){
        $this->load->model('AlunosModel','alunos');
        $aluno = $this->alunos->get(array('where'=> "chave_ativacao = '".$confirmacao."'"));
        $aluno = $aluno[0];

        $this->load->view('confirmacao',array('confirm'=>$confirmacao,"aluno"=>$aluno));
    }

    public function salvar(){
        $this->load->model('AlunosModel','alunos');
        
        $id = $_POST['id'];
        $aceito = isset($_POST['aceito']) ? $_POST['aceito'] : '';
        unset($_POST['id']);
        unset($_POST['aceito']);

        
        if($aceito){            
            $_POST['chave_ativacao'] = "";
            //$this->alunos->update($_POST,'id = '.$id);
            $aluno = $this->alunos->getWithCurso(array('where'=> "id = '".$id."'"));

            $this->session->set_userdata('dataAluno',$aluno);

        }
    }

    public function pagseguro(){
        $this->load->model('PacotesModel','pacotes');

        $aluno = $this->session->userdata('dataAluno');

        $ref = "CURSOONLINE".base64_encode(rand(1,999999));

        $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/checkout';

        $data['email'] = 'famontis@gmail.com';
        $data['token'] = '504946394E834B328AB5415B8EFA4C5D'; //'E4A5BF00A94E48BD95412EE17C8FB72C';
        $data['currency'] = 'BRL';
        $data['itemId1'] = '0001';
        $data['itemDescription1'] = utf8_decode($aluno[0]->curso);
        $data['itemAmount1'] = number_format($aluno[0]->valor_curso,2,".","");
        $data['itemQuantity1'] = '1';
        $data['itemWeight1'] = '1000';
        $data['reference'] = $ref;
        $data['senderName'] = $aluno[0]->nome;
        $data['senderAreaCode'] = '11';
        $data['senderPhone'] = '56273440';
        $data['senderEmail'] = "c06816726500366555938@sandbox.pagseguro.com.br";//$_POST['email'];
        $data['shippingType'] = '1';
        $data['shippingAddressStreet'] = 'Av. Brig. Faria Lima';
        $data['shippingAddressNumber'] = '1384';
        $data['shippingAddressComplement'] = '5o andar';
        $data['shippingAddressDistrict'] = 'Jardim Paulistano';
        $data['shippingAddressPostalCode'] = '01452002';
        $data['shippingAddressCity'] = 'Sao Paulo';
        $data['shippingAddressState'] = 'SP';
        $data['shippingAddressCountry'] = 'BRA';
        $data['redirectURL'] = site_url('login');

        $data = http_build_query($data);

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $xml= curl_exec($curl);

        if($xml == 'Unauthorized'){
        //Insira seu código de prevenção a erros

        //header('Location: erro.php?tipo=autenticacao');
        exit;//Mantenha essa linha
        }
        curl_close($curl);

        $xml= simplexml_load_string($xml);
        if(count($xml -> error) > 0){
        //Insira seu código de tratamento de erro, talvez seja útil enviar os códigos de erros.

        //header('Location: erro.php?tipo=dadosInvalidos');
        exit;
        }

        $this->pacotes->update(array('referencia'=>$ref),'aluno = '.$aluno[0]->id);
        header('Location: https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html?code=' . $xml -> code);
    }
    
    public function paypal(){
        $this->load->model('PacotesModel','pacotes');

        $aluno = $this->session->userdata('dataAluno');

        $ref = "CURSOONLINE".base64_encode(rand(1,999999));

        $nvp = array(
            'PAYMENTREQUEST_0_AMT'				=> $total,
            'PAYMENTREQUEST_0_CURRENCYCODE'		 => 'BRL',
            'PAYMENTREQUEST_0_PAYMENTACTION'	 => 'Sale',
            'RETURNURL'							=> 'http://127.0.0.1/paypal/retorno.php',
            'CANCELURL'							=> 'http://127.0.0.1/paypal/cancelamento.php',
            'METHOD'							=> 'SetExpressCheckout',
            'VERSION'							=> '84',
            'PWD'								=> 'xxxx',
            'USER'								=> 'vendedor@dominio.com',
            'SIGNATURE'							=> 'ASSINATURA'
        );
        $curl = curl_init();
        curl_setopt( $curl , CURLOPT_URL , 'https://api-3t.paypal.com/nvp' ); //Link para ambiente de teste: https://api-3t.sandbox.paypal.com/nvp
        curl_setopt( $curl , CURLOPT_SSL_VERIFYPEER , false );
        curl_setopt( $curl , CURLOPT_RETURNTRANSFER , 1 );
        curl_setopt( $curl , CURLOPT_POST , 1 );
        curl_setopt( $curl , CURLOPT_POSTFIELDS , http_build_query( $nvp ) );
        $response = urldecode( curl_exec( $curl ) );
        curl_close( $curl );
        $responseNvp = array();
        if ( preg_match_all( '/(?<name>[^\=]+)\=(?<value>[^&]+)&?/' , $response , $matches ) ) {
            foreach ( $matches[ 'name' ] as $offset => $name ) {
                $responseNvp[ $name ] = $matches[ 'value' ][ $offset ];
            }
        }
        if ( isset( $responseNvp[ 'ACK' ] ) && $responseNvp[ 'ACK' ] == 'Success' ) {
            $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
            $query = array(
                'cmd'	=> '_express-checkout',
                'token'	=> $responseNvp[ 'TOKEN' ]
            );
            header( 'Location: ' . $paypalURL . '?' . http_build_query( $query ) );
        } else {
            echo 'Falha na transação';
        }

        $this->pacotes->update(array('referencia'=>$ref),'aluno = '.$aluno[0]->id);
        header('Location: https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html?code=' . $xml -> code);
    }

    private function sendmail($aluno){
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

        $this->email->to(strtolower($aluno->email));
        $this->email->subject('Bem vindo(a) ao cursosdeespanholonline.com');
        $template = $this->load->view("template/mailAluno2",array("nome"=>$aluno->nome,"senha"=>$aluno[0]->senha,"link"=>site_url('login')),true);
        $this->email->message($template);

        if(!$this->email->send()){
            echo "deu erro";
            exit();
        }
    }

   
}