<?php

namespace SlapChop\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use SlapChop\ResizeTransit;

class ResizeCommand extends Command
{

    protected $transit;

    public function __construct(ResizeTransit $transit)
    {
        $this->transit = $transit;
    }

    protected function configure()
    {
        $this
            ->setName('resize')
            ->setDescription('Resize all images in a folder and save to destination')
            ->addOption(
                'target',
                't',
                InputOption::VALUE_OPTIONAL,
                'The target directory'
            )
            ->addOption(
                'dest',
                'd',
                InputOption::VALUE_REQUIRED,
                'The destination directory'
            )
            ->addOption(
                'height',
                'y',
                InputOption::VALUE_OPTIONAL,
                'Height (in pixels) to resize to'
            )
            ->addOption(
                'width',
                'x',
                InputOption::VALUE_OPTIONAL,
                'Width (in pixels) to resize to'
            )
            ->addOption(
                'keep-ratio',
                'k',
                InputOption::VALUE_OPTIONAL,
                'Maintain aspect ratios'
            )
        ;

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $target = $input->getOption('target');
        $dest = $input->getOption('dest');
        $height = $input->getOption('height');
        $width = $input->getOption('width');
    }
}


