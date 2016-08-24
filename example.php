#!/usr/bin/php
<?php
require_once 'XDoTool.php';

$xdotool = new \wh1tew0lf\XDoTool();

$xdotool
    ->mouseCenter()
    ->mouseMove(10, 20)
    ->mouseMove(100, -20)
    ->run();