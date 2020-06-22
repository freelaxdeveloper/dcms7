<?php
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;

$capsule = new Manager;

$capsule->addConnection([
    'host'    => 'dev_mysql_dcms2',
    'driver'    => 'mysql',
    'database'  => env('DB_DATABASE'),
    'password'  => env('DB_PASSWORD'),
    'username'  => env('DB_USERNAME'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Set the event dispatcher used by Eloquent models... (optional)
$capsule->setEventDispatcher(new Dispatcher(new Container));

$capsule->setAsGlobal();
$capsule->bootEloquent();
