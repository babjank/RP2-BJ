<?php

class User
{
	protected $id, $username, $password_hash, $email, $ulogiran, $ime_patrole;

	function __construct($id, $ime, $prezime, $adresa, $datum_upisa, $ime_patrole, $email, $username, $password_hash, $ulogiran, $slika)
	{
		$this->id = $id;
		$this->ime = $ime;
		$this->prezime = $prezime;
		$this->adresa = $adresa;
		$this->datum_upisa = $datum_upisa;
		$this->ime_patrole = $ime_patrole;
		$this->email = $email;
		$this->username = $username;
		$this->password_hash = $password_hash;
		$this->ulogiran = $ulogiran;
		$this->slika = $slika;
	}

	function __get($prop) { return $this->$prop; }
	function __set($prop, $val) { $this->$prop = $val; return $this; }
}

?>
