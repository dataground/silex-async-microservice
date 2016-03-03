<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {
    return new Response('Hey ( ͡° ͜ʖ ͡°)');
})
->bind('homepage');

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    return new Response('Error ಠ_ಠ');
});

$app->get('/test', function (Request $request) use ($app) {
    $producer = $app['producer'];

    $producer->sendMessage('Test message.');

    return new Response('Test message sent.', 200);
});
