# phpunctional

Collection of functional experiments on PHP

This repository is meant to hold different experiments on functional programming using PHP.

##DataStore

Contains a Value Store (like an array or vector in some languages) and a Key Value Store (a hash or a map on other languages)
For examples of use, you can check the tests.

```php

    $vs = new Mamoreno\DataStore\ValueStore();
    $vs = $vs->set(1)->set(2)->set(3)->set(4)->set(5)->set(12);
    $evenDouble = $vs->filter(function($e){ return $e % 2 === 0;}) //[2,4,12]
                     ->map(function($e){ return $e * 2; }) //[4,8,24]
                     ->set(8) //[4,8,24,8]
                     ->uniqueValues(); //[4,8,24]
                     
    print_r($evenDouble);
    Array (
        [0] => 4
        [1] => 8
        [2] => 24
    )
     
````

