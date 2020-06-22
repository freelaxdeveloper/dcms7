<?php

$router->get('/chat_mini/{name}', [
    'uses' => 'HomeController@index',
    'as' => 'test',
]);