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
		return false;

	}

	public function createNew($data) {
		//unos novog posta
		$sql = 'insert into post(naslov, sadrzaj, datum) values(?, ?,?) ';
		$this -> db -> query($sql, array($data['naslov'], $data['sadrzaj'], date('Y-m-d H:i:s')));
		return TRUE;
	}

	public function deletePost($id) {
		$this -> db -> query('delete from post where id=?', $id);
		return TRUE;
	}

	public function selectPost($id) {
		$query = $this -> db -> query('select * from post where id=?', $id);
		if ($query -> num_rows() == 1) {
			return $query -> result();
		} else {
			return false;
		}
	}
	public function update($datas){
		$query = $this ->db->query('update post set naslov=?, sadrzaj=? where id=?',
		 array($datas['naslov'], $datas['sadrzaj'], $datas['id']));
		return true;	
	}

}
