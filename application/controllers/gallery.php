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
		//pregled svih itema

		$config["base_url"] = base_url() . "gallery/view";
		$config["total_rows"] = $this -> gallery_model -> total();
		$config['per_page'] = 12;
		$config['uri_segment'] = 3;
		$config['num_links'] = 1;
		$this -> pagination -> initialize($config);
		$page = ($this -> uri -> segment(3)) ? $this -> uri -> segment(3) : 0;
		$data['item'] = $this -> gallery_model -> getAll($config['per_page'], $page);
		$data['links'] = $this -> pagination -> create_links();
		$data['ukupno'] = $this -> gallery_model -> total();
		$data['session'] = $this -> getSession();
		$this -> load -> view('private/images', $data);
	}

	public function viewByTag() {
		//pregled itema(fotografija) po odabranom tagu iliti oznaci
		$tagId = $this -> uri -> segment(3);

		$config["base_url"] = base_url() . "gallery/viewByTag/$tagId";
		$config["total_rows"] = $this -> gallery_model -> totalTag($tagId);
		$config['per_page'] = 12;
		$config['uri_segment'] = 4;
		$config['num_links'] = 1;
		$this -> pagination -> initialize($config);
		$page = ($this -> uri -> segment(4)) ? $this -> uri -> segment(4) : 0;

		$data['item'] = $this -> gallery_model -> getByTag($config['per_page'], $page, $tagId);
		$data['links'] = $this -> pagination -> create_links();
		$data['ukupno'] = $this -> gallery_model -> total();
		$data['session'] = $this -> getSession();
		$this -> load -> view('private/images', $data);
	}

	public function createNew() {
		//load view za unos novog itema(foto)
		$data['session'] = $this -> getSession();
		$this -> load -> view('private/newitem', $data);
	}

	public function inputNew() {
		//unos novog posta u bazu
		$this -> load -> library('form_validation');
		$this -> form_validation -> set_error_delimiters('<div class="loginer">', '</div>');
		$this -> form_validation -> set_rules('naziv', 'Naziv', 'required');
		$this -> form_validation -> set_rules('opis', 'Opis', 'required');
		$this -> form_validation -> set_rules('foto', 'Fotografija', 'callback__image_upload');

		if ($this -> form_validation -> run() == FALSE) {
			//neispravan unos vrati na unos s dosad unesenim podacima
			$data['session'] = $this -> getSession();
			$data['post'] = array('naziv' => $this -> input -> post('naziv'), 'opis' => $this -> input -> post('opis'));
			$this -> load -> view('private/newitem', $data);
		} else {
			//uneseni podaci ispravni nastavi
			//postavke upload-a
			$image_path = realpath(APPPATH . '../assets/img/gallery');
			$config['upload_path'] = $image_path;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';

			$this -> load -> library('upload', $config);

			if (!$this -> upload -> do_upload('foto')) {
				//upload nije uspio, vrati na unos podataka s greskom
				$data['error'] = $this -> upload -> display_errors();
				$data['session'] = $this -> getSession();
				$data['post'] = array('naziv' => $this -> input -> post('naziv'), 'opis' => $this -> input -> post('opis'));
				$this -> load -> view('private/newitem', $data);
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
				$datas = array('naziv' => $this -> input -> post('naziv'), 'opis' => $this -> input -> post('opis'), 'foto' => $data['upload_info']['file_name'], 'foto_thumb' => $foto_thumb);
				//spremi u bazu
				$lastId = $this -> gallery_model -> createNew($datas);

				$this -> session -> set_flashdata('id', $lastId);
				redirect('/tagitem');
			}
		}
	}

	public function tagitem() {
		//load view za tagiranje unesenog itema
		$data['session'] = $this -> getSession();
		$data["lastId"] = $this -> session -> flashdata('id');
		$this -> load -> view('private/tagitem', $data);
	}

	public function auto() {
		//autocomplete controller
		$term = strtolower($this -> input -> get('term'));
		$results = $this -> gallery_model -> getTag($term);
		echo json_encode($results);
	}

	public function check() {
		//provjera postoji li odabrani tag
		$check = $this -> input -> post('tag');
		$this -> gallery_model -> check($check);
	}

	public function tagit() {
		//hajde dodaj mu oznaku
		$id = $_POST['id'];
		unset($_POST['id']);
		foreach ($_POST as $key => $value) {
			$this -> gallery_model -> tagit($id, $value);
		}
		
		redirect('gallery/view');

	}
	public function deleteItem(){
		//delete item
		$info = array('id' => $this -> input -> post('id'), 'old_foto' => $this -> input -> post('foto'),'foto' => $this -> input -> post('foto'), 'foto_thumb' => $this -> input -> post('foto_thumb'));

		$this -> gallery_model -> deleteItem($info);
		$this -> view();
	}
	public function updateItem($id = 0, $error = '') {
		//otvaranje update opcije

		if ($id > 0) {
			//ukoliko je id zadan tada uzmi njega a ako nije uzmi ga iz url-a
			$itemId = $id;
		} else {
			$itemId = $this -> uri -> segment(3);
		}
		
		if ($error) {
			$data['error'] = $error;
		}
		$data['itemid'] = $itemId;
		$result = $this -> gallery_model -> selectItem($itemId);
		foreach ($result as $row) {
			$data['item'] = array('id' => $row -> id, 'naziv' => $row -> naziv, 'opis' => $row -> opis, 'foto' => $row -> foto, 'foto_thumb' => $row -> foto_thumb);
		}
		$data['session'] = $this -> getSession();
		$this -> load -> view('private/updateItem', $data);
	}
	
	public function update() {
		//spremaje napravljenih promjena
		$this -> load -> library('form_validation');
		$this -> form_validation -> set_error_delimiters('<div class="loginer">', '</div>');
		$this -> form_validation -> set_rules('naziv', 'Naziv', 'required');
		$this -> form_validation -> set_rules('opis', 'Opis', 'required');
		$this -> form_validation -> set_rules('new_img', 'NewImage', 'callback__image_upload');
	
		if ($this -> form_validation -> run() == FALSE) {
			//neispravan unos
			$data['session'] = $this -> getSession();
			$data['item'] = array(
			'naziv' => $this -> input -> post('naziv'), 
			'opis' => $this -> input -> post('opis'), 
			'id' => $this -> input -> post('id'), 
			'foto' => $this -> input -> post('foto'),
			'foto_thumb' => $this -> input -> post('foto_thumb')
			);
			$this -> load -> view('private/updateItem', $data);
		} else {
			//ispravan unos nastavak na update
			if ($_FILES['new_img']['name']) {
				$image_path = realpath(APPPATH . '../assets/img/gallery');
				$config['upload_path'] = $image_path;
				$config['allowed_types'] = 'gif|jpg|png|jpeg';

				$this -> load -> library('upload', $config);

				if (!$this -> upload -> do_upload('new_img')) {
					$this -> updateItem($this -> input -> post('id'), $this -> upload -> display_errors());
				} else {
					$datas = array('id' => $this -> input -> post('id'), 'naziv' => $this -> input -> post('naziv'), 'opis' => $this -> input -> post('opis'));
					$this -> gallery_model -> update($datas);
					
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
					'old_foto_thumb' =>$this->input->post('foto_thumb')
					);
					
					$this -> gallery_model -> updateImg($img);
					redirect(base_url('gallery/view'));
				}
			} else {
				$datas = array('id' => $this -> input -> post('id'), 'naziv' => $this -> input -> post('naziv'), 'opis' => $this -> input -> post('opis'));
				$result = $this -> gallery_model -> update($datas);
				redirect(base_url('gallery/view'));
			}
		}
	}
}
