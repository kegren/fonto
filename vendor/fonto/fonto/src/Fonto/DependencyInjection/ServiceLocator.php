<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_DependencyInjection
 * @link     https://github.com/kegren/fonto
 * @version  0.6
 */

namespace Fonto\DependencyInjection;

use Fonto\DependencyInjection\ServiceBuilder;
use Fonto\Application\Facade;

class ServiceLocator extends ServiceBuilder
{
    protected $services = array();

    /**
     * Returns an object based on service name.
     *
     * @param  string $service
     * @return mixed
     */
    public function get($service)
    {
        $service = strtolower($service);

        if (isset($this->services[$service])) {
            return new $service();
        }

        if ($core = $this->getCore($service)) {
            return $this->resolveObject($core);
        }

        return false;
    }

    /**
     * Checks if a given class is registered as a core service.
     * Returns array containing information about the class.
     *
     * @param  string $service
     * @return mixed
     */
    public function getCore($service)
    {
        $core = $this->getCoreServiceFile();

        if (array_key_exists($service, $core)) {
            return $core[$service];
        }

        return false;
    }

    /**
     * Returns core services for Fonto.
     *
     * @return array
     */
    public function getCoreServiceFile()
    {
        return include __DIR__ . '/services.php';
    }
}
