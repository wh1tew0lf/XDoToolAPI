<?php
namespace wh1tew0lf;

/**
 * Class XDoTool for simplify to work with xdotool from PHP
 * It can be used dynamically with chains
 * @author Danil Volkov <vlkv.d.a@gmail.com>
 */
class XDoTool {
    /**
     * constants for mouse buttons
     */
    const MOUSE_LEFT_CLICK      = 1;
    const MOUSE_MIDDLE_CLICK    = 2;
    const MOUSE_RIGHT_CLICK     = 3;
    const MOUSE_WHEEL_UP        = 4;
    const MOUSE_WHEEL_DOWN      = 5;

    private $_commands = array();

    private $_output = array();

    /**
     * XDoToolAPI constructor.
     */
    public function __construct() {
        $this->_commands = array();
    }

    /**
     * run command using xdotool
     * @return XDoTool
     */
    public function run() {
        $this->_output = array();
        foreach ($this->_commands as $command) {
            exec('xdotool ' . $command, $output, $return_var);
            $this->_output[] = array(
                'command' => $command,
                'output' => $output,
                'return_var' => $return_var
            );
        }
        $this->_commands = array();
        return $this;
    }

    /**
     * @param array $params
     */
    public function search($params = array()) {

    }

    /**
     * find the window by name then make it active
     * @param string $windowName
     * @return XDoTool
     */
    public function activateWindow($windowName) {
        $this->_commands[] = 'search --name "' . $windowName . '" windowactivate';
        return $this;
    }

    /**
     * press $key, $key may include many keys separate by '+'
     * @param string $key
     * @return XDoTool
     */
    public function key($key) {
        $this->_commands[] = 'key ' . $key;
        return $this;
    }

    /**
     * make some mouse action (click or mouse wheel)
     * use MOUSE_* - constants
     * @param string $action
     * @return XDoTool
     */
    public function mouse($action) {
        $this->_commands[] = 'click ' . $action;
        return $this;
    }

    /**
     * Mouse move relative
     * @param int $x x offset
     * @param int $y y offset
     * @return XDoTool
     */
    public function mouseMove($x, $y) {
        $this->_commands[] = 'mousemove_relative ' . $x . ' ' . $y;
        return $this;
    }

    /**
     * Mouse move relative in polar coordinates
     * @param int $angle
     * @param int $radius
     * @return XDoTool
     */
    public function mouseMovePolar($angle, $radius) {
        $this->_commands[] = 'mousemove_relative -p ' . $angle . ' ' . $radius;
        return $this;
    }

    /**
     * Mouse move to center
     * @return XDoTool
     */
    public function mouseCenter() {
        $this->_commands[] = 'mousemove --polar 0 0';
        return $this;
    }
}