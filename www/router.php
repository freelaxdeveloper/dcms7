<?php
require_once 'sys/inc/start.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;

use App\Services\Redirect;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

// Create a service container
$container = new Container;

// Create a request from server variables, and bind it to the container; optional
$request = Request::capture();

$request->setUserResolver(function () use ($user) {
    return $user;
});

$request->setJson(json_encode(['message' => 'df']));

//dd($request);
$container->instance('Illuminate\Http\Request', $request);

// Using Illuminate/Events/Dispatcher here (not required); any implementation of
// Illuminate/Contracts/Event/Dispatcher is acceptable
$events = new Dispatcher($container);

// Create the router instance
$router = new Router($events, $container);

// Load the routes
$router->namespace('App\Http\Controllers\Api')
    ->prefix('api')
    ->group(H . '/app/routes/api.php');

$router->namespace('App\Http\Controllers')
    ->group(H . '/app/routes/web.php');

// Create the redirect instance
$redirect = new Redirector(new UrlGenerator($router->getRoutes(), $request));

Redirect::setRequest($request);
Redirect::setRedirect($redirect);

//dd($redirect->back());
//dd($redirect->to('/'));
//dd($redirect->route('test', ['fg'])->getTargetUrl());

// use redirect
// return $redirect->home();
// return $redirect->back();
// return $redirect->to('/');
try {
    // Dispatch the request through the router
    $response = $router->dispatch($request);

    // Send the response back to the browser
    $response->send();
} catch (NotFoundHttpException $e) {
    header("Location: /error.php?err=404", 302);
}
