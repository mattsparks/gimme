<?php namespace Gimme\Tools;

use TheStringler\Manipulator\Manipulator;
use Gimme\Components\Destination;
use Gimme\Components\Extension;
use Gimme\Components\Location;
use Gimme\Components\Response;
use Gimme\Components\File;
use Gimme\Components\Source;
use Gimme\Tools\FileFinder;

class FileFetcher {

	/**
	 * @var \Gimme\Components\Destination
	 */
	protected $destination;

	/**
	 * @var array
	 */
	protected $files = [];

	/**
	 * @var \Gimme\Components\Extension
	 */
	protected $extension;

	/**
	 * @var \Gimme\Components\Location
	 */
	protected $location;

	/**
	 * @var \Gimme\Tools\Output
	 */
	protected $output;

	/**
	 * @var \Gimme\Components\Response
	 */
	protected $response;

	/**
	 * @var \Gimme\Components\Source
	 */
	protected $source;

	/**
	 * FileFetcher constructor
	 *
	 * @param $output
	 */
	public function __construct($output)
	{
		$this->output = $output;
	}

	/**
	 * Download Files
	 *
	 * @return void
	 */
	public function downloadFiles()
	{
		foreach($this->files as $file) {
			$this->output->action('> Downloading: ' . $file->path());

			$file->download();

			$this->output->action('> Saving...');

			$file->save($this->destination->get());

			$this->output->success('> Done!');
		}
	}

	/**
	 * Find Files
	 *
	 * @throws \Exception
	 * @return void
	 */
	public function findFiles()
	{
		$this->output->info('Looking for files...');

		$finder  = new FileFinder(
			$this->extension->get(), $this->response->get()
		);

		foreach($finder->results() as $result) {
			$file = new File($result->result());

			if(!in_array($file, $this->files)) {
				$this->files[] = $file;
			}
		}

		if(!$this->getTotal()) {
			throw new \Exception('Sorry, didn\'t find anything. Maybe try another extension.');
		}

		$this->output->success($this->getTotal() . ' files found...');
	}

	/**
	 * Fetch Source
	 *
	 * @return void
	 */
	public function fetchSource()
	{
		$this->output->info('Fetching content...');

		$this->source = new Source($this->location->get());
		$this->source->fetch();

		$this->response = new Response($this->source->get());
	}

	/**
	 * Get Total
	 *
	 * @return int
	 */
	public function getTotal()
	{
		return count($this->files);
	}

	/**
	 * Set Destination
	 *
	 * @param $destination
	 */
	public function setDestination($destination)
	{
		$this->destination = new Destination($destination);
	}

	/**
	 * Set Extension
	 *
	 * @param $ext
	 */
	public function setExtension($ext)
	{
		$this->extension = new Extension(
			Manipulator::make($ext)->remove('.')->toLower()->toString()
		);
	}

	/**
	 * Set Location
	 *
	 * @param $location
	 */
	public function setLocation($location)
	{
		$this->location = new Location($location);
	}
}