<?php
/**
 * @author Ivan Matveev <Redjiks@gmail.com>.
 */

namespace app\Controllers;


use app\Adapters\Templating\ITemplating;
use Illuminate\Database\Capsule\Manager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller
{

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;
    /**
     * @var \Symfony\Component\HttpFoundation\Response
     */
    protected $response;
    /**
     * @var \app\Adapters\Templating\ITemplating
     */
    protected $templating;
    /**
     * @var \Illuminate\Database\Capsule\Manager
     */
    protected $db;


    public function __construct(Request $request, Response $response, ITemplating $templating, Manager $db)
    {

        $this->request = $request;
        $this->response = $response;
        $this->templating = $templating;
        $this->db = $db;
    }

    /**
     * @param $viewFile string name of view file
     * @param array $variables vars to inject into view
     */
    public function render($viewFile, array $variables = [])
    {
        $this->response->setContent($this->templating->render($viewFile, $variables));
    }

} 