<?php namespace Gimme\Components;

use Spatie\Regex\Regex;

class Extension {

	protected $name;

	public function __construct($name)
	{
		$this->name = $name;

		if(!$this->isValid()) {
			throw new \Exception('Looks like that was an invalid extension...');
		}
	}

	public function get()
	{
		return $this->name;
	}

	protected function isValid()
	{
		return (!empty($this->name) && !Regex::match('/[^\w\d]/', $this->name)->hasMatch());
	}

}