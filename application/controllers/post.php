<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

session_start();
class Post extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library('pagination');
		$this -> load -> model("post_model");
		if (!$this -> session -> userdata('logged_in')) {redirect('login', 'refresh');
		}

	}

	private function getSession() {
		//vračanje podataka iz session-a
		$session_data = $this -> session -> userdata('logged_in');
		$session = array('username' => $session_data['username'], 'id' => $session_data['id']);
		return $session;
	}

	public function viewAll() {
		//pregled svih postova
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
		$this -> form_validation -> set_rules('postimg', 'Post Image', 'callback__image_upload');

		if ($this -> form_validation -> run() == FALSE) {
			//neispravan unos vrati na unos s dosad unesenim podacima
			$data['session'] = $this -> getSession();
			$data['post'] = array('naslov' => $this -> input -> post('naslov'), 'sadrzaj' => $this -> input -> post('sadrzaj'), 'id' => $this -> input -> post('id'));
			$this -> load -> view('private/createNew', $data);
		} else {
			//uneseni podaci ispravni nastavi
			//postavke upload-a
			$image_path = realpath(APPPATH . '../assets/img/posts');
			$config['upload_path'] = $image_path;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';

			$this -> load -> library('upload', $config);

			if (!$this -> upload -> do_upload('postimg')) {
				//upload nije uspio, vrati na unos podataka s greskom
				$data['error'] = $this -> upload -> display_errors();
				$data['session'] = $this -> getSession();
				$data['post'] = array('naslov' => $this -> input -> post('naslov'), 'sadrzaj' => $this -> input -> post('sadrzaj'), 'id' => $this -> input -> post('id'));
				$this -> load -> view('private/createNew', $data);
			} else {
				//upload uspjesno izvrsen nastavi na spremanje podataka u bazu
				$data = array('upload_info' => $this -> upload -> data());
				//print_r($data['upload_info']);

				//resize uploadane slike(thumb)

				$config['image_library'] = 'gd2';
				$config['source_image'] = $data['upload_info']['full_path'];
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 200;
				$config['height'] = 150;

				$this -> load -> library('image_lib', $config);

				$this -> image_lib -> resize();

				$foto_thumb = $data['upload_info']['raw_name'] . '_thumb' . $data['upload_info']['file_ext'];
				//pripremi podatke za bazu
				$datas = array('naslov' => $this -> input -> post('naslov'), 'sadrzaj' => $this -> input -> post('sadrzaj'), 'foto' => $data['upload_info']['file_name'], 'foto_thumb' => $foto_thumb);
				//spremi u bazu
				$this -> post_model -> createNew($datas);

				$this -> viewAll();
			}
		}
	}

	public function deletePost() {
		//brisanje posta
		$info = array('id' => $this -> input -> post('id'), 'foto' => $this -> input -> post('foto'), 'foto_thumb' => $this -> input -> post('foto_thumb'));

		$this -> post_model -> deletePost($info);
		$url = $this -> input -> post('url');
		redirect($url);
	}

	public function updatePost($id = 0, $error = '') {
		//otvaranje update opcije

		if ($id > 0) {
			$postId = $id;
		} else {
			$postId = $this -> uri -> segment(3);
		}
		//echo $postId;
		if ($error) {
			$data['error'] = $error;
			//echo $error;
		}
		$data['postid'] = $postId;
		$result = $this -> post_model -> selectPost($postId);
		foreach ($result as $row) {
			$data['post'] = array('id' => $row -> id, 'naslov' => $row -> naslov, 'sadrzaj' => $row -> sadrzaj, 'datum' => $row -> datum, 'foto' => $row -> foto, 'foto_thumb' => $row -> foto_thumb);
		}
		$data['session'] = $this -> getSession();
		$this -> load -> view('private/update', $data);
	}

	public function update() {
		//spremaje napravljenih promjena
		$this -> load -> library('form_validation');
		$this -> form_validation -> set_error_delimiters('<div class="loginer">', '</div>');
		$this -> form_validation -> set_rules('naslov', 'Naslov', 'required');
		$this -> form_validation -> set_rules('sadrzaj', 'Sadrzaj', 'required');
		$this -> form_validation -> set_rules('new_img', 'NewImage', 'callback__image_upload');
		/*print_r ($this->input->post());
		 echo($_FILES['new_img']['name'] ? $_FILES['new_img']['name']:'nema');
		 */
		if ($this -> form_validation -> run() == FALSE) {
			//neispravan unos
			$data['session'] = $this -> getSession();
			$data['post'] = array('naslov' => $this -> input -> post('naslov'), 'sadrzaj' => $this -> input -> post('sadrzaj'), 'id' => $this -> input -> post('id'), 'foto' => $this -> input -> post('foto'));
			$this -> load -> view('private/update', $data);
		} else {
			//ispravan unos nastavak na update
			if ($_FILES['new_img']['name']) {
				$image_path = realpath(APPPATH . '../assets/img/posts');
				$config['upload_path'] = $image_path;
				$config['allowed_types'] = 'gif|jpg|png|jpeg';

				$this -> load -> library('upload', $config);

				if (!$this -> upload -> do_upload('new_img')) {
					$this -> updatePost($this -> input -> post('id'), $this -> upload -> display_errors());
				} else {
					$datas = array('id' => $this -> input -> post('id'), 'naslov' => $this -> input -> post('naslov'), 'sadrzaj' => $this -> input -> post('sadrzaj'));
					$this -> post_model -> update($datas);
					
					$data = array('upload_info' => $this -> upload -> data());
					$config['image_library'] = 'gd2';
					$config['source_image'] = $data['upload_info']['full_path'];
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 200;
					$config['height'] = 150;

					$this -> load -> library('image_lib', $config);

					$this -> image_lib -> resize();

					$foto_thumb = $data['upload_info']['raw_name'] . '_thumb' . $data['upload_info']['file_ext'];
					$img=array(
					'id' => $this-> input -> post('id'),
					'foto' => $data['upload_info']['file_name'],
					'foto_thumb' => $foto_thumb,
					'old_foto' => $this->input->post('foto'),
					'old_foto_thumb' => $this->input->post('foto_thumb')
					);
					
					$this -> post_model -> updateImg($img);
					redirect(base_url('post/viewall'));
				}
			} else {
				$datas = array('id' => $this -> input -> post('id'), 'naslov' => $this -> input -> post('naslov'), 'sadrzaj' => $this -> input -> post('sadrzaj'));
				$result = $this -> post_model -> update($datas);
				redirect(base_url('post/viewall'));
			}
		}
	}

}
