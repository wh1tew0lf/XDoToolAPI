<?php


namespace wh1tew0lf;

/**
 * Class XDoTool for simplify to work with xdotool from PHP
 * @author Danil Volkov <vlkv.d.a@gmail.com>
 *
 * @method static void getActiveWindow (array $params, array $flags)
 * @method static void getWindowFocus (array $params, array $flags)
 * @method static void getWindowName (array $params, array $flags)
 * @method static void getWindowPid (array $params, array $flags)
 * @method static void getWindowGeometry (array $params, array $flags)
 * @method static void getDisplayGeometry (array $params, array $flags)
 * @method static void search (array $params, array $flags)
 * @method static void selectWindow (array $params, array $flags)
 * @method static array help() Shows all available methods
 * @method static void version (array $params, array $flags)
 * @method static void behave (array $params, array $flags)
 * @method static void behave_screen_edge (array $params, array $flags)
 * @method static void click (array $params, array $flags)
 * @method static void getMouseLocation (array $params, array $flags)
 * @method static void key (array $params, array $flags)
 * @method static void keyDown (array $params, array $flags)
 * @method static void keyUp (array $params, array $flags)
 * @method static void mouseDown (array $params, array $flags)
 * @method static void mouseMove (array $params, array $flags)
 * @method static void mouseMove_relative (array $params, array $flags)
 * @method static void mouseUp (array $params, array $flags)
 * @method static void set_window (array $params, array $flags)
 * @method static void type (array $params, array $flags)
 * @method static void windowActivate (array $params, array $flags)
 * @method static void windowFocus (array $params, array $flags)
 * @method static void windowKill (array $params, array $flags)
 * @method static void windowMap (array $params, array $flags)
 * @method static void windowMinimize (array $params, array $flags)
 * @method static void windowMove (array $params, array $flags)
 * @method static void windowRaise (array $params, array $flags)
 * @method static void windowReParent (array $params, array $flags)
 * @method static void windowSize (array $params, array $flags)
 * @method static void windowUnMap (array $params, array $flags)
 * @method static void set_num_desktops (array $params, array $flags)
 * @method static void get_num_desktops (array $params, array $flags)
 * @method static void set_desktop (array $params, array $flags)
 * @method static void get_desktop (array $params, array $flags)
 * @method static void set_desktop_for_window (array $params, array $flags)
 * @method static void get_desktop_for_window (array $params, array $flags)
 * @method static void get_desktop_viewport (array $params, array $flags)
 * @method static void set_desktop_viewport (array $params, array $flags)
 * @method static void exec (array $params, array $flags)
 * @method static void sleep (array $params, array $flags)
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

    //public static $lastOutput = array();
    private static $debug = true;
    private static $availableMethods = array();

    /**
     * XDoToolAPI constructor. It is singleton
     */
    private function __construct() {}

    /**
     * Updates self::$availableMethods array
     * @throws \Exception
     */
    private static function updateAvailableMethods() {
        $methods = self::help();
        if (!is_array($methods)) {
            throw new \Exception('Did you install xdotool package? Please use sudo apt-get install xdotool or sudo yum install xdotool');
        }
        array_shift($methods);
        self::$availableMethods = $methods;
    }

    /**
     * Realize many magic methods for xdotool
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws \Exception
     */
    public static function __callStatic($name, $arguments) {
        if (empty(self::$availableMethods)) {
            self::$availableMethods = array('help');
            self::updateAvailableMethods();
        } elseif (!in_array($name, self::$availableMethods)) {
            throw new \Exception('Undefined method!');
        }
        $flags = $params = '';
        if (!empty($arguments[0])) {
            $params = implode(' ', $arguments[0]);
        }
        //$params =  ? array() : $arguments[0];
        if (!empty($arguments[1]) && is_array($arguments[1])) {
            $flags = array();
            foreach ($arguments[1] as $arg => $value) {
                if (!is_string($arg)) {
                    $arg = $value;
                }
                $arg = strlen($arg) > 1 ? "--{$arg}" : "-{$arg}";
                $flags[] = "{$arg}='{$value}'";
            }
            $flags = implode(' ', $flags);
        }

        exec("xdotool {$name} {$flags} {$params} " . (self::$debug ? '' : '2>/dev/null'), $output, $ret_val);
        return $ret_val ? $ret_val : $output;
    }

    /**
     * find the window by name then make it active
     * @param string $windowName
     */
    /*public static function activateWindow($windowName) {
        self::run('search --onlyvisible --sync --name "' . $windowName . '" windowactivate');
    }*/

    /**
     * Mouse move to center
     */
    /*public static function mouseCenter() {
        self::run('mousemove --polar 0 0');
    }*/

    /**
     * Type some text
     */
    /*public static function type($text) {
        self::run("type type --delay 253 --clearmodifiers '{$text}'");
    }*/

}
