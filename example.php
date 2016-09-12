#!/usr/bin/php
<?php
require_once 'XDoToolAPI.php';

$windowID = \wh1tew0lf\XDoToolAPI::getActiveWindow();
var_dump(\wh1tew0lf\XDoToolAPI::getWindowName($windowID));
var_dump(\wh1tew0lf\XDoToolAPI::getWindowPid($windowID));
var_dump(\wh1tew0lf\XDoToolAPI::getWindowGeometry($windowID));
var_dump(\wh1tew0lf\XDoToolAPI::getDisplayGeometry());
var_dump(\wh1tew0lf\XDoToolAPI::search(array('onlyvisible', 'name'), 'chrome'));
var_dump(\wh1tew0lf\XDoToolAPI::getMouseLocation());
\wh1tew0lf\XDoToolAPI::mouseMove_relative(-10, -15);
var_dump(\wh1tew0lf\XDoToolAPI::type("ls -l\n"));
var_dump(\wh1tew0lf\XDoToolAPI::windowActivate($windowID));
var_dump(\wh1tew0lf\XDoToolAPI::windowMinimize($windowID));
var_dump(\wh1tew0lf\XDoToolAPI::get_num_desktops());
var_dump(\wh1tew0lf\XDoToolAPI::get_desktop());
var_dump(\wh1tew0lf\XDoToolAPI::get_desktop_for_window($windowID));
var_dump(\wh1tew0lf\XDoToolAPI::get_desktop_viewport());
var_dump(\wh1tew0lf\XDoToolAPI::windowRaise($windowID));
var_dump(\wh1tew0lf\XDoToolAPI::sleep(1.5));
\wh1tew0lf\XDoToolAPI::windowKill($windowID);

echo "Done\n";