<?php

use Mamoreno\Optionals\Some;
use Mamoreno\Optionals\None;
// use Mamoreno\Optionals\Option;

class OptionalsTest extends PHPUnit_Framework_TestCase {

    public function testPotpurri() {
        //I know, it is horrible, but its a first approach
        
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


        $this->assertEquals($a->get(), none());
        $this->assertEquals($a->getOrElse(5), 5);

        $this->assertEquals($b->get(), 4);
        $this->assertEquals($b->getOrElse(23), 4);

        $this->assertEquals($c->get(), 3);
        $this->assertEquals($c->getOrElse(23), 3);

        $this->assertEquals($d->get(), 4);
        $this->assertEquals($d->getOrElse(23), 4);

        $this->assertEquals($e->get(), none());
        $this->assertEquals($e->getOrElse(5), 5);

        $this->assertEquals($f->get(), array(7,8,9,10));
        $this->assertEquals($f->getOrElse(23), array(7,8,9,10));


        $this->assertEquals($a->isDefined(), false);
        $this->assertEquals($b->isDefined(), true);
        $this->assertEquals($c->isDefined(), true);
        $this->assertEquals($d->isDefined(), true);
        $this->assertEquals($e->isDefined(), false);
        $this->assertEquals($f->isDefined(), true);

        $this->assertEquals($a->isEmpty(), true);
        $this->assertEquals($b->isEmpty(), false);
        $this->assertEquals($c->isEmpty(), false);
        $this->assertEquals($d->isEmpty(), false);
        $this->assertEquals($e->isEmpty(), true);
        $this->assertEquals($f->isEmpty(), false);

        $this->assertTrue($chainedFlatMapOfNone == none());
        $this->assertEquals($chainedFlatMapOfNone->get(), none());
        $this->assertEquals($chainedFlatMapOfNone->getOrElse(5), 5);
        $this->assertEquals($chainedFlatMapOfNone->getOrNull(), null);

        $this->assertTrue($chainedFlatMapOfSome == some(14));
        $this->assertEquals($chainedFlatMapOfSome->get(), 14);
        $this->assertEquals($chainedFlatMapOfSome->getOrElse(5), 14);
        $this->assertEquals($chainedFlatMapOfSome->getOrNull(), 14);

        $this->assertTrue($nestedFlatMapsOfNone == none());
        $this->assertEquals($nestedFlatMapsOfNone->get(), none());
        $this->assertEquals($nestedFlatMapsOfNone->getOrElse(5), 5);
        $this->assertEquals($nestedFlatMapsOfNone->getOrNull(), null);

        $this->assertTrue($nestedFlatMapsOfSomeToSome == some(105454556));
        $this->assertEquals($nestedFlatMapsOfSomeToSome->get(), 105454556);
        $this->assertEquals($nestedFlatMapsOfSomeToSome->getOrElse(5), 105454556);
        $this->assertEquals($nestedFlatMapsOfSomeToSome->getOrNull(), 105454556);

        $this->assertTrue($nestedFlatMapsOfSomeToSomeWithMapReturningOptional == some(some(105454556)));
        $this->assertTrue($nestedFlatMapsOfSomeToSomeWithMapReturningOptional->get() == some(105454556));
        $this->assertTrue($nestedFlatMapsOfSomeToSomeWithMapReturningOptional->getOrElse(5) == some(105454556));
        $this->assertTrue($nestedFlatMapsOfSomeToSomeWithMapReturningOptional->getOrNull() == some(105454556));

        $this->assertTrue($nestedFlatMapsOfSomeToSomeWithMap == some(105454556));
        $this->assertEquals($nestedFlatMapsOfSomeToSomeWithMap->get(), 105454556);
        $this->assertEquals($nestedFlatMapsOfSomeToSomeWithMap->getOrElse(5), 105454556);
        $this->assertEquals($nestedFlatMapsOfSomeToSomeWithMap->getOrNull(), 105454556);

        $this->assertTrue($nestedFlatMapsOfSomeToNone == none());
        $this->assertEquals($nestedFlatMapsOfSomeToNone->get(), none());
        $this->assertEquals($nestedFlatMapsOfSomeToNone->getOrElse(5), 5);
        $this->assertEquals($nestedFlatMapsOfSomeToNone->getOrNull(), null);


    }
}