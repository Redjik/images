<?php
/**
 * @author Ivan Matveev <Redjiks@gmail.com>.
 */

namespace app\Adapters\Templating;


interface ITemplating
{
    /**
     * @param $viewFile string
     * @param array $variables
     * @return string
     */
    public function render($viewFile,array $variables = []);
} 