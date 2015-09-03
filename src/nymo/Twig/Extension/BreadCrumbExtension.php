<?php
/**
 * This file is part of silex-twig-breadcrumb-extension
 *
 * (c) 2014 Gregor Panek
 */
namespace nymo\Twig\Extension;

use Silex\Application;

/**
 * Class BreadCrumbExtension
 * @package nymo\Twig\Extension
 * @author Gregor Panek <gp@gregorpanek.de>
 */
class BreadCrumbExtension extends \Twig_Extension
{

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var string
     */
    protected $separator;

    /**
     * @param \Silex\Application $app.
     * @param string $separator
     */
    public function __construct(Application $app, $separator=null)
    {
        $this->app = $app;
        //set options
        $this->separator = '>';
        if(isset($separator)){
            $this->separator = $separator;
        }
        //create loader to load base template which can be overridden by user
        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../../Resources/Views');
        //add loader
        $this->app['twig.loader']->addLoader($loader);
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'renderBreadCrumbs' => new \Twig_Function_Method($this, 'renderBreadCrumbs', array('is_safe' => array('html')))
        );
    }

    /**
     * Returns the rendered breadcrumb template
     * @return string
     */
    public function renderBreadCrumbs()
    {

        return $this->app['twig']->render(
            'breadcrumbs.html.twig',
            array(
                'breadcrumbs' => $this->app['breadcrumbs']->getItems(),
                'separator' => $this->separator
            )
        );

    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'renderBreadCrumbs';
    }


}
