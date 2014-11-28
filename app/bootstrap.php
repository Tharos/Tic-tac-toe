<?php

use Nette\Application\Routers\Route;

require_once __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

$configurator->setDebugMode(file_exists(__DIR__ . '/config/dev'));
$configurator->enableDebugger(__DIR__ . '/../log');
$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->addConfig(__DIR__ . '/config/config.neon');

if (file_exists(__DIR__ . '/config/config.server.neon')) {
	$configurator->addConfig(__DIR__ . '/config/config.server.neon');
}

$container = $configurator->createContainer();

$container->router[] = new Route('', 'Website:Game:default');

return $container;
