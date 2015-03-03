<?php
Class Post_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function total() {
		return $this -> db -> count_all("post");
	}

	public function getAll($limit, $start) {
		//dohvacanje svih postova(unutar zadanih granica zbog paginacije)
		$this -> db -> limit($limit, $start);
		$this -> db -> order_by("datum", "desc");
		$query = $this -> db -> get('post');
		if ($query -> num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return FALSE;

	}

	public function createNew($data) {
		//unos novog posta
		$this -> db -> query('insert into post(naslov, sadrzaj, foto, foto_thumb, datum) values(?, ?, ?, ?, ?) ', array($data['naslov'], $data['sadrzaj'], $data['foto'], $data['foto_thumb'], date('Y-m-d H:i:s')));
		return TRUE;
	}

	public function deletePost($info) {
		//brisanje posta po id-u

		$this -> db -> query('delete from post where id=?', $info['id']);
		if ($info['old_foto'] != 'default.jpeg') {
		$this -> load -> library('ftp');
		$image_thumb_path = realpath(APPPATH . '../assets/img/posts') . '/' . $info['foto_thumb'];
		$image_path = realpath(APPPATH . '../assets/img/posts') . '/' . $info['foto'];
		unlink($image_thumb_path);
		unlink($image_path);
		}
		return TRUE;
	}

	public function selectPost($id) {
		//odabir posta po id-u
		$query = $this -> db -> query('select * from post where id=?', $id);
		if ($query -> num_rows() == 1) {
			return $query -> result();
		} else {
			return FALSE;
		}
	}

	public function update($datas) {
		//update posta
		$this -> db -> query('update post set naslov=?, sadrzaj=? where id=?', array($datas['naslov'], $datas['sadrzaj'], $datas['id']));
		return TRUE;
	}

	public function updateImg($img) {
		//update slike
		//print_r ($img);
		$this -> db -> query('update post set foto=?, foto_thumb=? where id=?', array($img['foto'], $img['foto_thumb'], $img['id']));
		if ($img['old_foto'] != 'default.jpeg') {
			$image_thumb_path = realpath(APPPATH . '../assets/img/posts') . '/' . $img['old_foto_thumb'];
			$image_path = realpath(APPPATH . '../assets/img/posts') . '/' . $img['old_foto'];
			unlink($image_thumb_path);
			unlink($image_path);
		}
		return TRUE;

	}
	
}
