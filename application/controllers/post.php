<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
session_start();
class Post extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library('pagination');
		$this -> load -> model("post_model");
	}

	private function getSession() {
		//vračanje podataka iz session-a
		$session_data = $this -> session -> userdata('logged_in');
		$session = array('username' => $session_data['username'], 'id' => $session_data['id']);
		return $session;
	}

	public function viewAll() {
		//pregled svih postova
		if ($this -> session -> userdata('logged_in')) {
			$config["base_url"] = base_url() . "post/viewall";
			$config["total_rows"] = $this -> post_model -> total();
			$config["per_page"] = 10;
			$config["uri_segment"] = 3;
			$config['num_links'] = 2;
			$this -> pagination -> initialize($config);
			$page = ($this -> uri -> segment(3)) ? $this -> uri -> segment(3) : 0;
			$data["post"] = $this -> post_model -> getAll($config["per_page"], $page);
			$data["links"] = $this -> pagination -> create_links();
			$data['session'] = $this::getSession();
			$this -> load -> view('private/posts', $data);
		} else {

			redirect('login', 'refresh');
		}
	}

	public function createNew() {
		//load view za unos novog posta
		$data['session'] = $this::getSession();
		$this -> load -> view('private/createNew', $data);
	}

	public function inputNew() {
		//unos novog posta u bazu
		$this -> load -> library('form_validation');
		$this -> form_validation -> set_error_delimiters('<div class="loginer">', '</div>');
		$this -> form_validation -> set_rules('naslov', 'Naslov', 'required');
		$this -> form_validation -> set_rules('sadrzaj', 'Sadrzaj', 'required');

		if ($this -> form_validation -> run() == FALSE) {
			//neispravan unos
			$data['session'] = $this::getSession();
			$data['post']=array('naslov'=>$this->input->post('naslov'),
								'sadrzaj'=>$this->input->post('sadrzaj'),
								'id'=>$this->input->post('id')
								);
			$this -> load -> view('private/createNew', $data);
		} else {
			//ispravan unos nastavak na insert
			$datas = array('naslov' => $this -> input -> post('naslov'), 'sadrzaj' => $this -> input -> post('sadrzaj'));
			$result = $this -> post_model -> createNew($datas);
			redirect(base_url('post/viewall'));
			
		}
	}
	public function deletePost(){
		$id=$this->input->post('id');
		$this->post_model->deletePost($id);
		$url=$this->input->post('url');
		redirect($url);
	}
	public function updatePost(){
		$postId=$this -> uri -> segment(3);
		$data['postid']=$postId;
		$result=$this->post_model->selectPost($postId);
		foreach ($result as $row) {
				$data['post'] = array(
				'id' => $row -> id, 
				'naslov' => $row -> naslov,
				'sadrzaj' => $row -> sadrzaj, 
				'datum'=> $row->datum);}
		$data['session']=$this::getSession();
		$this->load->view('private/update', $data);
	}
	public function update(){
		$this -> load -> library('form_validation');
		$this -> form_validation -> set_error_delimiters('<div class="loginer">', '</div>');
		$this -> form_validation -> set_rules('naslov', 'Naslov', 'required');
		$this -> form_validation -> set_rules('sadrzaj', 'Sadrzaj', 'required');

		if ($this -> form_validation -> run() == FALSE) {
			//neispravan unos
			$data['session'] = $this::getSession();
			$data['post']=array('naslov'=>$this->input->post('naslov'),
								'sadrzaj'=>$this->input->post('sadrzaj'),
								'id'=>$this->input->post('id')
								);
			$this -> load -> view('private/update', $data);
		} else {
			//ispravan unos nastavak na insert
			$datas = array(
				'id'=>$this->input->post('id'),
				'naslov' => $this -> input -> post('naslov'), 
				'sadrzaj' => $this -> input -> post('sadrzaj')
				);
			$result = $this -> post_model -> update($datas);
			redirect(base_url('post/viewall'));
			
		}
	}
}
