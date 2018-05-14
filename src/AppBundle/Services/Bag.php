<?php
namespace AppBundle\Services;

class Bag
{
    private $_name;

    /**
     * @param string $name
     *
     * @return self;
     */
    public function __construct($name)
    {
        if (!isset($_SESSION[$name])) {
            $_SESSION[$name] = null;
        }

        $this->_name = $name;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return void
     */
    public function set($key, $value)
    {
        $_SESSION[$this->_name][$key] = $value;
    }

    /**
     * @param array $values
     *
     * @return void
     */
    public function setArray($values)
    {
        foreach ($values as $key => $value) {
            $_SESSION[$this->_name][$key] = $value;
        }
    }

    /**
     * @param string $key
     *
     * @return void
     */
    public function delete($key = null) {
        if ($key !== null && isset($_SESSION[$this->_name][$key])) {
            unset($_SESSION[$this->_name][$key]);
            return;
        }

        unset($_SESSION[$this->_name]);
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get($key = null)
    {
        if ($key !== null) {
            return isset($_SESSION[$this->_name][$key])
                ? $_SESSION[$this->_name][$key]
                : null;
        }

        return isset($_SESSION[$this->_name])
            ? $_SESSION[$this->_name]
            : null;
    }
}
