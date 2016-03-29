<?php

use Mamoreno\Optionals\Some;
use Mamoreno\Optionals\None;

function option($value) {
    if ($value !== none() && isset($value)) return some($value);
    else return none();
}

function none() {
    static $n;
    if (!$n) $n = new None();
    return $n;
}

function some($v) {
    if ($v) return new Some($v);
    else throw new InvalidArgumentException("Value for some must not be falsy. [$v] given");    
}
