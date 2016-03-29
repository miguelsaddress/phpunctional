<?php

namespace Mamoreno\Optionals;

// require_once 'optionals.php';

abstract class Option {
    protected $value;

    public function __construct($value) {
        if (isset($value)) return some($value);
        else return none();
    }

    public function __toString() {
        return get_called_class();
    }

    public function isDefined() {
        return !!isset($this->value);
    }

    public function isEmpty() {
        return !$this->isDefined();
    }

    abstract public function map($f);

    abstract public function flatMap($f);
}
