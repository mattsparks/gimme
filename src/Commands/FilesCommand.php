<?php namespace Gimme\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Gimme\Tools\FileFetcher;
use Gimme\Tools\Output;

class FilesCommand extends Command
{
	/**
	 * @var array
	 */
	protected $config;

	/**
	 * @var \Gimme\Tools\FileFetcher
	 */
	protected $fetcher;

	/**
	 * @var \Symfony\Component\Console\Output\OutputInterface
	 */
	protected $io;

	/**
	 * @var \Gimme\Tools\Output
	 */
	protected $output;

	/**
	 * Configure Command
	 *
	 * @return void
	 */
	protected function configure()
	{
		$this->setName('files')
			 ->setDescription('Download files with a specific extension, ie: pdf')
			 ->setHelp('This command allows you to download files from a specific path.')
		 	 ->setDefinition(
			 	new InputDefinition([
			 		new InputOption('from', 'f', InputOption::VALUE_REQUIRED),
				    new InputOption('extension', 'e', InputOption::VALUE_REQUIRED),
			 	])
			 );
	}

	/**
	 * Print Exception
	 *
	 * @param $e
	 * @return void
	 */
	protected function printException($e)
	{
		$this->output->error($e->getMessage()); exit;
	}

	/**
	 * Execute Command
	 *
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return void
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		/**
		 * Setup Custom Styles
		 */
		$errorStyle = new OutputFormatterStyle('red', null, ['bold']);
		$output->getFormatter()->setStyle('e', $errorStyle);

		$infoStyle = new OutputFormatterStyle('yellow', null, []);
		$output->getFormatter()->setStyle('i', $infoStyle);

		$actionStyle = new OutputFormatterStyle('blue', null, []);
		$output->getFormatter()->setStyle('a', $actionStyle);

		$successStyle = new OutputFormatterStyle('green', null, []);
		$output->getFormatter()->setStyle('s', $successStyle);

		/**
		 * Initialize Stuffs
		 */
		$this->config  = require_once __DIR__ . '/../Config/config.php';
		$this->io      = new SymfonyStyle($input, $output);
		$this->output  = new Output($this->io);
		$this->fetcher = new FileFetcher($this->output);

		$this->io->writeln([
			'      ___                       ___           ___                       ___     ',
			'     /  /\        ___          /__/\         /__/\        ___          /  /\    ',
			'    /  /:/_      /  /\        |  |::\       |  |::\      /  /\        /  /:/_   ',
			'   /  /:/ /\    /  /:/        |  |:|:\      |  |:|:\    /  /:/       /  /:/ /\  ',
			'  /  /:/_/::\  /__/::\      __|__|:|\:\   __|__|:|\:\  /__/::\      /  /:/ /:/_ ',
			' /__/:/__\/\:\ \__\/\:\__  /__/::::| \:\ /__/::::| \:\ \__\/\:\__  /__/:/ /:/ /\\',
			'\  \:\ /~~/:/    \  \:\/\ \  \:\~~\__\/ \  \:\~~\__\/    \  \:\/\ \  \:\/:/ /:/',
			' \  \:\  /:/      \__\::/  \  \:\        \  \:\           \__\::/  \  \::/ /:/ ',
			'  \  \:\/:/       /__/:/    \  \:\        \  \:\          /__/:/    \  \:\/:/  ',
			'   \  \::/        \__\/      \  \:\        \  \:\         \__\/      \  \::/   ',
			'    \__\/                     \__\/         \__\/                     \__\/    ',
		]);

		/**
		 * Ask For Path
		 */
		$this->io->ask('Where would you like to download files from?', null, function($path) {
			try { $this->fetcher->setLocation($path); } catch (\Exception $e) { $this->printException($e); }
		});

		/**
		 * Ask For Extension
		 */
		$this->io->ask('What kind of files would you like? For example, pdf or jpg.', null, function($ext) {
			try { $this->fetcher->setExtension($ext); } catch (\Exception $e) { $this->printException($e); }
		});

		/**
		 * Get Source
		 */
		try { $this->fetcher->fetchSource(); } catch (\Exception $e) { $this->printException($e); }

		/**
		 * Find Files
		 */
		$this->fetcher->findFiles();

		/**
		 * Confirm Download
		 */
		$download = $this->io->confirm('Would you like to download these files?', true);

		if(!$download) {
			$this->output->success('Goodbye!'); exit;
		}

		/**
		 * Ask For Destination
		 */
		$this->io->ask('Where would you like to save these files?', $this->config['destination'], function($path) {
			$this->fetcher->setDestination($path);
			$this->output->info('Destination set to: ' . $path);
		});

		/**
		 * Let's Do This...
		 */
		try { $this->fetcher->downloadFiles(); } catch (\Exception $e) { $this->printException($e); }

		/**
		 * We Did It!
		 */
		$this->output->success('Finished!');
	}
}