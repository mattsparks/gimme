<?php namespace Gimme\Components;


class Destination {

	/**
	 * @var string
	 */
	protected $path;

	/**
	 * Destination constructor
	 *
	 * @param $path
	 */
	public function __construct($path)
	{
		$this->path = substr($path, -1) === '/' ? $path : $path . '/';

		$this->isValidOrCreate();
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
	 * Is Valid Or Create
	 *
	 * If the destination path isn't found try to create it.
	 *
	 * @throws \Exception
	 * @return void
	 */
	public function isValidOrCreate()
	{
		if(!is_readable($this->path)) {
			if(!mkdir($this->path)) {
				throw new \Exception('Folder not found and could not be created.');
			}
		}
	}
}