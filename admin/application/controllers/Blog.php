<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('admin')){
			redirect(site_url('login'));
		}

        $this->load->model('blogmodel','blog');
	}

    public function index(){
        
        $data = $this->defaultVars(); 

        $result = $this->blog->get(array('fields'=>'posts.*,(SELECT count(*) FROM comentario WHERE post = posts.id) comentarios'));
        $html = "";
        
        foreach($result as $r){
            $status = strtotime($r->data) <= strtotime(date("Y-m-d")) ? 'Publicado' : 'Agendado';

            $html .= "<tr><td>".$r->nome."</td><td>".date("d/m/Y",strtotime($r->data))."</td><td>".$status."</td><td><a href='".site_url('blog/comentarios/'.$r->id)."'>".$r->comentarios." comentário(s)</a></td><td><a href='".site_url('blog/editar/'.$r->id."/")."' title='Editar'><i class='ls-ico-edit-admin'></i></a>&nbsp;&nbsp;&nbsp;<a href='".site_url('blog/excluir/'.$r->id)."' title='Excluir' class='delete'><i class='ls-ico-remove'></i></a></td></tr>";
        }
        
        $content = array('listPages' => $html,'icon_titulo' => "ls-ico-book",'titulo' => "Blog",'btn_titulo' => "Adicionar post","link_new"=>site_url('blog/novo'));
        $data['content'] = $this->parser->parse("content/blog/list",$content,true);

        $this->parser->parse("default",$data);
        
    }

    public function novo(){
        $data = $this->defaultVars();

        $content = array('icon_titulo' => "ls-ico-text",'titulo' => "Novo Post",'disabled' => "disabled","deletar" => "javascript:void(0)","action" => site_url('blog/salvar'),'titulo_txt' => "",'texto_txt' => "","data"=>"","imagem"=> "","imgClass"=>"ls-display-none","data"=>date("d/m/Y"));

        $data['content'] = $this->parser->parse("content/blog/form",$content,true);
        $this->parser->parse("default",$data);
    }

    public function salvar(){

        $titulo = $this->input->post('titulo');
        $texto = $this->input->post('texto');
        $data = $this->input->post('data');
        $data = implode("-",array_reverse(explode("/",$data)));
        $foto = $this->input->post('foto');
        
        $status = strtotime(date("Y-m-d")) > strtotime($data) ? 1 : 2;

        $this->load->library("notify");
        
        $id = $this->blog->insert(array("nome"=>$titulo,"conteudo" => $texto,"slug" => $this->slugfy($titulo), "status" => $status, "data" => $data,"imagem"=>$foto));

        if($id){
            $this->notify->config(array("type"=>"success","titulo"=>"Sucesso!","mensagem"=>"Salvo com sucesso."));
            $this->notify->sessionOutput();

            redirect(site_url('blog/editar/'.$id."/"));
        }

        $this->notify->config(array("type"=>"error","titulo"=>"Ops...","mensagem"=>"Ocorreu algum erro, tente novamente mais tarde."));
        $this->notify->sessionOutput();
        redirect(site_url('blog'));
        
    }

    public function editar($id){
        
        $data = $this->defaultVars();
        $imgClass = "ls-display-none";
        
        $result = $this->blog->get(array('fields'=>"id,imagem,data,nome,conteudo",'where'=>"id = ".$id));

        if($result[0]->imagem != ""){
            $imgClass = "";
        }

        $content = array('icon_titulo' => "ls-ico-docs",'titulo' => "Editar Post",'disabled' => "","deletar" => site_url('blog/excluir/'.$result[0]->id),"action" => site_url('blog/atualizar/'.$result[0]->id),'titulo_txt' => $result[0]->nome,'texto_txt' => $result[0]->conteudo,"imagem"=>base_url('arquivos/'.$result[0]->imagem),"imgClass"=>$imgClass,"data"=>date("d/m/Y",strtotime($result[0]->data)));
        $data['content'] = $this->parser->parse("content/blog/form",$content,true);

        $this->parser->parse("default",$data);

    }

    public function atualizar($id){
        $titulo = $this->input->post('titulo');
        $texto = $this->input->post('texto');
        $data = $this->input->post('data');
        $data = implode("-",array_reverse(explode("/",$data)));
        $foto = $this->input->post('foto');

        $status = strtotime(date("Y-m-d")) > strtotime($data) ? 1 : 2;

        $this->load->library("notify");
        
        $args = array("nome"=>$titulo,"conteudo" => $texto,"slug" => $this->slugfy($titulo), "status" => $status, "data" => $data,"imagem"=>$foto);

        if($this->blog->update($args,"id = ".$id)){
            $this->notify->config(array("type"=>"success","titulo"=>"Sucesso!","mensagem"=>"Atualizado com sucesso."));
            $this->notify->sessionOutput();

            redirect(site_url('blog/editar/'.$id.'/'));
        }

        $this->notify->config(array("type"=>"error","titulo"=>"Ops...","mensagem"=>"Ocorreu algum erro, tente novamente mais tarde."));
        $this->notify->sessionOutput();
        redirect(site_url('blog'));
        
    }

    public function excluir($id){

        $this->load->library("notify");

        if($this->blog->delete($id)){
            $this->notify->config(array("type"=>"success","titulo"=>"Sucesso!","mensagem"=>"Deletado com sucesso."));
            $this->notify->sessionOutput();

            redirect(site_url('blog'));
        }

        $this->notify->config(array("type"=>"error","titulo"=>"Ops...","mensagem"=>"Ocorreu algum erro, tente novamente mais tarde."));
        $this->notify->sessionOutput();
        redirect(site_url('blog'));
    }

    public function comentarios($post){
        $this->load->model("comentariomodel","comentario");

        $data = $this->defaultVars(); 

        $_post = $this->blog->get(array('where'=> "id = ".$post));

        $result = $this->comentario->get(array('where'=> "post = ".$post));

        $html = "";
        if($result){
            foreach($result as $r){

                $html .= "<div class='ls-box ls-sm-space'>";
                $html .= "<h5 class='ls-title-5'>".$r->nome."</h5>";
                $html .= "<p>".$r->comentario."</p><br>";
                if($r->moderacao == 0){
                    $html .= '<p><a href="'.site_url('blog/excluirComentario/'.$r->codigo.'/'.$_post[0]->id).'" class="ls-btn" style="color:red">Deletar</a> &nbsp;&nbsp;&nbsp;&nbsp; <a href="'.site_url('blog/aprovarComentario/'.$r->codigo.'/'.$_post[0]->id).'" class="ls-btn" style="color:green">Aprovar</a></p>';
                }else{
                    $html .= '<p><a href="'.site_url('blog/excluirComentario/'.$r->codigo.'/'.$_post[0]->id).'" class="ls-btn" style="color:red">Deletar</a> &nbsp;&nbsp;&nbsp;&nbsp; <a href="#" class="ls-btn" disabled style="color:green">Aprovado</a></p>';
                }
                
                $html .= "</div>";
            }
        }else{
            $html = "<br><br><i>Nenhum comentário encontrado</i>";
        }
        
        $content = array('icon_titulo' => "",'titulo' => "Comentários","delComentario" => site_url('blog/excluirComentario/'.@$result[0]->codigo),'subtitulo' => @$_post[0]->nome,'comentarios' => $html,"voltar"=>site_url("blog"));
        $data['content'] = $this->parser->parse("content/blog/comentario",$content,true);

        $this->parser->parse("default",$data);
    }

    public function aprovarComentario($id,$post){
        $this->load->model("comentariomodel","comentario");
        $this->load->library("notify");
        

        if($this->comentario->update(array('moderacao'=>1),"codigo = ".$id)){
            $this->notify->config(array("type"=>"success","titulo"=>"Sucesso!","mensagem"=>"Atualizado com sucesso."));
            $this->notify->sessionOutput();

            redirect(site_url('blog/comentarios/'.$post.'/'));
        }

        $this->notify->config(array("type"=>"error","titulo"=>"Ops...","mensagem"=>"Ocorreu algum erro, tente novamente mais tarde."));
        $this->notify->sessionOutput();
        redirect(site_url('blog'));
    }

    public function excluirComentario($id,$post){
        $this->load->model("comentariomodel","comentario");
        $this->load->library("notify");

        if($this->comentario->delete($id,"codigo")){
            $this->notify->config(array("type"=>"success","titulo"=>"Sucesso!","mensagem"=>"Deletado com sucesso."));
            $this->notify->sessionOutput();

            redirect(site_url('blog/comentarios/'.$post));
        }

        $this->notify->config(array("type"=>"error","titulo"=>"Ops...","mensagem"=>"Ocorreu algum erro, tente novamente mais tarde."));
        $this->notify->sessionOutput();
        redirect(site_url('blog'));
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