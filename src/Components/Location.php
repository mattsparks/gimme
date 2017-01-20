<?php  namespace Gimme\Components;

use Spatie\Regex\Regex;

class Location {

	/**
	 * @var string
	 */
	protected $path;

	/**
	 * Location constructor.
	 *
	 * @param $path
	 * @throws \Exception
	 */
	public function __construct($path)
	{
		$this->path = $path;

		if(!$this->isValid()) {
			throw new \Exception('Sorry, that doesn\'t appear to be a valid path. Be sure to include http:// or https://');
		}
	}

	/**
	 * Get
	 *
	 * @return string
	 */
	public function get()
	{
		return $this->path;
	}

	/**
	 * isValid
	 *
	 * @return bool
	 */
	protected function isValid()
	{
		return (!empty($this->path) && Regex::match('/(https?:\/\/.+)/', $this->path)->hasMatch());
	}

}