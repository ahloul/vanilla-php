<?php

namespace App\infra;




class Controller
{
    protected $params;

    public function __construct()
    {
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $urlComponents = parse_url($url);
        parse_str($urlComponents['query'], $params);
        $this->params = $params;

    }

}
