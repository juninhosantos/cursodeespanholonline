<?php

class MY_Model extends CI_Model{
    
    private $total;

    public function get($args=array()){
        
        $this->db->from($this->table);

        $args['fields'] = isset($args['fields']) ? $args['fields'] : '*';
        $this->db->select($args['fields']);

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

    public function total(){
        return $this->total;
    }

    public function insert($args){
        if($this->db->insert($this->table,$args)){
            return $this->db->insert_id();
        }

        return false;
    }

    public function update($args,$where){
        $this->db->where($where);

        if($this->db->update($this->table,$args)){
            return true;
        }

        return $this->db->error();
    }

    public function delete($id,$field="id"){
        $this->db->where($field,$id);
        if($this->db->delete($this->table)){
            return true;
        }

        return false;
    }


}