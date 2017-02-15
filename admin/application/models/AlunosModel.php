<?php

class AlunosModel extends MY_Model{
    
    protected $table = "alunos";

    public function __construct(){
        parent::__construct();
    }

    public function get($args=array()){
        
        $this->db->from($this->table);

        $args['fields'] = isset($args['fields']) ? $args['fields'] : '*';
        $this->db->select($args['fields']);
        $this->db->select("
            CASE ativo
                WHEN 0 THEN 'Pendente'
                WHEN 1 THEN 'Ativo'
                ELSE NULL
            END as 'status'   
        ");

        $this->db->select("DATE_FORMAT(data_cadastro,'%d/%m/%Y') AS data");

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