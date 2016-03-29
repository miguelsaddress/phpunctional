<?php

class KeyValueStoreTest extends PHPUnit_Framework_TestCase {

	
	public function testKeys() {
		$vs = new Mamoreno\DataStore\KeyValueStore();
		$vs = $vs->set("foo", 1)->set("bar", 2)->keys();
		$this->assertEquals($vs, ["foo", "bar"]);		
	}

    public function testSet() {
		$vs = new Mamoreno\DataStore\KeyValueStore();
		$vs = $vs->set("foo", 1)->set("bar", 2)->values();
		$this->assertEquals($vs, ["foo"=>1, "bar"=>2]);
    }

    public function testGet() {
		$vs = new Mamoreno\DataStore\KeyValueStore();
		$vs = $vs->set("foo", 1)->set("bar", 2)->get("foo");
		$this->assertEquals($vs, 1);
    }

    public function testMapKeepKeys() {
		$vs = new Mamoreno\DataStore\KeyValueStore();
		$vs = $vs->set("foo", 1)->set("bar", 2)->mapKeepKeys(function($e){ return $e * 2;});
		$this->assertEquals($vs->values(), ["foo" => 2, "bar" => 4]);

		$vs = new Mamoreno\DataStore\KeyValueStore();
		$vs = $vs->set("foo", 1)->set("bar", 2)->mapKeepKeys(function($e){ return [$e * 2]; });
		$this->assertEquals($vs->values(),["foo" => [2], "bar" => [4]]);
    }

    public function testFilterKeepKeys() {
		$vs = new Mamoreno\DataStore\KeyValueStore();
		$vs = $vs->set("foo", 1)->set("bar", 2)->set("baz", 3);

		$even = $vs->filterKeepKeys(function($e){ return $e % 2 === 0;});
		$this->assertEquals($even->values(), ["bar" => 2]);

		$odd = $vs->filterKeepKeys(function($e){ return $e % 2 !== 0;});
		$this->assertEquals($odd->values(),["foo" => 1, "baz" => 3]);
    }

    public function testUniqueValuesKeepKeys() {
		$vs = new Mamoreno\DataStore\KeyValueStore();
		$vs = $vs->set("foo", 2)->set("bar", 2)->set("baz", 2);
		$unique = $vs->uniqueValuesKeepKeys();
		$this->assertEquals($unique,["foo" => 2]);
    }

    public function testReverseKeepKeys() {
        $vs = new Mamoreno\DataStore\KeyValueStore();
        $vs = $vs->set("a",1)->set("b",2)->set("c",3)->reverseKeepKeys();
        $this->assertEquals($vs->values(), ["c" => 3, "b" => 2, "a" => 1]);
    }
}