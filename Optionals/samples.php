<?php

require_once 'bootstrap.php';

use Mamoreno\Optionals\Some;
use Mamoreno\Optionals\Option;
// use Mamoreno\Optionals\None;

$a = option(null);
$b = option(4);
$c = new Some(3);
$d = some(4);
$e = none();
$f = some(array(7,8,9,10));

$chainedFlatMapOfNone = $a->flatMap(function($e) { return Some($e + 10);}); //none
$chainedFlatMapOfSome = $b->flatMap(function($e) { return Some($e + 10);}); //Some(14)

$ffaa = $chainedFlatMapOfNone->flatMap(function($e) { return Some($e + 10);}); //none
$ffbb = $chainedFlatMapOfSome->flatMap(function($e) { return Some($e + 10);});


$nestedFlatMapsOfNone = $a->flatMap(function($e) { return Some($e + 105454545);})
                          ->flatMap(function($e) { return Some($e + 10 - 3);}); //none

$nestedFlatMapsOfSomeToSome = $b->flatMap(function($e) { return Some($e + 105454545);})
                                ->flatMap(function($e) { return Some($e + 10 - 3);}); //Some(105454556)

$nestedFlatMapsOfSomeToSomeWithMapReturningOptional = $b->flatMap(function($e) { return Some($e + 105454545);})
                                                        ->flatMap(function($e) { return Some($e + 10 - 3);})
                                                        ->map(function($e) { return option($e);}); //Some(105454556)

$nestedFlatMapsOfSomeToSomeWithMap = $b->flatMap(function($e) { return Some($e + 105454545);})
                                       ->flatMap(function($e) { return Some($e + 10 - 3);})
                                       ->map(function($e) { return $e;}); //Some(105454556)

$nestedFlatMapsOfSomeToNone = $b->flatMap(function($e) { return Some($e + 105454545);})
                                ->flatMap(function($e) { return Some($e + 10 - 3);})
                                ->map(function($e) { return option(null);}); //None



forcePrint($a);
forcePrint($b);
forcePrint($c);
forcePrint($d);
forcePrint($e);
forcePrint($f);


forcePrint($chainedFlatMapOfNone);
forcePrint($chainedFlatMapOfSome);
forcePrint($nestedFlatMapsOfNone);
forcePrint($nestedFlatMapsOfSomeToSomeWithMap);
forcePrint($nestedFlatMapsOfSomeToSome);
forcePrint($nestedFlatMapsOfSomeToSomeWithMapReturningOptional);
forcePrint($nestedFlatMapsOfSomeToNone);

function forcePrint(Option $o) {
  $v = $o->get();
  if (is_array($v)) {
    $v = "[" . implode(",", $v) . "]";
  }
  $m = sprintf("The value of the [%s] is [%s]", get_class($o), $v);
  echo $m, PHP_EOL;
}