<?php


namespace wh1tew0lf;

/**
 * Class XDoTool for simplify to work with xdotool from PHP
 * @author Danil Volkov <vlkv.d.a@gmail.com>
 *
 * For more detailed help see man xdotool
 *
 * @method static string getActiveWindow() Returns id of active window
 * @method static string getWindowFocus()  Returns id of focused window like getActiveWindow()
 * @method static string getWindowName(string $windowID) Returns name by window id (get from getActiveWindow)
 * @method static string getWindowPid(string $windowID) Returns PID by window id (get from getActiveWindow) may be doesn't work
 * @method static array getWindowGeometry(string $windowID) @todo parse output, use --shell
 * @method static array getDisplayGeometry() @todo parse output, use --shell
 * @method static array|string|int search (array $options, array $params) A powerful function for search window returns array of founded window ids
 * Available options for search method [class, classname, maxdepth=N, name, onlyvisible, pid=PID, screen=N, desktop=N, limit=N, title, all, any, sync]
 * @method static string selectWindow() Return window id after click on it @attention it is INTERACTIVE!
 * @method static array help() Shows all available methods
 * @method static string version() Returns version
 * @method static void behave (array $options = array(), array $params) fire command after some action
 * action can be [mouse-enter, mouse-leave, mouse-click, focus, blur], in params should be <windowID> <action> <command>
 * @method static void behave_screen_edge (array $params, array $flags) Fire command after move mouse in screen edge [options] <edge> <command>
 * edges can be [left, top-left, top, top-right, right, bottom-left, bottom, bottom-right]
 * options can be [delay=MILLISECONDS, quiesce=MILLISECONDS]
 * @method static void click(array $options, int $button) Imitate mouse click
 * options [clearmodifiers, repeat=REPEAT, delay=MILLISECONDS, window=ID]
 * @method static array getMouseLocation() @todo parse output, use --shell
 * @method static void key(array $options, array|string $keystroke) Imitate keyboard click
 * options [clearmodifiers, delay=MILLISECONDS, window=ID]
 * @method static void keyDown(array $options, array|string $keystroke) Imitate only key down action
 * options [clearmodifiers, delay=MILLISECONDS, window=ID]
 * @method static void keyUp(array $options, array|string $keystroke) Imitate only key up action
 * options [clearmodifiers, delay=MILLISECONDS, window=ID]
 * @method static void mouseDown(array $options, int $button) Imitate only mouse down action
 * options [clearmodifiers, repeat=REPEAT, delay=MILLISECONDS, window=ID]
 * @method static void mouseMove(array $options, array|string $coordinates) Move mouse $coordinates = [x,y] or 'restore',
 * options: [window=ID, polar, screen=SCREEN, clearmodifiers, sync]
 * @method static void mouseMove_relative(array $options, array|string $coordinates) Move the mouse x,y pixels relative to the current position of the mouse cursor
 * options: [window=ID, polar, screen=SCREEN, clearmodifiers, sync]
 * @method static void mouseUp(array $options, int $button) Imitate only mouse up action options [clearmodifiers, repeat=REPEAT, delay=MILLISECONDS, window=ID]
 * @method static void set_window(array $options, string $windowID) Set properties about a window
 * options [name=newname, icon-name=newiconname, role=newrole, classname=newclassname, class=newclass, overrideredirect=value]
 * @method static void type(array $options, string $text) Types as if you had typed it. Supports newlines and tabs (ASCII newline and tab)
 * options [window=ID, delay=milliseconds, clearmodifiers]
 * @method static void windowActivate(array $options, string $windowID) Activate the window. This command is different from windowfocus: if the window is on another desktop, we will switch to that desktop
 * options [sync]
 * @method static void windowFocus(array $options, string $windowID) Focus window
 * options [sync]
 * @method static void windowKill(array $options = array(), string $windowID) Kill a window. This action will destroy the window and kill the client controlling it
 * @method static void windowMap(array $options, string $windowID) Map a window. In X11 terminology, mapping a window means making it visible on the screen
 * options [sync]
 * @method static void windowMinimize(array $options, string $windowID) Minimize a window. In X11 terminology, this is called iconify
 * options [sync]
 * @method static void windowMove(array $options, array $params) Move the window to the given position in params [windowID, x, y]
 * optinos [sync, relative]
 * @method static void windowRaise(array $options = array(), string $windowID) Raise the window to the top of the stack. This may not work on all window managers
 * @method static void windowReParent(array $options = array(), array $windows) Reparent a window. This moves the source_window to be a child window of destination_window
 * $windows = [child windowID, new parent windowID]
 * @method static void windowSize(array $options, array $params) Set the window size of the given window in params [windowID, height, width]
 * optinos [usehints, sync]
 * @method static void windowUnMap(array $options, string $windowID) Unmap a window, making it no longer appear on your screen
 * options [sync]
 * @method static void set_num_desktops(array $options = array(), int $number) Changes the number of desktops or workspaces
 * @method static string get_num_desktops() Returns number of desktop
 * @method static void set_desktop(array $options, int $number) Change the current view to the specified desktop
 * options [relative]
 * @method static string get_desktop() Returns the current desktop in view
 * @method static void set_desktop_for_window(array $options, array $params) Move a window to a different desktop params [windowID, desctopnum]
 * @method static void get_desktop_for_window(array $options, string $windowID) Output the desktop currently containing the given window
 * @method static array get_desktop_viewport() @todo parse output, use --shell
 * @method static void set_desktop_viewport(array $options, array $coordinates) Move the viewport to the given position $coordinates [x, y]
 * @method static void exec(array $options, string $command) Execute a program. This is often useful when combined with behave_screen_edge to do things like locking your screen
 * options [sync]
 * @method static void sleep(array $options = array(), int $seconds) Sleep for a specified period. Fractions of seconds (like 1.3, or 0.4) are valid, here
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
            var_dump(self::$availableMethods);
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
        }
        if (!empty($arguments[1])) {
            $params = is_array($arguments[1]) ? implode(' ', $arguments[1]) : $arguments[1];
            if ('mousemove_relative' == $name) {
                $params = "-- {$params}";
            }
        }

        echo "xdotool {$name} {$flags} {$params} " . (self::$debug ? '' : '2>/dev/null') . "\n";

        exec("xdotool {$name} {$flags} {$params} " . (self::$debug ? '' : '2>/dev/null'), $output, $ret_val);
        if ($ret_val) {
            return (int)$ret_val;
        }
        return (1 == count($output)) ? array_pop($output) : $output;
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
