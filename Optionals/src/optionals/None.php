<?php

namespace Mamoreno\Optionals;

class None extends Option {

    protected $value;

    public function __construct() { 
        $this->value = null;
    }

    public function get() {
       return none();
    }

    public function getOrElse($default) {
       return $default;
    }

    public function toString() {
        return "None";
    }

    public function getOrNull() {
       return null;
    }

    public function map($f) {
        return none();
    }

    public function flatMap($f) {
        return none();
    }

}