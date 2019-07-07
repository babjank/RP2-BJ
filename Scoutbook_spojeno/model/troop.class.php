<?php

class Troop
{
	protected $ime_patrole, $ime, $razred, $stupanj, $id_radionica;

	function __construct($ime_patrole, $razred, $stupanj, $id_radionica)
	{
		$this->ime_patrole = $ime_patrole;
		$this->ime = $ime_patrole;
		$this->razred = $razred;
		$this->stupanj = $stupanj;
		$this->id_radionica = $id_radionica;
	}

	function __get($prop) { return $this->$prop; }
	function __set($prop, $val) { $this->$prop = $val; return $this; }
}

?>
