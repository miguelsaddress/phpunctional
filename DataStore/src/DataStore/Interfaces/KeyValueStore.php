<?php
namespace Mamoreno\DataStore\Interfaces;

interface KeyValueStore {
    public function set($key, $value);
	public function get($key);
	public function getOrElse($key, $else);
    
    public function keys();
    public function mapKeepKeys(\Closure $f);
    public function filterKeepKeys(\Closure $f);
    public function uniqueValuesKeepKeys();
    public function reverseKeepKeys();
}