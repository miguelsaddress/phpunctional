<?php

/**
 * It tests both Store trait and ValueStore class
 * */

class ValueStoreTest extends PHPUnit_Framework_TestCase {
	
	public function testSet() {
		$vs = new Mamoreno\DataStore\ValueStore();
		$vs = $vs->set(1)->set(2)->set(3);
		$this->assertEquals($vs->values(), [1,2,3]);
	}

	public function testGet() {
		$vs = new Mamoreno\DataStore\ValueStore();
		$vs = $vs->set(1)->set(2)->set(3);
		$this->assertEquals($vs->get(1), 2);
	}

	public function testGetOrElse() {
		$vs = new Mamoreno\DataStore\ValueStore();
		$vs = $vs->set(1)->set(2)->set(3);
		$this->assertEquals($vs->getOrElse(1, 42), 2);
		$this->assertEquals($vs->getOrElse(10, 42), 42);
	}

	public function testMap() {
		$vs = new Mamoreno\DataStore\ValueStore();
		$vs = $vs->set(1)->set(2)->set(3)->map(function($e){ return $e * 2;});
		$this->assertEquals($vs->values(), [2,4,6]);

		$vs = new Mamoreno\DataStore\ValueStore();
		$vs = $vs->set(1)->set(2)->set(3)->map(function($e){ return [$e * 2]; });
		$this->assertEquals($vs->values(), [[2],[4],[6]]);
	}

	public function testFlatMap() {
		$vs = new Mamoreno\DataStore\ValueStore();
		$vs = $vs->set(1)->set(2)->set(3)->flatMap(function($e){ return [$e * 2];});
		$this->assertEquals($vs->values(), [2,4,6]);

		$vs = new Mamoreno\DataStore\ValueStore();
		$vs = $vs->set(1)->set(2)->set(3)->flatMap(function($e){ return $e * 2;});
		$this->assertEquals($vs->values(), [2,4,6]);
	}

	public function testFilter() {
		$vs = new Mamoreno\DataStore\ValueStore();
		$vs = $vs->set(1)->set(2)->set(3);
		$even = $vs->filter(function($e){ return $e % 2 === 0;});
		$this->assertEquals($even->values(), [2]);

		$odd = $vs->filter(function($e){ return $e % 2 !== 0;});
		$this->assertEquals($odd->values(), [1,3]);
	}

	public function testFlatten() {
		$vs = new Mamoreno\DataStore\ValueStore();
		$vs = $vs->set([1, [2,3], 4])->set([5])->set([6,7])->set(8)->set([9,10])->flatten();
		$this->assertEquals($vs->values(), [1,2,3,4,5,6,7,8,9,10]);
	}

	public function testUniqueValues() {
		$vs = new Mamoreno\DataStore\ValueStore();
		$vs = $vs->set(2)->set(2)->set(2);
		$this->assertEquals($vs->values(), [2,2,2]);
		$this->assertEquals($vs->uniqueValues(), [2]);
	}

	public function testFoldLeft() {
		$vs = new Mamoreno\DataStore\ValueStore();
		$vs = $vs->set(2)->set(2)->set(2);
		$fold = $vs->fold(0, function($carry, $item){
			return $carry + $item;
		});
		$this->assertEquals($fold, 6);
	}

	public function testReverse() {
		$vs = new Mamoreno\DataStore\ValueStore();
		$vs = $vs->set(1)->set(2)->set(3)->reverse();
		$this->assertEquals($vs->values(), [3,2,1]);
	}
}