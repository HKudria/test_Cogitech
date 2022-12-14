<?php

namespace App\Command;

use App\Service\PostService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:parse-posts',
    description: 'Parse posts from api',
    hidden: false,)]
class ParsePosts extends Command
{
    public function __construct(
        private readonly PostService $service,
        string                       $name = null
    )
    {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Strat parsing...',
        ]);

        $output->writeln($this->service->parsePosts());

        return Command::SUCCESS;
    }
}
