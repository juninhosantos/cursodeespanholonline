<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slides extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('admin')){
			redirect(site_url('login'));
		}

        $this->load->model('slidesmodel','slides');
	}

    public function index(){
        $_lingua = array("br" => "Português","es" => "Espanhol","en"=>"Inglês");

        $lingua = "br";

        if(isset($_GET['lang'])){
            $lingua = $_GET['lang'];
        }
        
        $data = $this->defaultVars();
        $result = $this->slides->get(array('where'=>'lang="'.$lingua.'"','order'=>"ordem ASC"));
        $html = "";

        if($result){        
            foreach($result as $r){
                $html .= '<li id="image-'.$r->id.'" class="col-md-3">';
                $html .= '<img src="'.base_url('arquivos/'.$r->imagem).'" alt="" class="img-responsive img-thumbnail">';
                $html .= '<input type="hidden" name="slides[]" value="'.$r->id.'">';
                $html .= '<button data-id="'.$r->id.'" class="ls-btn-primary-danger delete-image"><i class="ls-ico-remove"></i></button>';
                $html .= '</li>';
                //$html .= '<li class="col-md-3"><img src="'..'" alt="" class="img-responsive img-thumbnail"/><input type="hidden" name="slides[]" value="'.$r->id.'"/></li>';
            }
        }

        $content = array("lingua"=>$_lingua[$lingua],"items"=>$html);
        $data['content'] = $this->parser->parse('content/slides/list',$content,true);

        $this->parser->parse('default',$data);

    }

    public function reorder($lang){
        $order = $this->input->post('slides');

        foreach($order  as $pos=>$id){

            $this->slides->update(array('ordem'=>$pos),"id = ".$id);
        }
    }

    public function salvarFoto($lang){
        if($this->slides->insert(array('imagem'=>$this->input->post('foto'),'lang'=>$lang))){
            echo "1";
        }else{
            echo "0";
        }
    }

    public function removeImagem(){

        $id = $this->input->post('id');
        if($this->slides->delete($id)){
            echo "1";
        }else{
            echo "0";
        }
    }
}