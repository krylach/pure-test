<?php

namespace App\Libs;

/*
 * В данном классе всё реализовано мною,
 * могут быть бока :(
 */

class Response {
    private $response;
    private $headers;

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

    private function code($code)
    {
        if (is_numeric($code)) {
            http_response_code($code);
        }

        return $this;
    }

    private function headers(Array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    private function make($response = null)
    {
        $this->handler();

        return $response;
    }

    private function show($template, $parameters = [])
    {
        $blade = new \Philo\Blade\Blade(__ROOT__ . '/resource/views', __ROOT__ . '/resource/cache');

        return $this->make($blade->view()->make($template, $parameters)->render());
    }

    private function json($response = null)
    {
       header("Content-Type: application/json");

        return $this->make(json_encode($response));
    }

    private function handler()
    {
        if ($this->headers) {
            if (is_array($this->headers)) {
                foreach ($this->headers as $key => $value) {
                    if ($key && $value) {
                        header($key . ": " . $value);
                    }
                }
            }   
        }
    }
}
