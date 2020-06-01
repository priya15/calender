<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() {
        parent::__construct();

        // Load form helper library
        $this->load->helper('form');

        // Load form validation library
        $this->load->library('form_validation');

        // Load session library
        $this->load->library('session');

        // Load database
        $this->load->model('admin_database');
        $this->load->helper("url");
    }


	public function index()
	{
		$this->load->view('header');
		$this->load->view("index");
		//$this->load->view("footer");
	}




	public function update($id){
	   $id = base64_decode($id);
         $data = $this->admin_database->update($id);
         $user["userdata"]=$data;
	     if($data != ""){
	     	$this->load->view("header");
           $this->load->view("admin/edit",$user);
	     }
	     else
	     {
	     	redirect("welcome/adash");
	     }	
	}

    public function addevent(){
    	 $data['result'] = $this->db->get("event")->result();
         if(!empty($data["result"])){
        foreach ($data['result'] as $key => $value) {
            $data['data'][$key]['title'] = $value->title;
            $data['data'][$key]['id'] = $value->id;
            $data['data'][$key]['start'] = $value->s_datetime;
            $data['data'][$key]['end'] = $value->e_datetime;
            $data['data'][$key]['backgroundColor'] = "#00a65a";
        }
        }
        else
        {
        	$data["result"]="";
        }

        $this->load->view("header");
     	$this->load->view("admin/addevent",$data);

    }

    public function addeventdata(){
    	$title = $this->input->post("title");
    	$sdate = $this->input->post("sdate");
    	$edate = $this->input->post("edate");
    	$s_date = date("Y-m-d h:m:s", strtotime($sdate));
        $e_date = date("Y-m-d h:m:s", strtotime($edate));
        $data  = array("title"=>$title,"s_datetime"=>$s_date,"e_datetime"=>$e_date);
        $this->db->insert("event",$data);
       
        $datae["result"]= $this->db->get("event")->result();

        foreach ($datae['result'] as $key => $value) {
            $datae['data'][$key]['title'] = $value->title;
           $datae['data'][$key]['id'] = $value->id;

            $datae['data'][$key]['start'] = $value->s_datetime;
            $datae['data'][$key]['end'] = $value->e_datetime;
            $datae['data'][$key]['backgroundColor'] = "#00a65a";
        }
               echo json_encode($datae["data"]);
    }


    public function updateeventdata(){
        $title = $this->input->post("title");
        $sdate = $this->input->post("sdate");
        $edate = $this->input->post("edate");
        $id    = $this->input->post("id");

        $s_date = date("Y-m-d h:m:s", strtotime($sdate));
        $e_date = date("Y-m-d h:m:s", strtotime($edate));
        $data  = array("title"=>$title,"s_datetime"=>$s_date,"e_datetime"=>$e_date);



        $checks = $this->admin_database->updateevent($id,$data);
        if($checks == 1){
                 $datae["result"]= $this->db->get("event")->result();

        foreach ($datae['result'] as $key => $value) {
            $datae['data'][$key]['title'] = $value->title;
           $datae['data'][$key]['id'] = $value->id;

            $datae['data'][$key]['start'] = $value->s_datetime;
            $datae['data'][$key]['end'] = $value->e_datetime;
            $datae['data'][$key]['backgroundColor'] = "#00a65a";
        }
               echo json_encode($datae["data"]);
            
        } 
    }


    public function delete_event(){
    	$id = $this->input->post("id");
    	$data = $this->admin_database->delete_event($id);
        if($data==1){
            echo 1;
        }
        else
        {
            echo 0;
        }
    }

	public function edit(){
     $username = $this->input->post("username");
     $email    = $this->input->post("email");
     $password = $this->input->post("password");
     $id       = $this->input->post("id");
	}


	public function logout(){
		$this->session->unset_userdata("userid");
		$this->session->sess_destroy();
		redirect("login");
	}
    }
