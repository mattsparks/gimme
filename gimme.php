#!/usr/bin/env php
<?php
require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Gimme\Commands\FilesCommand;

// Create Application
$application = new Application();

// Add Commands
$application->add(new FilesCommand());

// Run
$application->run();