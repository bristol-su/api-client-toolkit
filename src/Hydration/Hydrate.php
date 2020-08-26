<?php


namespace BristolSU\ApiToolkit\Hydration;

class Hydrate
{

    public $model;

    public $type;

    public $hydrate = [];

    public $replace = [];

    public function array(string $model): self
    {
        $this->type = 'array';
        $this->model = $model;
        return $this;
    }

    public function model(string $model): self
    {
        $this->type = 'model';
        $this->model = $model;
        return $this;
    }

    public function replace(string $old, string $new): self
    {
        $this->replace[$old] = $new;
        return $this;
    }

    public function child(string $key, Hydrate $hydrate): self
    {
        $this->hydrate[$key] = $hydrate;
        return $this;
    }

    public static function new()
    {
        return new static();
    }

    public function hydrate($subject)
    {
        return Hydrator::hydrate($subject, $this);
    }

}
