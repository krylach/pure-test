<?php

namespace App\Libs;

/*
 * В данном классе всё реализовано мною,
 * могут быть бока :(
 */

class Route {
    private $uri;
    private $controllerMethod;
    private $requestMethod;

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this, $method], $parameters);
    }

    public static function __callStatic($method, $parameters) {
        return call_user_func_array([new self, $method], $parameters);
    }

    private function get($uri, $controllerMethod)
    {
        $this->setUri($uri);
        $this->setControllerMethod('App\Controllers\\' . $controllerMethod);
        $this->setRequestMethod(__FUNCTION__);

        return $this->handler();
    }

    private function post($uri, $controllerMethod)
    {
        $this->setUri($uri);
        $this->setControllerMethod('App\Controllers\\' . $controllerMethod);
        $this->setRequestMethod(__FUNCTION__);

        return $this->handler();
    }

    private function setUri($uri)
    {
        $this->uri = $uri;
    }

    private function setControllerMethod($controllerMethod)
    {
        $this->controllerMethod = explode("::", $controllerMethod);
    }

    private function setRequestMethod($requestMethod)
    {
        $this->requestMethod = mb_strtoupper($requestMethod);
    }

    private function handler()
    {
        try {            
            if ($this->uri == str_replace("?" . \server()->query_string, "", \server()->request_uri)) {
                if ($this->requestMethod == \server()->request_method) {
                    exit(call_user_func_array([new $this->controllerMethod[0], $this->controllerMethod[1]], []));
                }
            }
        } catch (\Throwable $th) {
            exit($th->getMessage());
        }
    }
}
