<?php

namespace App\Extensions\Twig;

class TwigFilters extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('get_env', [$this, 'getEnv']),
        ];
    }

    public function getEnv($variable)
    {
        return getenv($variable);
    }
}
