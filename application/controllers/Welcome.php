<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
$this->load->model('welcome_database');
$this->load->helper("url");
}


	public function index()
	{
		$this->load->view('header');
		$this->load->view("index");
		//$this->load->view("footer");
	}


   public function login()
	{
	    $this->load->view('header');
		$this->load->view("login");	
	}


	public function logindata(){
		$email    = $this->input->post("email");
		$password = md5($this->input->post("password"));

		$userdata = $this->welcome_database->checkusernamedata($email,$password);
		if ($userdata == 0) {
		  
		   $this->session->set_flashdata("error","data not added");
		   redirect("login");
		}
		else
		{
			$userid = $userdata[0]["id"];
			$role   = $userdata[0]["role"];
			$this->session->set_userdata("userid",$userid);
			$this->session->set_userdata("role",$role);

			$this->session->set_flashdata("suuccess","data added");
			if($role == 0){
              	redirect("admin/addevent");
			}
			else
			{
			   redirect("dash");
			}
		

		}

	}



	public function logout(){
		$this->session->unset_userdata("userid");
		$this->session->sess_destroy();
		redirect("login");
	}
    }
