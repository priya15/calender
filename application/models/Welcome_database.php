<?php

Class Welcome_Database extends CI_Model {
   

   public function checkusername($username,$email,$password){
  $data =  	$this->db->select("*")->from("user")->where("email",$email)->get()->result_array();
   if(!empty($data)){
    return 1;
   }
   else
   {
     return 0;
   }
   }

   public function checkusernamedata($email,$password){
  $data =  	$this->db->select("*")->from("user")->where("email",$email)->where("password",$password)->get()->result_array();
   if(!empty($data)){
    return $data;
   }
   else
   {
     return 0;
   }
   }

   public function delete($Id){
    return $data = $this->db->where("id",$Id)->delete("user");

   }

   public function alluserlist(){
    $data = $this->db->select("*")->from("user")->where("role","1")->get()->result_array();
    return $data;
   }
}