<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include_once 'sys/inc/start.php';
$doc = new document ();

$widgets = (array)ini::read(H . '/sys/ini/widgets.ini'); // получаем список виджетов

foreach ($widgets as $widget_name => $show) {
    if (!$show) {
        continue; // если стоит отметка о скрытии, то пропускаем
    }
    $widget = new widget(H . '/sys/widgets/' . $widget_name); // открываем
    $widget->display(); // отображаем
}

// test by Sanek_OS9