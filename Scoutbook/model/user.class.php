<?php

class User
{
	protected $id, $username, $password_hash, $email, $ulogiran, $ime_patrole;

	function __construct($id, $username, $password_hash, $email, $ulogiran, $ime_patrole)
	{
		$this->id = $id;
		$this->username = $username;
		$this->password_hash = $password_hash;
		$this->email = $email;
		$this->ulogiran = $ulogiran;
		$this->ime_patrole = $ime_patrole;
	}

	function __get($prop) { return $this->$prop; }
	function __set($prop, $val) { $this->$prop = $val; return $this; }
}

?>
