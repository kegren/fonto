<?php
/**
 * Home controller
 */

namespace Demo\Controller;

use Fonto\Controller\Base;
use Fonto\Documentation\Controller as Controllers;
use Fonto\Documentation\Model as Models;
use Fonto\Documentation\Package as Packages;
use Fonto\Documentation\Base as DocBase;

class Home extends Base
{
    public $restful = true;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getIndexAction()
    {
        $controllers = new Controllers();
        $models = new Models();
        $packages = new Packages();

        $data = array(
            'title' => 'Fonto PHP Framework',
            'text' => 'Under development',
            'baseUrl' => $this->url()->baseUrl(),
            'controllers' => $controllers->getAll(),
            'models' => $models->getAll(),
            'services' => $packages->getCoreServices(),
            'objects' => $packages->getCoreObjects()
        );

        return $this->view()->render('home/index', $data);
    }

    /**
     * @param  string $class
     * @return bool
     */
    public function getDocumentationAction($class)
    {
        $doc = new DocBase();
        $packages = new Packages();

        $classDoc = $doc->getPackageDocumentation($class);

        if (empty($classDoc)) {
            return false;
        }

        return $this->view()->render(
            'home/documentation',
            array(
                'title' => 'Fonto PHP Framework',
                'text' => 'Under development',
                'baseUrl' => $this->url()->baseUrl(),
                'services' => $packages->getCoreServices(),
                'objects' => $packages->getCoreObjects(),
                'classDoc' => $classDoc,
                'methodsDoc' => $doc->getPackageMethodsDocumentation()
            )
        );
    }
}