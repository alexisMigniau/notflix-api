<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:create-folder')]
class CreatePublicFolder extends Command
{ 
    private ParameterBagInterface $params;

    public function __construct(ParameterBagInterface $params)
    {
        parent::__construct();
        $this->params = $params;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("Creates folders structures and update permission");

        $filesystem = new Filesystem();

        $folders = [
            'path_movies_images',
            'path_series_images',
            'path_episodes_images',
        ];

        foreach($folders as $f) {
            $path = 'public' . $this->params->get($f);

            if(!$filesystem->exists($path)) {
                $filesystem->mkdir($path);
            }

            $filesystem->chmod($path, 0777, 0000, true);
        }

        $output->writeln("Update permission");


        return Command::SUCCESS;
    }
}