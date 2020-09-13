<?php

namespace App\Libs;

/*
 * В данном классе всё реализовано мною,
 * могут быть бока :(
 */

class Request
{
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this, $method], $parameters);
    }

    public static function __callStatic($method, $parameters) {
        return call_user_func_array([new self, $method], $parameters);
    }

    private function get()
    {
        return $this->handler($_GET);
    }

    private function post()
    {
        return $this->handler($_POST);
    }

    private function all()
    {
        return $this->handler($_REQUEST);
    }
    
    private function handler(Array $request)
    {
        $handledRequest = new \stdClass();
        if ($request) {
            foreach ($request as $key => $value) {
                if (is_string($value)) {
                    $handledRequest->$key = htmlspecialchars($value);
                } else {
                    $handledRequest->$key = $value;
                }
            }
        }

        return $handledRequest;
    }
}

