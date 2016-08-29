#!/usr/bin/php
<?php
require_once 'XDoTool.php';
require_once 'XDoToolAPI.php';

$xdotool = new \wh1tew0lf\XDoTool();

$xdotool
    ->mouseCenter()
    ->mouseMove(10, 20)
    ->mouseMove(100, -20)
    ->run();

\wh1tew0lf\XDoToolAPI::key('Ctrl');