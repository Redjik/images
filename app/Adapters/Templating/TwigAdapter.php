<?php
/**
 * @author Ivan Matveev <Redjiks@gmail.com>.
 */

namespace app\Adapters\Templating;


class TwigAdapter implements ITemplating
{
    protected  $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }


    /**
     * @param $viewFile string
     * @param array $variables
     * @return string
     */
    public function render($viewFile, array $variables = [])
    {
        return $this->twig->render($viewFile,$variables);
    }
}