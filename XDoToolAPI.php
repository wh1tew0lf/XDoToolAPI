<?php


namespace wh1tew0lf;

/**
 * Class XDoToolAPI PHP wrapper for xdotool version 3.20140217.1
 * @author Danil Volkov <vlkv.d.a@gmail.com>
 *
 * For more detailed help see man xdotool
 * You can omit the $options if they are not needed, for example:
 * @example set_window($windowID) instead of set_window(array $options, string $windowID = false)
 *
 * @method static string getActiveWindow() Returns id of active window
 * @method static string getWindowFocus()  Returns id of focused window like getActiveWindow()
 * @method static string getWindowName(string $windowID) Returns name by window id (get from getActiveWindow)
 * @method static string getWindowPid(string $windowID) Returns PID by window id (get from getActiveWindow) may be doesn't work
 * @method static array getWindowGeometry(string $windowID) Returns the geometry (location and position) of a window. The values include: x, y, width, height, and screen number
 * @method static array getDisplayGeometry() Returns the screen resolution width and height
 * @method static array|string|int search (array $options, array|string $params) A powerful function for search window returns array of founded window ids
 * Available options for search method [class, classname, maxdepth=N, name, onlyvisible, pid=PID, screen=N, desktop=N, limit=N, title, all, any, sync]
 * @method static string selectWindow() Return window id after click on it @attention it is INTERACTIVE!
 * @method static array help() Shows all available methods
 * @method static string version() Returns version
 * @method static void behave (string $windowID, string $action, string $command) fire command after some action
 * action can be [mouse-enter, mouse-leave, mouse-click, focus, blur], in params should be <windowID> <action> <command>
 * @method static void behave_screen_edge(array $options, string $edge, string $command) Fire command after move mouse in screen edge [options] <edge> <command>
 * edges can be [left, top-left, top, top-right, right, bottom-left, bottom, bottom-right]
 * options can be [delay=MILLISECONDS, quiesce=MILLISECONDS]
 * @method static void click(array|int $options, int|bool $button = false) Imitate mouse click
 * options [clearmodifiers, repeat=REPEAT, delay=MILLISECONDS, window=ID]
 * @method static array getMouseLocation() Outputs the x, y, screen, and window id of the mouse cursor
 * @method static void key(array|string $options, array|string|bool $keystroke = false) Imitate keyboard click
 * options [clearmodifiers, delay=MILLISECONDS, window=ID]
 * @method static void keyDown(array|string $options, array|string|bool $keystroke = false) Imitate only key down action
 * options [clearmodifiers, delay=MILLISECONDS, window=ID]
 * @method static void keyUp(array|string $options, array|string|bool $keystroke = false) Imitate only key up action
 * options [clearmodifiers, delay=MILLISECONDS, window=ID]
 * @method static void mouseDown(array|int $options, int|bool $button = false) Imitate only mouse down action
 * options [clearmodifiers, repeat=REPEAT, delay=MILLISECONDS, window=ID]
 * @method static void mouseMove(array|int $options, int $x, int|bool $y = false) Move mouse use [x,y] or 'restore',
 * options: [window=ID, polar, screen=SCREEN, clearmodifiers, sync]
 * @method static void mouseMove_relative(array|int $options, int $x, int|bool $y = false) Move the mouse x,y pixels relative to the current position of the mouse cursor
 * options: [window=ID, polar, screen=SCREEN, clearmodifiers, sync]
 * @method static void mouseUp(array|int $options, int|bool $button = false) Imitate only mouse up action options [clearmodifiers, repeat=REPEAT, delay=MILLISECONDS, window=ID]
 * @method static void set_window(array|string $options, string|bool $windowID = false) Set properties about a window
 * options [name=newname, icon-name=newiconname, role=newrole, classname=newclassname, class=newclass, overrideredirect=value]
 * @method static void type(array|string $options, string|bool $text = false) Types as if you had typed it. Supports newlines and tabs (ASCII newline and tab)
 * options [window=ID, delay=milliseconds, clearmodifiers]
 * @method static void windowActivate(array|string $options, string|bool $windowID = false) Activate the window. This command is different from windowfocus: if the window is on another desktop, we will switch to that desktop
 * options [sync]
 * @method static void windowFocus(array|string $options, string|bool $windowID = false) Focus window
 * options [sync]
 * @method static void windowKill(string $windowID) Kill a window. This action will destroy the window and kill the client controlling it
 * @method static void windowMap(array|string $options, string|bool $windowID = false) Map a window. In X11 terminology, mapping a window means making it visible on the screen
 * options [sync]
 * @method static void windowMinimize(array|string $options, string|bool $windowID = false) Minimize a window. In X11 terminology, this is called iconify
 * options [sync]
 * @method static void windowMove(array|string $options, string $windowID, int $x, int|bool $y = false) Move the window to the given position
 * optinos [sync, relative]
 * @method static void windowRaise(string $windowID) Raise the window to the top of the stack. This may not work on all window managers
 * @method static void windowReParent(string $childWindowID, string $newParentWindowID) Reparent a window. This moves the source_window to be a child window of destination_window
 * $windows = [child windowID, new parent windowID]
 * @method static void windowSize(array|string $options, string $windowID, int $height, int|bool $width = false) Set the window size of the given window
 * optinos [usehints, sync]
 * @method static void windowUnMap(array|string $options, string|bool $windowID = false) Unmap a window, making it no longer appear on your screen
 * options [sync]
 * @method static void set_num_desktops(int $number) Changes the number of desktops or workspaces
 * @method static string get_num_desktops() Returns number of desktop
 * @method static void set_desktop(array|int $options, int|bool $number = false) Change the current view to the specified desktop
 * options [relative]
 * @method static string get_desktop() Returns the current desktop in view
 * @method static void set_desktop_for_window(array|string $options, string $windowID, int|bool $desktop = false) Move a window to a different desktop
 * @method static string get_desktop_for_window(array|string $options, string|bool $windowID = false) Output the desktop currently containing the given window
 * @method static array get_desktop_viewport() Report the current viewport's position
 * @method static void set_desktop_viewport(array|int $options, int $x, int|bool $y = false) Move the viewport to the given position
 * @method static void exec(array|string $options, string|bool $command = false) Execute a program. This is often useful when combined with behave_screen_edge to do things like locking your screen
 * options [sync]
 * @method static void sleep(int $seconds) Sleep for a specified period. Fractions of seconds (like 1.3, or 0.4) are valid, here
 * @version 1.0.1
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

    /** @var bool $debug Show STDERR of xdotool or not */
    private static $debug = true;
    /** @var array $availableMethods Array with all available methods, that returned from xdotool help */
    private static $availableMethods = array();
    /** @var array $shellParse methods that output should be parsed */
    private static $shellParse = array('getwindowgeometry', 'getdisplaygeometry', 'getmouselocation', 'get_desktop_viewport');

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
        foreach ($methods as &$method) {
            $method = trim($method);
        }
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
        $name = strtolower($name);
        if (empty(self::$availableMethods)) {
            self::$availableMethods = array('help');
            self::updateAvailableMethods();
        } elseif (!in_array($name, self::$availableMethods)) {
            throw new \Exception("Undefined method '{$name}'!");
        }
        $flags = $params = '';
        if (!empty($arguments[0]) && is_array($arguments[0])) {
            $flags = array();
            foreach ($arguments[0] as $arg => $value) {
                if (is_string($arg)) {
                    $arg = strlen($arg) > 1 ? "--{$arg}" : "-{$arg}";
                    $flags[] = "{$arg}='{$value}'";
                } else {
                    $arg = $value;
                    $arg = strlen($arg) > 1 ? "--{$arg}" : "-{$arg}";
                    $flags[] = "{$arg}";
                }

            }
            $flags = implode(' ', $flags);
            array_shift($arguments);
        }
        if (!empty($arguments)) {
            $params = '"' . implode('" "', is_array($arguments[0]) ? $arguments[0] : $arguments) . '"';
            if ('mousemove_relative' == $name) {
                $params = "-- {$params}";
            }
        }

        $flags .= in_array($name, self::$shellParse) ? ' --shell' : '';
        echo "xdotool {$name} {$flags} {$params} " . (self::$debug ? '' : '2>/dev/null') . "\n";
        exec("xdotool {$name} {$flags} {$params} " . (self::$debug ? '' : '2>/dev/null'), $output, $ret_val);
        if ($ret_val) {
            return (int)$ret_val;
        }
        if (in_array($name, self::$shellParse)) {
            $parsedOutput = array();
            foreach ($output as $line) {
                $parts = explode('=', $line);
                $key = array_shift($parts);
                $value = array_pop($parts);
                $parsedOutput[$key] = $value;
            }
            return $parsedOutput;
        }
        return (1 == count($output)) ? array_pop($output) : $output;
    }

    /**
     * Mouse move to center
     */
    public static function mouseCenter() {
        self::mouseMove(array('polar'), 0, 0);
    }

    /**
     * Imitate left click
     */
    public static function leftClick() {
        self::click(self::MOUSE_LEFT_CLICK);
    }

    /**
     * Imitate right click
     */
    public static function rightClick() {
        self::click(self::MOUSE_RIGHT_CLICK);
    }

}
