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
use Exception;

/**
 * Base class for documentation. Responsible for serving documentation
 * about packages.
 *
 * @package Fonto_Documentation
 * @link    https://github.com/kenren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class Base extends ObjectHandler
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Returns package documentation
     *
     * @param  string $class
     * @return mixed
     */
    public function getPackageDocumentation($class)
    {
        $package = null;

        if (isset($this->objects[$class])) {
            $package = substr($this->objects[$class], 1);
        } else {
            $services = $this->di->getCoreServices();

            if (array_key_exists($class, $services)) {
                $package = substr($services[$class]['class'], 1);
            }
        }

        if (null === $package) {
            return false;
        }

        $reflection = new ReflectionClass($package);

        return array(
            'name' => $reflection->name,
            'namespace' => $reflection->getNamespaceName(),
            'doc' => $reflection->getDocComment(),
            'publicMethods' => $reflection->getMethods(ReflectionMethod::IS_PUBLIC),
            'privateMethods' => $reflection->getMethods(ReflectionMethod::IS_PRIVATE),
            'protectedMethods' => $reflection->getMethods(ReflectionMethod::IS_PROTECTED),
        );
    }

    /**
     * Returns documentation for a specific package and their methods.
     *
     * @param  string $package
     * @return array
     */
    public function getPackageMethodsDocumentation($package)
    {
        $info = array();
        $reflection = new ReflectionClass($package);

        foreach ($reflection->getMethods() as $args) {

            if ($args->class == $package) {
                $name = $args->name;
                $rf = $reflection->getMethod($name);

                $info[$name] = array(
                    'name' => $rf->getName(),
                    'doc' => $rf->getDocComment(),
                    'startline' => $rf->getStartLine(),
                    'endline' => $rf->getEndLine(),
                    'isPublic' => $rf->isPublic(),
                    'isProtected' => $rf->isProtected(),
                    'isPrivate' => $rf->isPrivate(),
                );
            }
        }

        ksort($info, SORT_LOCALE_STRING);
        return $info;
    }
}