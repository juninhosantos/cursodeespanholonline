<?php

class MY_Controller extends CI_Controller{

    protected function defaultVars(){
        return array(
            'usuario' => $this->session->userdata('aluno')->nome,
		    'voltar'  => "javascript:void(0)"
        );
    }

}