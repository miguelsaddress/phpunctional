<?php
namespace Mamoreno\DataStore;

class ValueStore implements Interfaces\ValueStore {
	
	use Traits\Store;

	protected $values;
    
    public function __construct(array $data = array()) {
        $this->values = $data;
        return $this;
    }


    /**
     * Sets a value at the end of the collection, returning a new 
     * Store with that new State
     *
     * @param      <type>  $value  value to be stored
     *
     * @return     self
     */
    public function set($value) {
        $this->values[] = $value;
        return new self($this->values);
    }
}