<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct() {
		parent::__construct();
	}
	public function view($page='naslovna') {
		if (!file_exists(APPPATH . '/views/' . $page . '.php')) {
			show_404();
		}
		$data = array('str' => $page, 'naslov' => ucfirst($page));
		$this -> load -> view($page, $data);

	}
}
