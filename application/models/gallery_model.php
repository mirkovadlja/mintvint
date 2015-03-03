<?php
Class Gallery_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function total() {
		//broji sve predmete koji su uneseni
		return $this -> db -> count_all("item");
	}

	public function getAll($limit, $start) {
		//dohvacanje svih itema odnosno fotografija(unutar zadanih granica zbog paginacije)
		$this -> db -> select('*');
		$this -> db -> from('item');
		$this -> db -> limit($limit, $start);

		$query = $this -> db -> get();
		if ($query -> num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return FALSE;

	}

	public function getTags() {
		//dvraca sve tagove koji su u bazi a dodjeljen im je bar jedan predmet
		$dohvati = $this -> db -> query('select b.name as tag,b.id as id, count(*) as numb from item_tag a join tag b on b.id=a.tag group by a.tag;');
		return $dohvati -> result();
	}

	public function totalTag($tagId) {
		//vraca koliko je predmeta s pojedinom oznakom
		$this -> db -> from('item_tag');
		$this -> db -> where('tag', $tagId);
		return $this -> db -> count_all_results();
	}

	public function getByTag($limit, $start, $tagId) {
		//dohvacanje rezultata na osnovu odabranog taga
		$mirko = $this -> db -> query("select a.* from item a join item_tag b on a.id=b.item where b.tag=$tagId limit $start,$limit");
		if ($mirko -> num_rows() > 0) {
			foreach ($mirko->result() as $row) {
				$data[] = $row;
				//echo $row;
			}
			//var_dump($data);
			return $data;
		}
	}

	public function createNew($data) {
		//unos novog itema
		$this -> db -> query('insert into item(naziv, opis, foto, foto_thumb, datum) values(?, ?, ?, ?, ?) ', array($data['naziv'], $data['opis'], $data['foto'], $data['foto_thumb'], date('Y-m-d H:i:s')));
		return $this -> db -> insert_id();
	}

	public function getTag($term) {
		//autocomplete dohvacanje tagova na osnovu dovijenog uvijeta
		$this -> db -> like('name', $term);
		$query = $this -> db -> get('tag');
		$result = array();
		foreach ($query->result() as $row) {
			array_push($result, $row -> name);
		}
		return $result;

	}

	public function check($a) {
		//provjera postoji li odabrani tag u bazi ako ako ne postoji unosi ga u bazu a ako postoji nikom nista
		$query = $this -> db -> get_where('tag', array('name' => $a));
		if ($query -> num_rows() == 0) {
			$b = array('name' => $a);
			$this -> db -> insert('tag', $b);
		}
		return TRUE;
	}

	public function tagit($id, $a) {
		$this -> db -> query('insert into item_tag(item,tag) values(?,(select id from tag where name=?))', array($id, $a));
	}
	public function deleteItem($info){
		//aj obrisi item i njegovu foto osim ako je defaltna :D
		$this -> db -> query('delete from item_tag where item=?', $info['id']);
		$this -> db -> query('delete from item where id=?', $info['id']);
		if($info['old_foto']!='default.jpeg'){
		$this -> load -> library('ftp');
		$image_thumb_path = realpath(APPPATH . '../assets/img/gallery') . '/' . $info['foto_thumb'];
		$image_path = realpath(APPPATH . '../assets/img/gallery') . '/' . $info['foto'];
		unlink($image_thumb_path);
		unlink($image_path);
		}
		return TRUE;
	}
	public function update($datas) {
		//update itema
		$this -> db -> query('update item set naziv=?, opis=? where id=?', array($datas['naziv'], $datas['opis'], $datas['id']));
		return TRUE;
	}

	public function updateImg($img) {
		//update slike
		$this -> db -> query('update item set foto=?, foto_thumb=? where id=?', array($img['foto'], $img['foto_thumb'], $img['id']));
		if ($img['old_foto'] != 'default.jpeg') {
			$image_thumb_path = realpath(APPPATH . '../assets/img/gallery') . '/' . $img['old_foto_thumb'];
			$image_path = realpath(APPPATH . '../assets/img/gallery') . '/' . $img['old_foto'];
			unlink($image_thumb_path);
			unlink($image_path);
		}
		return TRUE;

	}
public function selectItem($id) {
		//odabir itema po id-u
		$query = $this -> db -> query('select * from item where id=?', $id);
		if ($query -> num_rows() == 1) {
			return $query -> result();
		} else {
			return FALSE;
		}
	}
}
