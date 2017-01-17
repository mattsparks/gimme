<?php namespace Gimme\Components;

class File {

	/**
	 * @var mixed
	 */
	protected $content = null;

	/**
	 * @var string
	 */
	protected $path;

	/**
	 * File constructor
	 *
	 * @param $path
	 */
	public function __construct($path)
	{
		$this->path = $path;
	}

	/**
	 * Download
	 *
	 * @throws \Exception
	 * @return void
	 */
	public function download()
	{
		if(!$content = file_get_contents($this->path)) {
			throw new \Exception('Unable to download file.');
		}

		$this->content = $content;
	}

	/**
	 * Path
	 *
	 * @return string
	 */
	public function path()
	{
		return $this->path;
	}

	/**
	 * Save
	 *
	 * @param $destination
	 * @throws \Exception
	 * @return void
	 */
	public function save($destination)
	{
		if(!file_put_contents($destination . basename($this->path), $this->content)) {
			throw new \Exception('Unable to save file.');
		}
	}

}