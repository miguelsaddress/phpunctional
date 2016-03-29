<?php

namespace Mamoreno\Optionals;

class Some extends Option {

    protected $value;

    public function __construct($value) {
        if ($value === none()) return none();
        if (!$value) return none();
        else $this->value = $value;
    }

    public function get() {
       return $this->value;
    }

    public function getOrElse($default) {
       return $this->value;
    }

    public function getOrNull() {
       return $this->value;
    }

    public function map($f) {
        return option(call_user_func($f, $this->value));
    }

    public function flatMap($f) {
        $v = $this->map($f)->get();
        return option($v->get());
    }

    private function flatten($array) {
       $res = array();
       foreach ($array as $key => $value) {
           if (is_array($value)){ $res = array_merge($res, array_flatten($value));}
           else {$res[$key] = $value;}
       }
       return $res;
    }
}
