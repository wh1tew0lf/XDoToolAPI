<?php


namespace wh1tew0lf;

/**
 * Class XDoTool for simplify to work with xdotool from PHP
 * @author Danil Volkov <vlkv.d.a@gmail.com>
 */
class XDoToolAPI {
    /**
     * constants for mouse buttons
     */
    const MOUSE_LEFT_CLICK      = 1;
    const MOUSE_MIDDLE_CLICK    = 2;
    const MOUSE_RIGHT_CLICK     = 3;
    const MOUSE_WHEEL_UP        = 4;
    const MOUSE_WHEEL_DOWN      = 5;

    public static $lastOutput = array();

    /**
     * run command using xdotool
     * @param string $command
     * @return int
     */
    public static function run($command) {
        self::$lastOutput = array();
        exec('xdotool ' . $command, self::$lastOutput, $return_var);
        return $return_var;
    }

    /**
     * find the window by name then make it active
     * @param string $windowName
     */
    public static function activateWindow($windowName) {
        self::run('search --onlyvisible --sync --name "' . $windowName . '" windowactivate');
    }

    /**
     * press $key, $key may include many keys separate by '+'
     * @param string $key
     */
    public static function key($key) {
        self::run('key ' . $key);
    }

    /**
     * make some mouse action (click or mouse wheel)
     * use MOUSE_* - constants
     * @param string $action
     */
    public static function mouse($action) {
        self::run('click ' . $action);
    }

    /**
     * Mouse move relative
     * @param int $x x offset
     * @param int $y y offset
     */
    public static function mouseMove($x, $y) {
        self::run('mousemove_relative -- ' . $x . ' ' . $y);
    }

    /**
     * Mouse move relative in polar coordinates
     * @param int $angle
     * @param int $radius
     */
    public static function mouseMovePolar($angle, $radius) {
        self::run('mousemove_relative -p ' . $angle . ' ' . $radius);
    }

    /**
     * Mouse move to center
     */
    public static function mouseCenter() {
        self::run('mousemove --polar 0 0');
    }

    /**
     * Type some text
     */
    public static function type($text) {
        self::run("type type --delay 253 --clearmodifiers '{$text}'");
    }

}
