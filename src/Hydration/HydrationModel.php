<?php

namespace BristolSU\ApiToolkit\Hydration;

abstract class HydrationModel
{

    private $attributes;

    public static function createFromArray(array $array): HydrationModel
    {
        $model = new static();
        foreach($array as $key => $value) {
            $model->set($key, $value);
       }
        return $model;
    }

    public function set(string $key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function get(string $key, $default = null)
    {
        if(array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }
        return $default;
    }

    public function __set(string $key, $value)
    {
        $this->set($key, $value);
    }

    public function __get(string $key)
    {
        return $this->get($key, null);
    }

}
