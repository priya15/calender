<?php

Class Admin_Database extends CI_Model {
   

  

   public function delete_event($Id){
    return $data = $this->db->where("id",$Id)->delete("event");

   }

    public function update($Id){
    return $data = $this->db->select("*")->from("user")->where("id",$Id)->get()->result_array();

   }


   public function updateevent($id,$data){
    $this->db->where('id', $id);
    return $data = $this->db->update('event',$data);
   }

  

  
}