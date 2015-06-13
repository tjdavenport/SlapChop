<?php

require __DIR__.'/vendor/autoload.php';

use SlapChop\Command\ResizeCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new ResizeCommand());
$application->run();
