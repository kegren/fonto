<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Config
 * @link     https://github.com/kegren/fonto
 * @version  0.2
 */

namespace Fonto\Config;

class Config
{
    /**
     * Configuration file
     *
     * @var string
     */
    protected $file = null;

    /**
     * Returns a file if found else the nullable above.
     *
     * @param  string  $file
     * @param  boolean $return
     * @return Fonto\Config
     */
    public function grab($file, $return = false)
    {
        if ($file = $this->getFile($file)) {
            $this->file = $file;
        }

        if ($return) {
            return $this->file;
        }

        return $this;
    }

    /**
     * Returns a specific key in the array.
     *
     * @param  string $option
     * @return mixed
     */
    public function get($option)
    {
        if ($this->file) {
            return isset($this->file[$option]) ? $this->file[$option] : null;
        }

        return null;
    }

    /**
     * Returns a file if found else false
     *
     * @param  string $file
     * @return mixed
     */
    protected function getFile($file)
    {
        $file = CONFIGPATH . '/' . $file . '.php';

        return file_exists($file) ? include $file : false;
    }

}