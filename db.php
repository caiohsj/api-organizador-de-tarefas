<?php
use DI\ContainerBuilder;

if (PHP_SAPI != 'cli') {
    exit('Executar CLI');
}

require __DIR__ . '/vendor/autoload.php';

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

if (false) { // Should be set to true in production
	$containerBuilder->enableCompilation(__DIR__ . '/var/cache');
}

// Set up settings
$settings = require __DIR__ . '/app/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require __DIR__ . '/app/dependencies.php';
$dependencies($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

$db = $container->get('db');

$schema = $db->schema();

$schema->dropIfExists('tasks');

$schema->create('tasks', function($table){
    $table->increments('id');
    $table->string('titulo', 100);
	$table->text('descricao');
	$table->timestamps();
});