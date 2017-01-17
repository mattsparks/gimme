<?php

namespace Gimme\Tools;


class Output {

	protected $io;

	public function __construct($io)
	{
		$this->io = $io;
	}

	public function action($message)
	{
		$this->print('<a>' . $message . '</a>');
	}

	public function error($message)
	{
		$this->print('<e>' . $message . '</e>');
	}

	public function info($message)
	{
		$this->print('<i>' . $message . '</i>');
	}

	private function print($message)
	{
		$this->io->writeln(" $message");
	}

	public function success($message)
	{
		$this->print('<s>' . $message . '</s>');
	}

}