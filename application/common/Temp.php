<?php
namespace app\common;

class Temp
{
	private $name;

	public function __construct($name="peter"){
		$this->name = $name;
	}

	public function setName($name){
		$this->name = $name;
	}

	public function getName()
	{
		return '方法是:'.__METHOD__.'属性时:'.$this->name;
	}
}