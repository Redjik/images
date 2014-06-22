<?php
/**
 * @author Ivan Matveev <Redjiks@gmail.com>.
 */

namespace app\Core;


use app\Adapters\Templating\ITemplating;
use app\Adapters\Templating\TwigAdapter;
use app\Controllers\DefaultController;
use Illuminate\Database\Capsule\Manager;
use Pimple\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BaseContainer
 * @package app\Core
 *
 * @property Request $request
 * @property ITemplating $templating
 * @property Response $response
 * @property Manager $db
 * @property DefaultController $controller
 *
 *
 */
class BaseContainer extends Container
{
    public function __construct(array $values = array())
    {
        parent::__construct($values);
        foreach ($this->coreComponents() as $id => $component) {
            if (!$this->offsetExists($id)){
                $this->offsetSet($id,$component);
            }
        }
    }

    /**
     * Getter for container
     * @param $value
     * @return mixed
     */
    public function __get($value)
    {
        return $this->offsetGet($value);
    }

    protected function coreComponents()
    {
        return [
            'dbName' => 'undefined',
            'dbUser' => 'undefined',
            'dbPass' => 'undefined',
            'viewPath' => APP_PATH.'/Views/',
            'charset' => 'utf-8',
            'db' => function(BaseContainer $c)
                {
                    $capsule = new Manager();
                    $capsule->addConnection([
                            'driver'    => 'mysql',
                            'host'      => 'localhost',
                            'database'  => $c['dbName'],
                            'username'  => $c['dbUser'],
                            'password'  => $c['dbPass'],
                            'charset'   => 'utf8',
                            'collation' => 'utf8_unicode_ci',
                            'prefix'    => '',
                        ]);
                    $capsule->bootEloquent();
                    return $capsule;
                },
            'request' => function(BaseContainer $c)
                {
                    return Request::createFromGlobals();
                },
            'templating' => function(BaseContainer $c)
                {
                    $loader = new \Twig_Loader_Filesystem([$c['viewPath']]);
                    return new TwigAdapter(
                        new \Twig_Environment($loader,[
                            'charset'=>$c['charset'],
                            'autoescape'=>true
                        ])
                    );
                },
            'response' => function(BaseContainer $c)
                {
                    return new Response();
                },
            'controller' => function(BaseContainer $c)
                {
                    return new DefaultController($c->request,$c->response,$c->templating, $c->db);
                },

        ];
    }
} 