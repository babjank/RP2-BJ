<?php

class Member
{
	protected $id, $id_aktivnost, $id_izvidac, $uloga;

	function __construct($id, $id_aktivnost, $id_izvidac, $uloga)
	{
		$this->id = $id;
		$this->id_aktivnost = $id_aktivnost;
		$this->id_izvidac = $id_izvidac;
		$this->uloga = $uloga;
	}

	function __get($prop) { return $this->$prop; }
	function __set($prop, $val) { $this->$prop = $val; return $this; }
}

?>
