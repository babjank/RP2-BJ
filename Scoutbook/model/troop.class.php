<?php

class Troop
{
	protected $ime, $razred, $stupanj, $id_radionica;

	function __construct($ime, $razred, $stupanj, $id_radionica)
	{
		$this->ime = $ime;
		$this->razred = $razred;
		$this->stupanj = $stupanj;
		$this->id_radionica = $id_radionica;
	}

	function __get($prop) { return $this->$prop; }
	function __set($prop, $val) { $this->$prop = $val; return $this; }
}

?>
