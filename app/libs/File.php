<?php

namespace App\Libs;

/*
 * В данном классе всё реализовано мною,
 * могут быть бока :(
 */

class File {
    private $file;
    private $content;

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

    private function open($file)
    {
        if (file_exists(__ROOT__ . "/resource/$file")) {
            $this->file = __ROOT__ . "/resource/$file";
            $this->content = file_get_contents($this->file);
        }
        
        return $this;
    }

    private function put($content)
    {
        if (file_exists($this->file)) {
            $file = fopen($this->file, 'w+');
            fwrite($file, $content);
            fclose($file);
        }
    }

    private function get()
    {
        return $this->content;
    }
}
