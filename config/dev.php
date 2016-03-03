<?php

use Silex\Provider\MonologServiceProvider;

// Enable the debug mode.
$app['debug'] = true;

// RabbitMQ server configuration.
$app['queue_host'] = '';
$app['queue_port'] = null; // Default 5672.
$app['queue_user'] = '';
$app['queue_pass'] = '';
$app['queue_name'] = '';

$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../var/logs/silex_dev.log',
));
