<?php
Class User extends CI_Model {
	function login($username, $password) {
	
		$pass = MD5($password);
		$query = $this -> db -> query('select * from user where username=? and password=? limit 1', array($username, $pass));

		if ($query -> num_rows() == 1) {
			return $query -> result();
		} else {
			return FALSE;
		}
	}

}
?>