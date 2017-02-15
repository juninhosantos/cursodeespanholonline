<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cursos extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('admin')){
			redirect(site_url('login'));
		}

        $this->load->model('paginasmodel','paginas');
	}

    public function index(){
        
        $data = $this->defaultVars(); 

        $result = $this->paginas->get(array('where'=>'curso IS NOT NULL'));
        $html = "";
        
        foreach($result as $r){
            $rowAction['br'] = "<div class='row_actions'><a href='".site_url('cursos/editar/'.$r->id."/?lang=br")."' title='Editar esta página'><i class='ls-ico-edit-admin'></i></a></div>";
            $rowAction['es'] = "<div class='row_actions'><a href='".site_url('cursos/editar/'.$r->id."/?lang=es")."' title='Editar esta página'><i class='ls-ico-edit-admin'></i></a></div>";
            $rowAction['en'] = "<div class='row_actions'><a href='".site_url('cursos/editar/'.$r->id."/?lang=en")."' title='Editar esta página'><i class='ls-ico-edit-admin'></i></a></div>";

            $html .= "<tr><td>".$r->nome_br.$rowAction['br']."</td><td>".$r->nome.$rowAction['es']."</td><td>".$r->nome_en.$rowAction['en']."</td><td><a href='".site_url('cursos/excluir/'.$r->id)."' title='Excluir curso' class='delete'><i class='ls-ico-remove'></i></a></tr>";
        }
        
        $content = array('listPages' => $html,'icon_titulo' => "ls-ico-book",'titulo' => "Cursos",'btn_titulo' => "Adicionar novo curso","link_new"=>site_url('cursos/novo'));
        $data['content'] = $this->parser->parse("content/cursos/list",$content,true);

        $this->parser->parse("default",$data);
        
    }

    public function novo(){
        $data = $this->defaultVars();

        $content = array('icon_titulo' => "ls-ico-docs",'titulo' => "Novo Curso",'disabled' => "disabled","deletar" => "javascript:void(0)","action" => site_url('cursos/salvar'),'titulo_txt' => "",'texto_txt' => "","horas"=>"");

        $data['content'] = $this->parser->parse("content/cursos/form",$content,true);
        $this->parser->parse("default",$data);
    }

    public function salvar(){

        $titulo = $this->input->post('titulo');
        $texto = $this->input->post('texto');
        $lingua = $this->input->post('lang');
        $horas = $this->input->post('horas');

        $nome = $lingua == "es" ? "nome" : "nome_".$lingua;
        $conteudo = $lingua == "es" ? "conteudo" : "conteudo_".$lingua;
        $slug = $lingua == "es" ? "slug" : "slug_".$lingua;

        $this->load->library("notify");
        
        $id = $this->paginas->insert(array($nome =>$titulo,$conteudo => $texto, $slug => $this->slugfy($titulo), "status" => 1, "data" => date("Y-m-d"),'curso' => 1,"horas" => $horas));

        if($id){
            $this->notify->config(array("type"=>"success","titulo"=>"Sucesso!","mensagem"=>"Salvo com sucesso."));
            $this->notify->sessionOutput();

            redirect(site_url('cursos/editar/'.$id));
        }

        $this->notify->config(array("type"=>"error","titulo"=>"Ops...","mensagem"=>"Ocorreu algum erro, tente novamente mais tarde."));
        $this->notify->sessionOutput();
        redirect(site_url('cursos'));    
        
    }

    public function editar($id){
        
        $data = $this->defaultVars();
        
        $lingua = isset($_GET['lang']) ? $_GET['lang'] : 'br';

        $nome = $lingua == "es" ? "nome" : "nome_".$lingua;
        $conteudo = $lingua == "es" ? "conteudo" : "conteudo_".$lingua;
        $selected = "selected_".$lingua;

        $result = $this->paginas->get(array('fields'=>"id,horas,{$nome} as nome,{$conteudo} as conteudo",'where'=>"id = ".$id));

        $content = array('icon_titulo' => "ls-ico-docs",'titulo' => "Editar Curso",'disabled' => "","deletar" => site_url('cursos/excluir/'.$result[0]->id),"action" => site_url('cursos/atualizar/'.$result[0]->id),'titulo_txt' => $result[0]->nome,'texto_txt' => $result[0]->conteudo,$selected=>'selected',"horas"=>$result[0]->horas);
        $data['content'] = $this->parser->parse("content/cursos/form",$content,true);

        $this->parser->parse("default",$data);

    }

    public function atualizar($id){
        $titulo = $this->input->post('titulo');
        $texto = $this->input->post('texto');
        $lingua = $this->input->post('lang');
        $horas = $this->input->post('horas');

        $nome = $lingua == "es" ? "nome" : "nome_".$lingua;
        $conteudo = $lingua == "es" ? "conteudo" : "conteudo_".$lingua;
        $slug = $lingua == "es" ? "slug" : "slug_".$lingua;

        $this->load->library("notify");
        
        $args = array($nome =>$titulo,$conteudo => $texto, $slug => $this->slugfy($titulo),"horas"=>$horas);

        if($this->paginas->update($args,"id = ".$id)){
            $this->notify->config(array("type"=>"success","titulo"=>"Sucesso!","mensagem"=>"Atualizado com sucesso."));
            $this->notify->sessionOutput();

            redirect(site_url('cursos/editar/'.$id.'/?lang='.$lingua));
        }

        $this->notify->config(array("type"=>"error","titulo"=>"Ops...","mensagem"=>"Ocorreu algum erro, tente novamente mais tarde."));
        $this->notify->sessionOutput();
        redirect(site_url('cursos'));
        
    }

    public function excluir($id){

        $this->load->library("notify");

        if($this->paginas->delete($id)){
            $this->notify->config(array("type"=>"success","titulo"=>"Sucesso!","mensagem"=>"Deletado com sucesso."));
            $this->notify->sessionOutput();

            redirect(site_url('cursos'));
        }

        $this->notify->config(array("type"=>"error","titulo"=>"Ops...","mensagem"=>"Ocorreu algum erro, tente novamente mais tarde."));
        $this->notify->sessionOutput();
        redirect(site_url('cursos'));
    }



    private function slugfy($title) {

        $title = $this->removeAcentos($title);

        $title = strip_tags($title);
        // Preserve escaped octets.
        $title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
        // Remove percent signs that are not part of an octet.
        $title = str_replace('%', '', $title);
        // Restore octets.
        $title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);

        if ($this->seems_utf8($title)) {
            if (function_exists('mb_strtolower')) {
                $title = mb_strtolower($title, 'UTF-8');
            }
            $title = $this->utf8_uri_encode($title, 200);
        }

        $title = strtolower($title);
        $title = preg_replace('/&.+?;/', '', $title); // kill entities
        $title = str_replace('.', '-', $title);
        $title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
        $title = preg_replace('/\s+/', '-', $title);
        $title = preg_replace('|-+|', '-', $title);
        $title = trim($title, '-');

        return $title;
    }

    private function removeAcentos($string, $slug = false) {
        return preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $string));
    }

    private function seems_utf8($str) {
        $length = strlen($str);
        for ($i = 0; $i < $length; $i++) {
            $c = ord($str[$i]);
            if ($c < 0x80)
                $n = 0;# 0bbbbbbb
            elseif (($c & 0xE0) == 0xC0)
                $n = 1;# 110bbbbb
            elseif (($c & 0xF0) == 0xE0)
                $n = 2;# 1110bbbb
            elseif (($c & 0xF8) == 0xF0)
                $n = 3;# 11110bbb
            elseif (($c & 0xFC) == 0xF8)
                $n = 4;# 111110bb
            elseif (($c & 0xFE) == 0xFC)
                $n = 5;# 1111110b
            else
                return false;# Does not match any model
            for ($j = 0; $j < $n; $j++) { # n bytes matching 10bbbbbb follow ?
                if (( ++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
                    return false;
            }
        }
        return true;
    }

    private function utf8_uri_encode($utf8_string, $length = 0) {
        $unicode = '';
        $values = array();
        $num_octets = 1;
        $unicode_length = 0;

        $string_length = strlen($utf8_string);
        for ($i = 0; $i < $string_length; $i++) {

            $value = ord($utf8_string[$i]);

            if ($value < 128) {
                if ($length && ( $unicode_length >= $length ))
                    break;
                $unicode .= chr($value);
                $unicode_length++;
            } else {
                if (count($values) == 0)
                    $num_octets = ( $value < 224 ) ? 2 : 3;

                $values[] = $value;

                if ($length && ( $unicode_length + ($num_octets * 3) ) > $length)
                    break;
                if (count($values) == $num_octets) {
                    if ($num_octets == 3) {
                        $unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]) . '%' . dechex($values[2]);
                        $unicode_length += 9;
                    } else {
                        $unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]);
                        $unicode_length += 6;
                    }

                    $values = array();
                    $num_octets = 1;
                }
            }
        }

        return $unicode;
    }

}