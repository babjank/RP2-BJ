<?php

class Activity
{
	protected $id, $id_izvidac, $datum, $mjesto, $opis, $cijena, $broj_clanova, $sirina, $duzina;

	function __construct($id, $id_izvidac, $datum, $mjesto, $opis, $cijena, $broj_clanova, $sirina, $duzina)
	{
		$this->id = $id;
		$this->id_izvidac = $id_izvidac;
		$this->datum = $datum;
		$this->mjesto = $mjesto;
		$this->opis = $opis;
		$this->cijena = $cijena;
		$this->broj_clanova = $broj_clanova;
		$this->sirina = $sirina;
		$this->duzina = $duzina;
	}

	function __get($prop) { return $this->$prop; }
	function __set($prop, $val) { $this->$prop = $val; return $this; }
}

?>
