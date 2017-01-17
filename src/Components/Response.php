<?php namespace Gimme\Components;

class Response {

	/**
	 * @var mixed
	 */
	protected $content;

	/**
	 * Response constructor
	 *
	 * @param $content
	 */
	public function __construct($content)
	{
		$this->content = $content;
	}

	/**
	 * Get
	 *
	 * @return mixed
	 */
	public function get()
	{
		return $this->content;
	}

}