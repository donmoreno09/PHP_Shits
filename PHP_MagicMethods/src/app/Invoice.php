<?php

namespace App;

class Invoice
{

    protected float $amount;

    public function __construct($amount = 0.0)
    {
        $this->amount = $amount;
    }

    public function __get($name)
    {
        if(property_exists($this, $name)) {
            return $this->$name;
        }

        return null;
    }

    public function __set($name, $value)
    {
        if(property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            throw new \Exception("Property {$name} does not exist.");
        }
    }
}