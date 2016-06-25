<?php

use OldSound\RabbitMqBundle\RabbitMq\RpcClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @var Composer\Autoload\ClassLoader
 */
$loader = require __DIR__.'/../app/autoload.php';
include_once __DIR__.'/../app/ServerKernel.php';

$kernel = new ServerKernel('prod', false);
$kernel->loadClassCache();
$kernel->boot();
/** @var \Symfony\Component\DependencyInjection\Container $container */
$container = $kernel->getContainer();

$request = Request::createFromGlobals();
$id = uniqid('request_', true) . '-' . md5(rand(0, 100));

/** @var RpcClient $client */
$client = $container->get('old_sound_rabbit_mq.request_rpc');
$client->addRequest(serialize($request), 'request', $id);
/** @var Response $response */
$response = $client->getReplies()[$id];
$response->send();
$kernel->terminate($request, $response);
