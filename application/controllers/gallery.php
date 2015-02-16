<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

session_start();
class Gallery extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library('pagination');
		$this -> load -> model("gallery_model");
		if (!$this -> session -> userdata('logged_in')) {redirect('login', 'refresh');
		}

	}

	private function getSession() {
		//vračanje podataka iz session-a
		$session_data = $this -> session -> userdata('logged_in');
		$session = array('username' => $session_data['username'], 'id' => $session_data['id']);
		return $session;
	}

	public function view() {
		//pregled svih postova
		$config["base_url"] = base_url() . "gallery/view";
		$config["total_rows"] = $this -> gallery_model -> total();
		$config['per_page'] = 2;
		$config['uri_segment'] = 3;
		$config['num_links'] = 2;
		$this -> pagination -> initialize($config);
		$page = ($this -> uri -> segment(3)) ? $this -> uri -> segment(3) : 0;
		if($this -> uri -> segment(4)){$tag=$this -> uri -> segment(4);}else{$tag='';}
		$data['item'] = $this -> gallery_model -> getAll($config["per_page"], $page, $tag);
		$data['links'] = $this -> pagination -> create_links();
		$data['session'] = $this->getSession();
		var_dump($data);
		//$this -> load -> view('private/gallery', $data);
	}
}
