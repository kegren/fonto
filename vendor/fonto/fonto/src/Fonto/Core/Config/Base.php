<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core\Config;

use Fonto\Core\FontoException;


abstract class Base
{
    /**
     * @var array
     */
    protected $paths = array();

    /**
     * @var
     */
    protected $extension;


    public function __construct(array $options = array())
    {
        $this->setOptions($options);
    }

    protected function setOptions($options)
    {
        $this->paths = $options['paths'];
        $this->extension = $options['extension'];
    }

    /**
     * @param $file
     * @return bool|string
     */
    protected function isFound($file)
    {
        foreach ($this->paths as $path) {
            $filePath = $path . $file . $this->extension;

            if (file_exists($filePath) and is_readable($filePath)) {
                return $filePath;
            }
        }
        return false;
    }
}