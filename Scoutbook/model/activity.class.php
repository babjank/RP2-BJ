<?php

class Activity
{
	protected $id, $id_izvidac, $datum, $mjesto, $cijena, $broj_clanova;

	function __construct($id, $id_izvidac, $datum, $mjesto, $cijena, $broj_clanova)
	{
		$this->id = $id;
		$this->id_izvidac = $id_izvidac;
		$this->datum = $datum;
		$this->mjesto = $mjesto;
		$this->cijena = $cijena;
		$this->broj_clanova = $broj_clanova;
	}

	function __get($prop) { return $this->$prop; }
	function __set($prop, $val) { $this->$prop = $val; return $this; }
}

?>
