<?php

namespace SlapChop\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ResizeCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('resize')
            ->setDescription('Resize all images in a folder')
            ->addArgument(
                'target',
                InputArgument::REQUIRED,
                'The target directory'
            )
            ->addArgument(
                'dest',
                InputArgument::REQUIRED,
                'The destination directory'
            )
            ->addOption(
                'height',
                'y',
                InputOption::VALUE_OPTIONAL,
                'Height (in pixels) to size to'
            )
            ->addOption(
                'width',
                'x',
                InputOption::VALUE_OPTIONAL,
                'Width (in pixels) to size to'
            )
        ;

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }
}


