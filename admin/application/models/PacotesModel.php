<?php

class PacotesModel extends MY_Model{
    
    protected $table = "pacotes";

    public function __construct(){
        parent::__construct();
    }

    public function get($args=array()){
        
        $this->db->from($this->table);

        $args['fields'] = isset($args['fields']) ? $args['fields'] : '*';
        $this->db->select($args['fields']);
        $this->db->select("
            CASE curso
                WHEN 0 THEN 'Personalizado'
                ELSE (SELECT nome_br FROM paginas WHERE pacotes.curso = paginas.id)
            END as 'curso',
            CASE ativo
                WHEN 0 THEN 'Pendente'
                WHEN 1 THEN 'Ativo'
                WHEN 2 THEN 'Cancelado'
                ELSE NULL
            END as 'ativo'   
        ");        

        //$this->db->select("(SELECT nome_br FROM paginas WHERE pacotes.curso = paginas.id) curso")

        $args['where'] = isset($args['where']) ? $args['where'] : '1=1';
        $this->db->where($args['where']);

        if(isset($args['order'])){
            $this->db->order_by($args['order']);
        }

        $this->total = $this->db->query("SELECT count(*) FROM {$this->table} WHERE ".$args['where'])->num_rows();

        if(isset($args['limit'])){
            $this->db->limit($args['limit']);
        }

        $query = $this->db->get();

        if($query->num_rows() > 0){
            
            return $query->result();
        }

        return false;
    }

}