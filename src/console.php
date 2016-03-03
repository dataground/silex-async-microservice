<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use PhpAmqpLib\Connection\AMQPStreamConnection;

$console = new Application('App', 'v0.1.0');

$console->getDefinition()->addOption(
    new InputOption('--env', '-e', InputOption::VALUE_REQUIRED, 'The Environment name.', 'dev')
);

$console->setDispatcher($app['dispatcher']);

$console
    ->register('app:consumer')
    ->setDefinition(array(
        // new InputArgument('some-argument', InputArgument::OPTIONAL, 'Some help.'),
        // new InputOption('some-option', null, InputOption::VALUE_NONE, 'Some help.'),
    ))
    ->setDescription('Launches a consumer that will feed from the configured RabbitMQ queue.')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        // $some-argument = $input->getArgument('some-argument');
        // $some-option = $input->getOption('som-optione');
        $consumer = $app['consumer'];

        $consumer->readMessages();
    });

return $console;
