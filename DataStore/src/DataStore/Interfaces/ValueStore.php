<?php
namespace Mamoreno\DataStore\Interfaces;

interface ValueStore {
    public function set($value);
	public function get($index);
	public function getOrElse($index, $else);
}
