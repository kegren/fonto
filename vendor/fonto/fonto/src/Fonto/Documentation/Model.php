<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Documentation
 * @link     https://github.com/kenren/fonto
 * @version  0.5
 */

namespace Fonto\Documentation;

use Fonto\Application\ObjectHandler;
use ReflectionClass;
use ReflectionMethod;

/**
 * Gets all models. Shows both form models and 'regular'
 * models.
 *
 * @package Fonto_Documentation
 * @link    https://github.com/kenren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class Model extends ObjectHandler
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Returns all models
     *
     * @return array
     */
    public function getAll()
    {
        $iterator = new \RecursiveDirectoryIterator(MODELPATH);
        $riterator = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::SELF_FIRST);
        $models = array();

        // Loops through all files
        foreach ($riterator as $file) {
            // Skips directories
            if ($file->isDir()) {
                continue;
            }

            $path = $file->getPathname(); // Path
            $class = substr($path, strpos($path, ACTIVE_APP)); // Strips out everything before namespace

            if (strpos($class, '.php') !== false) {
                $class = substr($class, 0, strpos($class, ".php")); // Removes extension
            } else {
                continue;
            }

            $reflection = new ReflectionClass($class);
            $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

            foreach ($methods as $method) {
                if ($method->class == $class) {
                    $models[$class][] = $method->name; // Adds all methods
                }
            }

            // Sets correct type
            if (strpos($class, 'Entity') !== false) {
                $models[$class]['type'] = 'Entity';
            }

            if (strpos($class, 'Form') !== false) {
                $models[$class]['type'] = 'FormModel';
            }
        }

        return $models;
    }

}