<?php namespace Gimme\Components;

use Curl\Curl;

class Source {

	/**
	 * @var mixed
	 */
	protected $content;

	/**
	 * @var \Curl\Curl
	 */
	protected $curl;

	/**
	 * @var string
	 */
	protected $path;

	/**
	 * Source constructor
	 *
	 * @param $path
	 */
	public function __construct($path)
	{
		$this->curl = new Curl();
		$this->path = $path;
	}

	/**
	 * Fetch
	 *
	 * @throws \Exception
	 * @return void
	 */
	public function fetch()
	{
		$this->curl->get($this->path);

		if(!$this->curl->response) {
			throw new \Exception('Nothing was returned from: ' . $this->path);
		}

		$this->content = $this->curl->response;
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