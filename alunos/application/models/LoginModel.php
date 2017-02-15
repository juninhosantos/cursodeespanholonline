<?php

class LoginModel extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    public function autenticando(){
        
        $login = $this->input->post('login');
        $senha = $this->input->post('senha');

        $this->db->select("nome, email,documento,telefone,skype,data_cadastro,ativo")
                 ->from("alunos")
                 ->where(array(
                     'email' => $login,
                     'senha' => $senha
                 ));

        $query = $this->db->get();

        if($query->num_rows() > 0){
            $this->session->set_userdata('aluno',$query->row());
            return $query->row();
        }

        return false;

    }

}