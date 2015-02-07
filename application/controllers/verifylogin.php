<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class VerifyLogin extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('user', '', TRUE);
	}
	
	function index() {
		//provjera unesenih podataka
		$this -> load -> library('form_validation');
		$data['username'] = $this -> input -> post('username');
		$this -> form_validation -> set_rules('username', 'Username', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
		$this -> form_validation -> set_message('required', 'Polje ne smije biti prazno!');
			
		if ($this -> form_validation -> run() == FALSE) {
			//podaci neispravni, vračanje na login
			$this -> load -> view('login', $data);
		} else {
			//uspjeh ulogiran si
			redirect('controlPanel', 'refresh');
		}
	}

	function check_database($password) {
		//provjera podudaranja baze i unesenih podataka
		$username = $this -> input -> post('username');
        
        //upit u bazu
		$result = $this -> user -> login($username, $password);

		if ($result) {
			//podaci ispravni postavljanje session-a
			$sess_array = array();
			foreach ($result as $row) {
				$sess_array = array('id' => $row -> id, 'username' => $row -> username);
				$this -> session -> set_userdata('logged_in', $sess_array);
			}
			return TRUE;
		} else {
			//podaci neispravni vračanje errora
			$this -> form_validation -> set_message('check_database', 'Neispravna kombinacija korisničkog imena i lozinke');
			return false;
		}
	}

}
