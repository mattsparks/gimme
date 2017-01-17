<?php namespace Gimme\Tools;

use Spatie\Regex\Regex;

class FileFinder {

	/**
	 * @var string
	 */
	protected $extension;

	/**
	 * @var mixed
	 */
	protected $response;

	/**
	 * FileFinder constructor
	 *
	 * @param $extension
	 * @param $response
	 */
	public function __construct($extension, $response)
	{
		$this->extension = $extension;
		$this->response = $response;
	}

	/**
	 * RegEx
	 *
	 * @return string
	 */
	public function regex()
	{
		return '/(https?:\/\/[\w\d\/\-\.]+)(.\.' . $this->extension . ')/';
	}

	/**
	 * Results
	 *
	 * @return array
	 */
	public function results()
	{
		return Regex::matchAll($this->regex(), $this->response)->results();
	}
}