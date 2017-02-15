<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Notify{

    private $type;
    private $titulo;
    private $mensagem;
    private $posicao;
    private $ci;

    public function __construct(){
        $this->ci =& get_instance();
        $this->ci->load->library('session');
    }

    public function config($args){

        $this->type = isset($args['type']) ? $args['type'] : "default";
        $this->titulo = isset($args['titulo']) ? $args['titulo'] : "";
        $this->mensagem = isset($args['mensagem']) ? $args['mensagem'] : "";
        $this->posicao = isset($args['posicao']) ? $args['posicao'] : "bottomRight";

    }

    public function output(){
        
        switch ($this->type) { 
            case "info" :
                return "<script>
                    iziToast.info({
                        title: '".$this->titulo."',
                        message: '".$this->mensagem."',
                        position: '".$this->posicao."',
                        timeout: 7000,
                    });
                </script>";
                break;
            case "success" :
                 return "<script>
                    iziToast.success({
                        title: '".$this->titulo."',
                        message: '".$this->mensagem."',
                        position: '".$this->posicao."',
                        timeout: 7000,
                    });
                </script>";
                break;
            case "warning" :
                 return "<script>
                    iziToast.warning({
                        title: '".$this->titulo."',
                        message: '".$this->mensagem."',
                        position: '".$this->posicao."',
                        timeout: 7000,
                    });
                </script>";
                break;
            case "error" :
                 return "<script>
                    iziToast.error({
                        title: '".$this->titulo."',
                        message: '".$this->mensagem."',
                        position: '".$this->posicao."',
                        timeout: 7000,
                    });
                </script>";
                break;
            default:
                 return "<script>
                    iziToast.show({
                        title: '".$this->titulo."',
                        message: '".$this->mensagem."',
                        position: '".$this->posicao."',
                        timeout: 7000,
                    });
                </script>";
                break;
        }
    }

    public function render(){
        echo $this->output();
    }

    public function sessionOutput(){
        

        $this->ci->session->set_flashdata('notify',$this->output());
        /*echo "<html><body>";
        echo ($this->output());
        echo "</body></html>";*/
    }

}