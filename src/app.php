<?php

use Silex\Application;
use App\Producer;
use App\Consumer;

$app = new Application();

// Register the 'producer' service.
$app['producer'] = function ($app) {
    return new Producer(
        $app['queue_host'],
        $app['queue_port'],
        $app['queue_user'],
        $app['queue_pass'],
        $app['queue_name']
    );
};

// Register the 'consumer' service.
$app['consumer'] = function ($app) {
    return new Consumer(
        $app['queue_host'],
        $app['queue_port'],
        $app['queue_user'],
        $app['queue_pass'],
        $app['queue_name']
    );
};

return $app;
