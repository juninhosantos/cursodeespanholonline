<?php

class MY_Controller extends CI_Controller{

    protected function defaultVars(){
        return array(
            'usuario' => $this->session->userdata('admin')->nome,
		    'voltar'  => "javascript:void(0)"
        );
    }

}