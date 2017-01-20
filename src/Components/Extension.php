<?php namespace Gimme\Components;

use Spatie\Regex\Regex;

class Extension {

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * Extension constructor.
	 *
	 * @param $name
	 * @throws \Exception
	 */
	public function __construct($name)
	{
		$this->name = $name;

		if(!$this->isValid()) {
			throw new \Exception('Looks like that was an invalid extension...');
		}
	}

	/**
	 * Get
	 *
	 * @return string
	 */
	public function get()
	{
		return $this->name;
	}

	/**
	 * isValid
	 *
	 * @return bool
	 */
	protected function isValid()
	{
		return (!empty($this->name) && !Regex::match('/[^\w\d]/', $this->name)->hasMatch());
	}

}